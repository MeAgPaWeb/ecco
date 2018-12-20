<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Solicitation;
use AppBundle\Entity\Library;
use AppBundle\Entity\Room;
use AppBundle\Entity\DataLogger;

/**
 * User controller.
 *
 * @Route("/ajax")
 */
class AjaxController extends Controller
{
    /** Para aceptar o cancelar solicitudes
     * @Route("/follower_managment", name="ajax_follower_managment")
     * @Method({"POST"})
     */
    public function ajaxFollowerManagmentAction(Request $request)
    {
        $request = Request::createFromGlobals();
        $id = $request->request->get('_follower');
        $libraryId = $request->request->get('_library');
        $action = $request->request->get('_action');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneById($id);
        $library = $em->getRepository('AppBundle:Library')->findOneById($libraryId);
        $follower = $em->getRepository('AppBundle:Solicitation')->findOneBy(array('user' => $user, 'library' => $library));
        if ($action == 'accepted'){
          $follower->changeToAccepted();
          $message = "Su solicitud de seguimiento a la biblioteca ha sido aceptada.";
          $em->persist($follower);
          $em->flush();
        }elseif($action == 'canceled'){
          $message = "Su solicitud de seguimiento a la biblioteca ha sido rechazada.";
          $em->remove($follower);
          $user->removeFollowing($follower);
          $em->persist($user);
          $em->flush();
        }else{
          $response = array("code" => 200, "success" => false, "action" => $action);
          return new Response(json_encode($response));
        }
        $emailFollower=array(
                'subject'=> 'Solicitud de seguimiento de biblioteca',
                'email'=> $follower->getUser()->getEmail(),
                'user' => $follower->getUser(),
                'message' => $message
            );
        $this->sendEmail($emailFollower, 'email_solicitation');

        $response = array("code" => 200, "success" => true, "action" => $action);
        return new Response(json_encode($response));

        //Acá debería enviar el email notificando si se acepto o se rechazó la solicitud al $follower->getUser()
    }

    private function sendEmail($email, $view){
         $message = $this->get('EmailHandler')->getMessage( $email['email'],
                                                            $email['user'],
                                                            $email['message'],
                                                            $email['subject'], $view);
         $failures = "No se pudo enviar el email a la casilla de correo especificada";
         $mailer = $this->container->get('mailer');
         $mailer->send($message, $failures);
     }

    /**
     * @Route("/following_managment/{library}", name="ajax_following_managment")
     * @Method({"GET", "POST"})
     */
    public function ajaxFollowingManagmentAction(Library $library = null)
    {
        $request = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $solicitation = new Solicitation();
        $solicitation->setUser($this->getUser());
        $solicitation->setLibrary($library);
        $em->persist($solicitation);
        $em->flush();
        $emailFollower=array(
                'subject'=> 'Solicitud de seguimiento de biblioteca',
                'email'=> $this->getUser()->getEmail(),
                'user' => $this->getUser(),
                'message' => "Su solicitud de seguimiento a la biblioteca ".$library->getName()." se encuentra pendiente de aceptación."
            );
        $emailOwner=array(
                'subject'=> 'Solicitud de seguimiento de biblioteca',
                'email'=> $library->getOwner()->getEmail(),
                'user' => $library->getOwner(),
                'message' => "El usuario ".$this->getUser()->getUsername()." ha solicitado seguir a la biblioteca ".$library->getName().".
                            Puede aceptar o rechazar esta solicitud desde el panel de administración."
            );

        $this->sendEmail($emailFollower, 'email_solicitation');
        $this->sendEmail($emailOwner, 'email_solicitation');

        if($request->request->get('_ajax')){
          $response = array("code" => 200, "success" => true, "data" => "alta");
          return new Response(json_encode($response));
        }else{
          return $this->redirectToRoute('library_index');
        }
    }

    /**
     * @Route("/data/temperature", name="ajax_data_temperature")
     * @Method({"POST"})
     */
    public function ajaxDataTemperatureAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $room=$em->getRepository('AppBundle:Room')->findOneById($request->request->get('_room'));
        $first = new \DateTime('@'.$request->request->get('_first'));
        $last = new \DateTime('@'.$request->request->get('_last'));
        $registros= $em->getRepository('AppBundle:DataLogger')->getDataLoggersValid($room, $first->format("Y-m-d H:i:s"), $last->format("Y-m-d H:i:s"), true);
        $limit ="[";
        $promedio ="[";
        $valor ="[";
        foreach ($registros as $reg) {
            $datetime=$reg->getDate()->format("U");
            $datetime=$datetime*1000;
            $limit.= "[".$datetime.", ".$reg->getTopLimitT().", ".$reg->getBottonLimitT()."],";
            $promedio.= "[".$datetime.", ".$reg->getMeanAvT()."],";
            $valor.="[".$datetime.", ".$reg->getTemperature()."],";
        }
        $limit =substr($limit, 0, -1);
        $promedio =substr($promedio, 0, -1);
        $valor =substr($valor, 0, -1);
        $limit .="]";
        $promedio .="]";
        $valor .="]";
        $data = array(
          'limits' => $limit,
          'promedio' => $promedio,
          'valor' => $valor
        );
        $response = array("code" => 200, "success" => true, "data" => $data);
        return new Response(json_encode($response));
    }

    /**
     * @Route("/data/humidity", name="ajax_data_humidity")
     * @Method({"POST"})
     */
    public function ajaxDataHumiditiAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $room=$em->getRepository('AppBundle:Room')->findOneById($request->request->get('_room'));
        $first = new \DateTime('@'.$request->request->get('_first'));
        $last = new \DateTime('@'.$request->request->get('_last'));
        $registros= $em->getRepository('AppBundle:DataLogger')->getDataLoggersValid($room, $first, $last, true);

        $limit ="[";
        $promedio ="[";
        $valor ="[";
        foreach ($registros as $reg) {
            $datetime=$reg->getDate()->format("U");
            $datetime=$datetime*1000;
            $limit.= "[".$datetime.", ".$reg->getTopLimitH().", ".$reg->getBottonLimitH()."],";
            $promedio.= "[".$datetime.", ".$reg->getMeanAvH()."],";
            $valor.="[".$datetime.", ".$reg->getRh()."],";
        }
        $limit =substr($limit, 0, -1);
        $promedio =substr($promedio, 0, -1);
        $valor =substr($valor, 0, -1);
        $limit .="]";
        $promedio .="]";
        $valor .="]";
        $data = array(
          'limits' => $limit,
          'promedio' => $promedio,
          'valor' => $valor
        );
        $response = array("code" => 200, "success" => true, "data" => $data);
        return new Response(json_encode($response));
    }


    /**
     * @Route("/data/fechasCargadas", name="ajax_data_date")
     * @Method({"POST"})
     */
    public function ajaxDataDateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $room=$em->getRepository('AppBundle:Room')->findOneById($request->request->get('_room'));
        $first= $em->getRepository('AppBundle:DataLogger')->getFirstDate($room, true);
        if (isset($first['date'])) {
          $last= $em->getRepository('AppBundle:DataLogger')->getLastDate($room, true);
          $data = array(
            'first' => $first['date']->format('Y-m-d'),
            'last' => $last['date']->format('Y-m-d')
          );
          $success = true;
        }else{
          $data = array();
          $success=false;
        }
        $response = array("code" => 200, "success" => $success, "data" => $data);
        return new Response(json_encode($response));
    }
}
