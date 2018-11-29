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
        $action = $request->request->get('_action');
        $em = $this->getDoctrine()->getManager();
        $follower = $em->getRepository('AppBundle:Solicitation')->findOneByUser($id);
        if ($action == 'accepted'){
          $follower->changeToAccepted();
          $message = "Su solicitud de seguimiento a la biblioteca ha sido aceptada.";
        }elseif($action == 'canceled'){
          $follower->changeToCanceled();
          $message = "Su solicitud de seguimiento a la biblioteca ha sido rechazada.";
          $em->remove($follower);
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

        $em->persist($follower);
        $em->flush();
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
        $registros= $em->getRepository('AppBundle:DataLogger')->findBy(array('room'=>$room, 'enabled'=>true), $limit = 50);
        $data = array(
          'limits' => array(),
          'promedio' => array(),
          'valor' => array()
        );
        foreach ($registros as $reg) {
            $data['limits'][]= array($reg->getDate()->format("U"), $reg->getTopLimitT(),$reg->getBottonLimitT());
            $data['promedio'][]= array($reg->getDate()->format("U"), $reg->getMeanAvT());
            $data['valor'][]= array($reg->getDate()->format("U"), $reg->getTemperature());
        }

        $response = array("code" => 200, "success" => true, "data" => $data);
        return new Response(json_encode($response));
    }
}
