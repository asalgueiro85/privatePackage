<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/olg", name="homepage")
     *
     */
    public function index_OLDAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/new", name="homepagenew")
     */
    public function pruebaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:User')->findAll();
dump($entities);die;
        return array(
            'entities' => $entities,
        );

    }

    /**
     * @Route("/", name="app_front_default")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Default:frontend_homepage.html.twig');
    }


    /**
     * @Route("/switch-language",name="app_front_switch_language")
     */
    public function switchAction()
    {
        $request = $this->get('request');
        $uri = $request->query->get('uri');
        $locale = $request->query->get('lng',$request->getDefaultLocale());
        $params = $request->query->get('params');
        $params['_locale'] = $locale;
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $user->setLocale($locale);
            $this->get('fos_user.user_manager')->updateUser($user);
        }

        $route = $this->get('router')->match($uri);
        return $this->redirect($this->generateUrl($route['_route'],$params));
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction()
    {        return $this->render('@App/Backend/index.html.twig');

    }

}
