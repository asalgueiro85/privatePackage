<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notify;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Action;
use AppBundle\Form\ActionType;
use AppBundle\Utils\Utils;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Action controller.
 *
 * @Route("/action")
 */
class ActionController extends Controller
{

    /**
     * Lists all Action entities.
     *
     * @Route("/", name="action")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Action')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all Packet.
     *
     * @Route("/myitems/{type}", name="myitems")
     * @Method("GET")
     */
    public function myItemsAction($type)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Action')->myItems($this->getUser()->getId(), $type);
        if ($type == 2)
            return $this->render('AppBundle:Action:myItems.html.twig', array(
                'entities' => $entities,
            ));
        else
            return $this->render('AppBundle:Action:myTrips.html.twig', array(
                'entities' => $entities,
            ));
    }

    /**
     * Creates a new Action entity.
     *
     * @Route("/backend/search", name="backend_search")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $type = $request->get('type');
        if ($type == 1)
            $packetName = $request->get('appbundle_action')['carryType'];
        else
            $packetName = $request->get('appbundle_action')['packetName'];
        $dateFromTemp = strtotime(str_replace('/', '-', $request->get('appbundle_action')['dateFrom']));
        $dateToTemp = strtotime(str_replace('/', '-', $request->get('appbundle_action')['dateTo']));
        $dateFrom = date('Y-m-d', $dateFromTemp);
        $dateTo = date('Y-m-d', $dateToTemp);
        $em = $this->getDoctrine()->getManager();
        $entity = null;
        $entity = $em->getRepository('AppBundle:Action')->searchActionEntity($packetName, $type, $this->getUser(), $dateFrom, $dateTo);
//dump($entity);die;

        if ($entity == null) {
            $entity = new Action();
            $form = $this->createCreateForm($entity);
            $form->handleRequest($request);
            $type = $request->get('type');
//            if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $countryFrom = $request->get('setting_countryFrom');
            $cityFrom = $request->get('setting_cityFrom');
            $stateFrom = $request->get('setting_stateFrom');
//
            $countryTo = $request->get('setting_countryTo');
            $cityTo = $request->get('setting_cityTo');
            $stateTo = $request->get('setting_stateTo');

            $countryFrom = 'Cuba';
            $cityFrom = 'El Cerro';
            $stateFrom = 'Havana';
//
            $countryTo = 'Cuba';
            $cityTo = 'Varadero';
            $stateTo = 'Matanzas';
//dump($request);die;
            $entity->setState(Action::OPEN);
            $entity->setUser($this->getUser());
            $entity->getDirection()->setCountryFrom($countryFrom);
            $entity->getDirection()->setCountryTo($countryTo);
            $entity->getDirection()->setCityFrom($cityFrom);
            $entity->getDirection()->setCityTo($cityTo);
            $entity->getDirection()->setStateFrom($stateFrom);
            $entity->getDirection()->setStateTo($stateTo);


//            $packetIds = $request->get('id');

            $picture = $entity->getPicture();
            if ($picture != null) {
                $app_utils = $this->container->get('app.utils.utils');
                $locationPicture = $app_utils->loadPicture($picture, $type);
                $entity->setPathPicture($locationPicture);
            }
            $entity->setType($type);
            if ($type == 1)
                $entity->setPacketName(null);
            else
                $entity->setCarryType(null);

            $em->persist($entity);

            $em->flush();
        }
        return $this->search($entity);
    }

    public function search(Action $entity)
    {
//        $countryFrom = $request->get('setting_countryFrom');
//        $cityFrom = $request->get('setting_cityFrom');
//        $stateFrom = $request->get('setting_stateFrom');
////
//        $countryTo = $request->get('setting_countryTo');
//        $cityTo = $request->get('setting_cityTo');
//        $stateTo = $request->get('setting_stateTo');

        $countryFrom = $entity->getDirection()->getCountryFrom();
        $cityFrom = $entity->getDirection()->getCityFrom();
        $stateFrom = $entity->getDirection()->getStateFrom();
//
        $countryTo = $entity->getDirection()->getCountryTo();
        $cityTo = $entity->getDirection()->getCityTo();
        $stateTo = $entity->getDirection()->getStateTo();

        $countryFrom = 'Cuba';
        $cityFrom = 'El Cerro';
        $stateFrom = 'Havana';
//
        $countryTo = 'Cuba';
        $cityTo = 'Varadero';
        $stateTo = 'Matanzas';

//        $weight = $request->get('appbundle_action')['weight'];
//        $volumen = $request->get('appbundle_action')['volumen'];
//        $type = $request->get('type');
        $weight = $entity->getWeight();
        $volumen = $entity->getVolumen();
        $type = $entity->getType();
//        $dateFromTemp = strtotime(str_replace('/', '-', $request->get('appbundle_action')['dateFrom']));
//        $dateToTemp = strtotime(str_replace('/', '-', $request->get('appbundle_action')['dateTo']));
//        $dateFrom = date('Y-m-d',$dateFromTemp);
//        $dateTo = date('Y-m-d',$dateToTemp);

        $dateFrom = $entity->getDateFrom();
        $dateTo = $entity->getDateTo();

//        dump($dateFrom);die;
        //app d-m-Y
        //DB Y-m-d
        $em = $this->getDoctrine()->getManager();
        $trips = $em->getRepository('AppBundle:Action')->packetForNewTrip($countryFrom, $cityFrom, $stateFrom, $countryTo, $cityTo, $stateTo, $volumen, $weight, $type, $this->getUser(), $dateFrom, $dateTo);
//        dump($trips);die;

        if ($type == 2) {
            return $this->render('AppBundle:Action:searchResult.html.twig', array(
                'entities' => $trips,
                'type' => $type,
                'id' => $entity->getId(),
                'packet' => $entity->getPacketName(),
                'weight' => $entity->getWeight(),
                'price' => $entity->getPrice(),
                'countryFrom' => $entity->getDirection()->getCountryFrom(),
                'from' => $entity->getDirection()->getCityFrom() . '-' . $entity->getDirection()->getStateFrom(),
                'countryTo' => $entity->getDirection()->getCountryFrom(),
                'dateFromM' => $entity->getDateFrom()->format("F j"),
                'dateToM' => $entity->getDateTo()->format("F j"),
                'dateFromY' => $entity->getDateFrom()->format("Y"),
                'dateToY' => $entity->getDateTo()->format("Y"),
                'dateFromH' => $entity->getDateFrom()->format("g:i"),
                'dateToH' => $entity->getDateTo()->format("g:i"),
                'to' => $entity->getDirection()->getCityTo() . '-' . $entity->getDirection()->getStateTo(),
            ));
        } else
            return $this->render('AppBundle:Action:searchResultPacket.html.twig', array(
                'entities' => $trips,
                'type' => $type,
                'id' => $entity->getId(),
                'typeCar' => $entity->getCarryType(),
                'weight' => $entity->getWeight(),
                'price' => $entity->getPrice(),
                'countryFrom' => $entity->getDirection()->getCountryFrom(),
                'from' => $entity->getDirection()->getCityFrom() . '-' . $entity->getDirection()->getStateFrom(),
                'countryTo' => $entity->getDirection()->getCountryFrom(),
                'dateFromM' => $entity->getDateFrom()->format("F j"),
                'dateToM' => $entity->getDateTo()->format("F j"),
                'dateFromY' => $entity->getDateFrom()->format("Y"),
                'dateToY' => $entity->getDateTo()->format("Y"),
                'dateFromH' => $entity->getDateFrom()->format("g:i"),
                'dateToH' => $entity->getDateTo()->format("g:i"),
                'to' => $entity->getDirection()->getCityTo() . '-' . $entity->getDirection()->getStateTo(),
            ));
    }

    /**
     * Displays a form to edit an existing Action entity.
     *
     * @Route("/{id}/edit", name="action_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Action')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Action entity.');
        }

        $editForm = $this->createEditForm($entity);
        return $this->render('AppBundle:Action:actionFrontendEdit.html.twig', array(
            'entity' => $entity,
            'type' => $entity->getType(),
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to create a Action entity.
     *
     * @param Action $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Action $entity)
    {
        $form = $this->createForm(new ActionType(), $entity, array(
            'action' => $this->generateUrl('backend_search'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * @Route("/backend/{type}", name="app_back_default",  options={"expose"=true})
     * @Method("GET")
     */
    public function indexBackendAction($type)
    {
        $entity = new Action();
        $form = $this->createCreateForm($entity);
//        if ($type == 1)
//            return $this->render('AppBundle:Action:actionFrontend.html.twig', array(
//                'entity' => $entity,
//                'form' => $form->createView(),
//            ));
//        else
        return $this->render('AppBundle:Action:actionFrontend.html.twig', array(
            'entity' => $entity,
            'type' => $type,
            'form' => $form->createView(),
        ));
//        return $this->render('AppBundle:Action:actionFrontend.html.twig');
    }

    /**
     * Displays a form to edit an existing Action entity.
     *
     * @Route("/{id}/search", name="action_search")
     * @Method("GET")
     */
    public function searchAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Action')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Action entity.');
        }

        return $this->search($entity);
    }

    /**
     * Displays a form to create a new Action entity.
     *
     * @Route("/new/{type}",defaults={"type":"2"}, name="action_new")
     * @Method("GET")
     */
    public function newAction($type)
    {
        $entity = new Action();
        $form = $this->createCreateForm($entity);

        if ($type == 1)
            return $this->render('AppBundle:Action:new_trip.html.twig', array(
                'entity' => $entity,
                'form' => $form->createView(),
            ));
        else
            return $this->render('AppBundle:Action:new.html.twig', array(
                'entity' => $entity,
                'form' => $form->createView(),
            ));


//        return array(
//            'entity' => $entity,
//            'form' => $form->createView(),
//        );
    }

    /**
     * Finds and displays a Action entity.
     *
     * @Route("/{id}", name="action_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Action')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Action entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Creates a form to edit a Action entity.
     *
     * @param Action $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Action $entity)
    {
        $form = $this->createForm(new ActionType(), $entity, array(
            'action' => $this->generateUrl('action_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Action entity.
     *
     * @Route("/{id}", name="action_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Action')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Action entity.');
        }

        $countryFrom = $request->get('setting_countryFrom');
        $cityFrom = $request->get('setting_cityFrom');
        $stateFrom = $request->get('setting_stateFrom');
//
        $countryTo = $request->get('setting_countryTo');
        $cityTo = $request->get('setting_cityTo');
        $stateTo = $request->get('setting_stateTo');
        $type = $request->get('type');


//        $countryFrom = 'Cuba';
//        $cityFrom = 'El Cerro';
//        $stateFrom = 'Havana';
////
//        $countryTo = 'Cuba';
//        $cityTo = 'Varadero';
//        $stateTo = 'Matanzas';
//dump($request);die;
        $entity->getDirection()->setCountryFrom($countryFrom);
        $entity->getDirection()->setCountryTo($countryTo);
        $entity->getDirection()->setCityFrom($cityFrom);
        $entity->getDirection()->setCityTo($cityTo);
        $entity->getDirection()->setStateFrom($stateFrom);
        $entity->getDirection()->setStateTo($stateTo);


//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);

        $editForm->handleRequest($request);
//        dump($editForm);die;
//        dump($editForm);die;
//        if ($editForm->isValid()) {
//        dump($entity);die;
        $entity->setType($type);
        if ($type == 1)
            $entity->setPacketName(null);
        else
            $entity->setCarryType(null);
        $picture = $entity->getPicture();
        if ($picture != null) {
            $app_utils = $this->container->get('app.utils.utils');
            $locationPicture = $app_utils->loadPicture($picture, $type);
            $entity->setPathPicture($locationPicture);
        }
        $em->flush();

//            return $this->redirect($this->generateUrl('myitems'));
        return $this->search($request, $entity);
//        }

//        return $this->redirect($this->generateUrl('myitems'));


    }

    /**
     * Creates a new Action entity.
     *
     * @Route("/{id}/backend/item/edit", name="backend_item_edit")
     * @Method("POST")
     */
    public function edit_updateAction(Request $request, $id)
    {
        $type = $request->get('type');
        if ($type == 1)
            $packetName = $request->get('appbundle_action')['carryType'];
        else
            $packetName = $request->get('appbundle_action')['packetName'];
        $dateFromTemp = strtotime(str_replace('/', '-', $request->get('appbundle_action')['dateFrom']));
        $dateToTemp = strtotime(str_replace('/', '-', $request->get('appbundle_action')['dateTo']));
        $dateFrom = date('Y-m-d', $dateFromTemp);
        $dateTo = date('Y-m-d', $dateToTemp);
        $em = $this->getDoctrine()->getManager();
        $entity = null;
        $entity = $em->getRepository('AppBundle:Action')->searchActionEntity($packetName, $type, $this->getUser(), $dateFrom, $dateTo);
//dump($entity);die;

        if ($entity == null) {
            $entity = new Action();
            $form = $this->createCreateForm($entity);
            $form->handleRequest($request);
            $type = $request->get('type');
//            if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $countryFrom = $request->get('setting_countryFrom');
            $cityFrom = $request->get('setting_cityFrom');
            $stateFrom = $request->get('setting_stateFrom');
//
            $countryTo = $request->get('setting_countryTo');
            $cityTo = $request->get('setting_cityTo');
            $stateTo = $request->get('setting_stateTo');

            $countryFrom = 'Cuba';
            $cityFrom = 'El Cerro';
            $stateFrom = 'Havana';
//
            $countryTo = 'Cuba';
            $cityTo = 'Varadero';
            $stateTo = 'Matanzas';
//dump($request);die;
            $entity->setState(Action::OPEN);
            $entity->setUser($this->getUser());
            $entity->getDirection()->setCountryFrom($countryFrom);
            $entity->getDirection()->setCountryTo($countryTo);
            $entity->getDirection()->setCityFrom($cityFrom);
            $entity->getDirection()->setCityTo($cityTo);
            $entity->getDirection()->setStateFrom($stateFrom);
            $entity->getDirection()->setStateTo($stateTo);

            $entity->setType($type);
            if ($type == 1)
                $entity->setPacketName(null);
            else
                $entity->setCarryType(null);
            $em->persist($entity);

            $em->flush();
        }
        return $this->search($request, $entity);
    }


    /**
     * Deletes a Action entity.
     *
     * @Route("/{id}/delete", name="action_delete", options={"expose"=true})
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Action')->find($id);
        $type = $entity->getType();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Action entity.');
        }

        $em->remove($entity);
        $em->flush();
        return new JsonResponse();

//        return $this->redirect($this->generateUrl('myitems', array('type' => $type)));
    }

    /**
     * Creates a form to delete a Action entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('action_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * razas por especies.
     *
     * @Route("/backend/notify_action", name="notify_action", options={"expose"=true})
     * @Method("POST")
     */
    public function notify_actionAction(Request $request)
    {

        $idPacket = $request->get('idPacket');
        $idTrip = $request->get('idTrip');
        $type = $request->get('type');
//        dump($type);die;
        $em = $this->getDoctrine()->getManager();
        $trip = $em->getRepository('AppBundle:Action')->find($idTrip);
        $packet = $em->getRepository('AppBundle:Action')->find($idPacket);
        $trip->addCarryRequest($packet);
        $notify = new Notify();
//        dump($packet);die;
        if ($type == 1) {
            $notify->setAction($packet);
            $notify->setActionFinal($idTrip);
            $notify->setType(Notify::TYPE_CARRY);
            $notify->setUser($trip->getUser());
            $notify->setNotify('Notificacion generada por un viaje');
        } else {
            $notify->setAction($trip);
            $notify->setActionFinal($idPacket);
            $notify->setType(Notify::TYPE_PACKET);
            $notify->setUser($packet->getUser());
            $notify->setNotify('Notificacion generada por un paquete');
        }
        $notify->setState(Notify::STATE_NEW);

        $em->persist($trip);
        $em->persist($notify);
        $em->flush();
        $response = new JsonResponse();
        return $response;
    }

    /**
     * razas por especies.
     *
     * @Route("/backend/app_back_my_items", name="app_back_my_items", options={"expose"=true})
     * @Method("POST")
     */
    public function app_back_my_itemsAction(Request $request)
    {
//        $countryFrom = $request->get('countryFrom');
        $type = $request->get('type');
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository('AppBundle:Action')->myItems($this->getUser()->getId(), $type);
//        dump($items[0]->getCarryRequest());die;
        $result = array();
        if (!empty($items)) {
            foreach ($items as $item) {
                if ($type == 2)
                    $packet = (string)$item->getPacketName();
                else
                    $packet = (string)$item->getCarryType();
                $result[] = array(
                    'id' => $item->getId(),
                    'type' => $type,
                    'packet' => $packet,
                    'pathPicture' => $item->getPathPicture(),
                    'price' => $item->getPrice(),
                    'price' => $item->getPrice(),
                    'weight' => $item->getWeight(),
                    'observation' => $item->getObservation(),
                    'from' => $item->getDirection()->getCountryFrom() . ',' . $item->getDirection()->getCityFrom(),
                    'to' => $item->getDirection()->getCountryTo() . ',' . $item->getDirection()->getCityTo(),
                    'request' => count($item->getCarryRequest()),
                    'edit_url' => $item->getId() . '/edit',
                    'search_url' => $item->getId() . '/search',
                    'delete_url' => $item->getId() . '/delete'
                );
            }
        }
//        dump($result);die;
        $response = new JsonResponse($result);
        return $response;
    }

    /**
     *
     * @Route("/backend/app_back_my_notify", name="app_back_my_notify", options={"expose"=true})
     * @Method("POST")
     */
    public function app_back_my_notifyAction(Request $request)
    {
//        $countryFrom = $request->get('countryFrom');
        $type = 1;
        $em = $this->getDoctrine()->getManager();
        $notifies = $em->getRepository('AppBundle:Notify')->myNotify($this->getUser()->getId());

        $result = array();
        if (!empty($notifies)) {
            foreach ($notifies as $notify) {
                if ($notify->getType() == 2) {
                    $itemPacket = (string)$notify->getAction()->getPacketName();
                    $myPacket = (string)$notify->getActionFinal()->getCarryType();
                }
                else {
                    $itemPacket = (string)$notify->getAction()->getCarryType();
                    $myPacket = (string)$notify->getActionFinal()->getPacketName();
                }
                $result[] = array(
                    'id' => $notify->getId(),
                    'type' => $notify->getType(),
                    'userName'=> $notify->getUser()->getFirstName().' '.$notify->getUser()->getLastName(),
                    'userNameLoggin' => $notify->getUser()->getUsername(),
                    'userPicture'=> $notify->getUser()->getPathPicture(),
                    'itemPicture'=> $notify->getAction()->getPathPicture(),
                    'itemDateFrom'=> $notify->getAction()->getDateFrom()->format("Y-m-d"),
                    'itemDateTo'=> $notify->getAction()->getDateTo()->format("Y-m-d"),
                    'itemPacket' => $itemPacket,
                    'myPacket' => $myPacket,
                    'myItemPicture' => $notify->getActionFinal()->getPathPicture(),
                    'price' => $notify->getActionFinal()->getPrice(),
                    'observation' => $notify->getAction()->getObservation(),

//                    'pathPicture' => $item->getPathPicture(),
//                    'price' => $item->getPrice(),
//                    'price' => $item->getPrice(),
//                    'weight' => $item->getWeight(),
//                    'observation' => $item->getObservation(),
//                    'from' => $item->getDirection()->getCountryFrom() . ',' . $item->getDirection()->getCityFrom(),
//                    'to' => $item->getDirection()->getCountryTo() . ',' . $item->getDirection()->getCityTo(),
//                    'request' => count($item->getCarryRequest()),
//                    'edit_url' => $item->getId() . '/edit',
//                    'search_url' => $item->getId() . '/search',
//                    'delete_url' => $item->getId() . '/delete'
                );
            }
        }
//        dump($result);die;
        $response = new JsonResponse($result);
        return $response;
    }
}
