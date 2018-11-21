<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Solicitation;

/**
 * User controller.
 *
 * @Route("/ajax")
 */
class AjaxController extends Controller
{
    /** Para aceptar o cancelar solicitudes
     * @Route("/follower_managment", name="ajax_follower_managment")
     * @Method(["post","get"])
     */
    public function ajaxFollowerManagmentAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->request->get('_follower');
        $action = $request->request->get('_action');
        $em = $this->getDoctrine()->getManager();
        $follower = $em->getRepository('AppBundle:Solicitation')->find($id);
        if ($action == 'accepted'){
          $follower->changeToAccepted();
        }elseif($action == 'canceled'){
          $follower->changeToCanceled();
        }else{
          $response = array("code" => 200, "success" => false, "data" => $action);
          return new Response(json_encode($response)); 
        }
        $em->persist($follower);
        $em->flush();
        if($request->request->get('_ajax')){
          $response = array("code" => 200, "success" => true, "data" => $action);
          return new Response(json_encode($response));        
        }else{
          return $this->redirectToRoute('library_index');
        }
        //Acá debería enviar el email notificando si se acepto o se rechazó la solicitud al $follower->getUser()
    }
    
    /**
     * @Route("/following_managment", name="ajax_following_managment")
     * @Method("post")
     */
    public function ajaxFollowingManagmentAction()
    {
        $request = Request::createFromGlobals();
        $id_library = $request->request->get('_id_library');
        $library = $em->getRepository('AppBundle:Library')->find($id_library);
        $em = $this->getDoctrine()->getManager();
        $solicitation = new Solicitation();
        $solicitation->setUser($this->getUser());
        $solicitation->setLibrary($library);
        
        $em->persist($solicitation);
        $em->flush();
        
        //Acá debería enviar el email notificando al $library->getOwner() que tiene una solicitud de seguimiento de su biblioteca
        $response = array("code" => 200, "success" => true, "data" => $action);
        return new Response(json_encode($response));        
    }
}
