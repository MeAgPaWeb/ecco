<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Solicitation;
use AppBundle\Entity\Library;
use AppBundle\Entity\User;

class SolicitationController extends Controller
{
  /**
   * Creates a new solicitation entity.
   *
   * @Route("/{solicitation}/new", name="solicitation_new")
   * @Method({"GET", "POST"})
   */
  public function newAction (Library $library, User $user){

    $solicitation = new Solicitation();
    $solicitation->setUser($user);
    $solicitation->setLibrary($library);
    $em = $this->getDoctrine()->getManager();
    $em->persist($solicitation);
    //el seguidor debería agregarse cuando cambie al estado accepted no???
    $em->flush();
    //enviar mail
    $email=array(
            'subject'=> 'Solicitud de seguimiento de biblioteca',
            'email'=> $user->getEmail(),
            'user' => $user,
            'library' => $library
        );
    $this->sendEmail($email, 'email_solicitation');
  }

  private function sendEmail($email, $view){
        $message = $this->get('EmailHandler')->getMessage( $email['email'],
                                                           $email['user'],
                                                           $email['library'],
                                                           $email['subject'], $view);
        $failures = "No se pudo enviar el email a la casilla de correo especificada";
        $mailer = $this->container->get('mailer');
        $mailer->send($message, $failures);
        sleep(2);
    }
}
