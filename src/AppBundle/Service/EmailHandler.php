<?php
namespace AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/*
 * Manejador de envios de emails
 */
class EmailHandler extends Controller{

    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function getMessage($email, $user, $library, $message, $subject, $view='email_solicitation') {
        $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom([$this->container->getParameter('mailer_user') => "Devp"])
                ->setTo($email)
                ->setBody($this->renderView('email/'.$view.'.html.twig', array(
                            'user' => $user,
                            'library' => $library,
                            'message' => $message
                            )),
                    'text/html');
        return $message;
    }
}
