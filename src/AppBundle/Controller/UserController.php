<?php

namespace AppBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;

use AppBundle\Entity\User;
use AppBundle\Entity\UserConfiguration;
use AppBundle\Form\UserType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{

    // /**
    //  * Lists all User entities.
    //  *
    //  * @Route("/", name="user_index")
    //  * @Method("GET")
    //  */
    // public function indexAction()
    // {
    //     $em = $this->getDoctrine()->getManager();
    //
    //     // $users = $em->getRepository('AppBundle:User')->findAll();
    //     $repository = $em->getRepository('AppBundle:User');
    //     $query = $repository->createQueryBuilder('u');
    //
    //     $users = $query->getQuery()->getResult();
    //
    //     return $this->render('user/index.html.twig', array(
    //         'users' => $users,
    //         'visitors' => null
    //     ));
    // }

    /**
     * Lists all User visitors entities.
     *
     * @Route("/visitors", name="user_visitors")
     * @Method("GET")
     */
    public function indexVisitorsAction()
    {
        $em = $this->getDoctrine()->getManager();

        // $users = $em->getRepository('AppBundle:User')->findAll();
        $repository = $em->getRepository('AppBundle:User');
        $query = $repository->createQueryBuilder('u')
                            ->where('u.roles like :role')
                            ->setParameter('role', '%ROLE_VISITOR%');

        $users = $query->getQuery()->getResult();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
            'visitors' => 1
        ));
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $form = $formFactory->createForm(array('edit_roles' => true));
        //$form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->setData($user);

        $form->handleRequest($request);

        $error = null;
        if ($form->isValid()) {

            if ($form['avatar']->getData() AND $error == NULL) {
                $error = $this->get('app.uploader')->imageValidate($form['avatar']->getData());
                if ($error == NULL) {
                    $newAvatarName = $this->get('app.uploader')->imageUpload($form['avatar']->getData(), $this->getParameter('media')['avatar'], array('width' => $this->getParameter('avatar')['width'], 'height' => $this->getParameter('avatar')['height']));
                    $user->setAvatar($newAvatarName);
                }
            }

            if ($error == NULL){
                $em = $this->getDoctrine()->getManager();
                $special_role = false;
                foreach($form['roles']->getData() as $key => $value){
                    if ($value != 'ROLE_VISITOR'){
                        $special_role = true;
                    }
                    $user->addRole($value);
                }

                if ($special_role){
                    if (!$user->getConfigurations()) {
                        $userConfiguration = new UserConfiguration();
                        $userConfiguration->setLightTheme(false);
                        $userConfiguration->setUser($user);
                        $user->setConfigurations($userConfiguration);
                        $em->persist($userConfiguration);
                        $em->flush();
                    }
                }
                //$event = new FormEvent($form, $request);
                //$dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                return $this->redirectToRoute('user_show', array('id' => $user->getId()));
                //return $response;
            }
        }


        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
            'error' => $error
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", defaults={"id":null }, name="user_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, User $user = null)
    {
        if ($user == null) {
          $user = $this->getUser();
        }
        $error = null;
        $active_tab = null;

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');
        $em = $this->getDoctrine()->getManager();

        $libraries = $em->getRepository('AppBundle:Library')->findBy(array('owner' => $user, 'enabled' => true));
        $solicitations = $em->getRepository('AppBundle:Solicitation')->getLibrariesFollowings($user);
        $libraries_follows=array();
        foreach ($solicitations as $solicitation){
          $libraries_follows[]=$solicitation->getLibrary();
        }
        $msj = null;
        if ($user === $this->getUser()) {

          $editForm = $formFactory->createForm(array('profile' => false));
          $editForm->setData($user);
          $editForm->handleRequest($request);

          $accountForm = $formFactory->createForm(array('profile' => false));
          $accountForm->setData($user);
          $accountForm->handleRequest($request);

          $deleteForm = $this->createDeleteForm($user);

          /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
          $passDispatcher = $this->get('event_dispatcher');

          $passEvent = new GetResponseUserEvent($user, $request);
          $passDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $passEvent);

          if (null !== $passEvent->getResponse()) {
              return $passEvent->getResponse();
          }

          /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
          $passFormFactory = $this->get('fos_user.change_password.form.factory');

          $passForm = $passFormFactory->createForm();
          $passForm->setData($user);

          $passForm->handleRequest($request);

          if ($request->request->get('personal') && $editForm->isSubmitted() && $editForm->isValid()) {
              /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
              $userManager = $this->get('fos_user.user_manager');
              if ($request->request->get('custom_avatar') == 'false') {
                  if (!isset(explode('_gender.jpg', $user->getAvatar())[1])) {
                      $this->get('app.uploader')->imageRemove($user->getAvatar(), $this->getParameter('media')['avatar']);
                  }
                  $user->setAvatar(null);
              } else if ($editForm['avatar']->getData() AND $error == NULL) {
                  $error = $this->get('app.uploader')->imageValidate($editForm['avatar']->getData());
                  if ($error == NULL) {
                      $newAvatarName = $this->get('app.uploader')->imageUpload($editForm['avatar']->getData(), $this->getParameter('media')['avatar'], array('width' => $this->getParameter('avatar')['width'], 'height' => $this->getParameter('avatar')['height']));
                      $user->setAvatar($newAvatarName);
                  }
              }
              $msj = "La informacion personal fue modificada con exito";
              $userManager->updateUser($user);
              $active_tab = 'personal';
          }
          if ($request->request->get('account') && $passForm->isValid()) {
                /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
                $passUserManager = $this->get('fos_user.user_manager');

                $passEvent = new FormEvent($passForm, $request);
                $passDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $passEvent);

                $passUserManager->updateUser($user);

                if (null === $response = $passEvent->getResponse()) {
                    $url = $this->generateUrl('user_show', array('id'=>$user));
                    $response = new RedirectResponse($url);
                }
                $passDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
                $msj="Contraseña modificada con exito";
                $active_tab = 'account';

          }

          if ($request->request->get('account') && $accountForm->isSubmitted() && $accountForm->isValid()) {
              /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
              $userManager = $this->get('fos_user.user_manager');
              $em = $this->getDoctrine()->getManager();
              $userManager->updateUser($user);
              $active_tab = 'account';
          }
        }

        if (!$active_tab) {
          $active_tab = 'bibliotecas';
        }
        $params =  array(
            'profile'          => false,
            'libraries'        => $libraries,
            'libraries_follows'=> $libraries_follows,
            'user'             => $user,
            'msj'             => $msj,
            'error'            => $error,
            'active_tab'       => $active_tab
        );
        if ($user === $this->getUser()) {
          $params['profile'] = true;
          $params['form']=$editForm->createView();
          $params['account_form']  = $accountForm->createView();
          $params['pass_form'] = $passForm->createView();
          $params['delete_form']   = $deleteForm->createView();
        }
        return $this->render('user/profile.html.twig', $params);
    }

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $visitors = $request->request->get('visitors');
        if ($this->getUser()->getId() == $user->getId()) {
            return $this->redirectToRoute('user_show', array('id' => $user->getId(), 'visitors' => $visitors));
        }
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($user->isLocked()){
                $user->setLocked(FALSE);
            }else{
                $user->setLocked(TRUE);
            }

            $em->persist($user);
            $em->flush();
        }
        return $this->redirectToRoute('user_show', array('id' => $user->getId(), 'visitors' => $visitors));
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
