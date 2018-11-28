<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();

      $libraries = $em->getRepository('AppBundle:Library')->findBy(array('owner' => $this->getUser(), 'enabled' => true));
      $solicitations = $em->getRepository('AppBundle:Solicitation')->getLibrariesFollowings($this->getUser());
      $followings=array();
      foreach ($solicitations as $solicitation){
        $followings[]=$solicitation->getLibrary();
      }

      return $this->render('default/index.html.twig', array(
          'libraries' => $libraries,
          'followings' => $followings,
      ));
    }
}
