<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProfileFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\SecurityController as FosController;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class SecurityController extends Controller
{
//    /**
//     * @Route("/app-login")
//     * @Template()
//     */
//    public function loginAction()
//    {
//        $request = $this->container->get('request');
//        /* @var $request \Symfony\Component\HttpFoundation\Request */
//        $session = $request->getSession();
//        /* @var $session \Symfony\Component\HttpFoundation\Session\Session */
//        // last username entered by the user
//        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);
//
//        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
//
//
//        /*return $this->render('CBookAppBundle:Security:login.html.twig', array(
//            'last_username' => $lastUsername,
//            'csrf_token'    => $csrfToken
//        ));*/
//        //return $this->render('AppBundle:Default:frontend_homepage.html.twig');
//
//        return array('last_username'=>$lastUsername, 'csrf_token'=>$csrfToken);
//    }

    /**
     * @Route("/app-login", name="app_login")
     */
    public function loginAction()
    {
        $request = $this->container->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        /* @var $session \Symfony\Component\HttpFoundation\Session\Session */

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

        $template = sprintf('AppBundle:Security:login.html.%s', $this->container->getParameter('fos_user.template.engine'));

        return $this->container->get('templating')->renderResponse($template, array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));
    }

    /**
     * @Route("/app-register", name="app_register")
     * @Template()
     */
    public function registerAction()
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $form = $this->container->get('fos_user.registration.form');


        $user->setEnabled(true);
//        $form = $formFactory;
//        $form->setData($user);
        return $this->render('AppBundle:Security:register.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));
//        return array('form'=>$form->createView());
    }

    /**
     * @Route("/app-login-check", name="app_login_check")
     * @Method("POST")
     */
    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @Route("/app-restore-password", name="app_restore_password")
     * @Method("POST")
     */
    public function restorePasswordAction()
    {
        return $this->loginAction();
    }
//
//    /**
//     * @Route("/app_backend", name="app_backend")
//     */
//    public function editAction()
//    {
//
//        $user = $this->container->get('security.context')->getToken()->getUser();
////        dump(!is_object($user));die;
////        if (!is_object($user) || !$user instanceof UserInterface) {
////            throw new AccessDeniedException('This user does not have access to this section.');
////        }
//
//        $form = $this->container->get('fos_user.profile.form');
//        $formHandler = $this->container->get('fos_user.profile.form.handler');
//
//        $process = $formHandler->process($user);
//        if ($process) {
//            $this->setFlash('fos_user_success', 'profile.flash.updated');
//
//            return new RedirectResponse($this->getRedirectionUrl($user));
//        }
//
//        $em = $this->getDoctrine()->getManager();
//        $items = $em->getRepository('AppBundle:Action')->myItems($this->getUser()->getId(), 2);
//        $trips = $em->getRepository('AppBundle:Action')->myItems($this->getUser()->getId(), 1);
//        $notifies = $em->getRepository('AppBundle:Notify')->myNotify($this->getUser()->getId());
//        $packets = count($items);
////dump($notifies);die;
//        return $this->container->get('templating')->renderResponse(
//            'AppBundle:Backend:index.html.' . $this->container->getParameter('fos_user.template.engine'),
//            array(
//                'form' => $form->createView(),
//                'items' => $items,
//                'trips' => $trips,
//                'notifies' => $notifies,
//                'packets' => $packets,
//            )
//        );
//    }

//    /**
//     * Edits an existing Usuario entity.
//     *
//     * @Route("/user_update", name="user_update")
//     * @Method("PUT")
//     */
//    public function updateAction(Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $id = $request->get('id');
//        $entity = $em->getRepository('AppBundle:User')->find($id);
////        dump($request->get('fos_user_profile_form')['birthDate']);die;
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find Usuario entity.');
//        }
////$a = new DateTime($request->get('fos_user_profile_form')['birthDate']);
////        dump($a);die;
////        $date = new DateTime('2000-01-01');
////        dump($date);die;
//        $entity->setFirstName($request->get('fos_user_profile_form')['firstName']);
////$entity->setBirthDate($request->get('fos_user_profile_form')['birthDate']);
////$entity->setBirthDate($request->get('fos_user_profile_form')['birthDate']);
//        $entity->setLastName($request->get('fos_user_profile_form')['lastName']);
//        $entity->setCity($request->get('fos_user_profile_form')['city']);
//        $entity->setCountry($request->get('fos_user_profile_form')['country']);
//        $entity->setLng($request->get('fos_user_profile_form')['lng']);
//        $entity->setComments($request->get('fos_user_profile_form')['comments']);
////            $factory = $this->get('security.encoder_factory');
////            $encoder = $factory->getEncoder($entity);
////            $password = $encoder->encodePassword($entity->getPassword(),$entity->getSalt());
////            $entity->setPassword($password);
////            $entity->subirFoto();
//        $em->persist($entity);
//        $em->flush();
//
//        return $this->redirect($this->generateUrl('app_backend'));
//
//    }


}
