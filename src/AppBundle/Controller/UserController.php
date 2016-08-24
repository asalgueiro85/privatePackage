<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;


class UserController extends Controller
{
    /**
     * Creates a new User entity.
     *
     * @Route("/", name="user_create")
     * @Method("POST")
     * @Template("AppBundle:User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('user_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="user_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new User();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/app_backend", name="app_backend")
     * @Method("GET")
     */
    public function editAction()
    {
        $em = $this->getDoctrine()->getManager();
//dump('asdasd');die;
        $entity = $em->getRepository('AppBundle:User')->find($this->getUser()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);
        $items = $em->getRepository('AppBundle:Action')->myItems($this->getUser()->getId(), 2);
        $trips = $em->getRepository('AppBundle:Action')->myItems($this->getUser()->getId(), 1);
        $notifies = $em->getRepository('AppBundle:Notify')->myNotify($this->getUser()->getId());
        $packets = count($items);
        return $this->render('AppBundle:Backend:index.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
//            'items' => $items,
            'trips' => $trips,
            'notifies' => $notifies,
            'packets' => $packets,
            'foo'=> 1
        ));
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     * @Route("/user_update", name="user_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//dump($request);die;
        $id = $request->get('id');
        $entity = $em->getRepository('AppBundle:User')->find($id);
        $entity->setCountry($request->get('setting_country'));
        $entity->setCity($request->get('setting_city'));
        $entity->setSex($request->get('appbundle_user')['sex']);
//        $entity->setSex($request->get('appbundle_user')['sex']);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
//        dump($editForm);die;
            $picture = $entity->getPicture();
//        dump($picture);die;
//
        if($picture != null){
            $app_utils = $this->container->get('app.utils.utils');
            $locationPicture = $app_utils->loadPicture($picture, 'user',$this->getUser()->getUsername());
            $entity->setPathPicture($locationPicture);
        }

//        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('app_backend'));
//        }


    }
    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
