<?php

namespace App\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\AdminBundle\Entity\NotificationType;
use App\AdminBundle\Form\NotificationTypeType;

/**
 * NotificationType controller.
 *
 * @Route("/config/notificationtype")
 */
class NotificationTypeController extends Controller
{

    /**
     * Lists all NotificationType entities.
     *
     * @Route("/", name="config_notificationtype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:NotificationType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new NotificationType entity.
     *
     * @Route("/", name="config_notificationtype_create")
     * @Method("POST")
     * @Template("AdminBundle:NotificationType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new NotificationType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha creado un nuevo tipo de notificación.'
            );

            return $this->redirect($this->generateUrl('config_notificationtype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a NotificationType entity.
     *
     * @param NotificationType $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(NotificationType $entity)
    {
        $form = $this->createForm(new NotificationTypeType(), $entity, array(
            'action' => $this->generateUrl('config_notificationtype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrar'));

        return $form;
    }

    /**
     * Displays a form to create a new NotificationType entity.
     *
     * @Route("/new", name="config_notificationtype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new NotificationType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a NotificationType entity.
     *
     * @Route("/{id}", name="config_notificationtype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:NotificationType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NotificationType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing NotificationType entity.
     *
     * @Route("/{id}/edit", name="config_notificationtype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:NotificationType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NotificationType entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a NotificationType entity.
    *
    * @param NotificationType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(NotificationType $entity)
    {
        $form = $this->createForm(new NotificationTypeType(), $entity, array(
            'action' => $this->generateUrl('config_notificationtype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }
    /**
     * Edits an existing NotificationType entity.
     *
     * @Route("/{id}", name="config_notificationtype_update")
     * @Method("PUT")
     * @Template("AdminBundle:NotificationType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:NotificationType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NotificationType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se han guardado los cambios.'
            );

            return $this->redirect($this->generateUrl('config_notificationtype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a NotificationType entity.
     *
     * @Route("/{id}", name="config_notificationtype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:NotificationType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find NotificationType entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha eliminado correctamente.'
            );
        }

        return $this->redirect($this->generateUrl('config_notificationtype'));
    }

    /**
     * Creates a form to delete a NotificationType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('config_notificationtype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
        ;
    }
}
