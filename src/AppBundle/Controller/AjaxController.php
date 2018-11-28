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
        }elseif($action == 'canceled'){
          $follower->changeToCanceled();
        }else{
          $response = array("code" => 200, "success" => false, "action" => $action);
          return new Response(json_encode($response));
        }
        $em->persist($follower);
        $em->flush();
        $response = array("code" => 200, "success" => true, "action" => $action);
        return new Response(json_encode($response));

        //Acá debería enviar el email notificando si se acepto o se rechazó la solicitud al $follower->getUser()
    }

    private function sendEmail($email, $view){
         $message = $this->get('EmailHandler')->getMessage( $email['email'],
                                                            $email['user'],
                                                            $email['library'],
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
                'library' => $library,
                'message' => "Su solicitud de seguimiento a la biblioteca ".$library->getName()." se encuentra pendiente de aceptación."
            );
        $emailOwner=array(
                'subject'=> 'Solicitud de seguimiento de biblioteca',
                'email'=> $library->getOwner()->getEmail(),
                'user' => $library->getOwner(),
                'library' => $library,
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
}
