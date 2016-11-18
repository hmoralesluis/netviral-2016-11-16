<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\Conference;
use App\AdminBundle\Form\ConferenceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Conference controller.
 *
 * @Route("/management/conference")
 */
class ConferenceController extends Controller
{

    /**
     * Lists all Conference entities.
     *
     * @Route("/", name="management_conference")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Conference')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Conference entity.
     *
     * @Route("/", name="management_conference_create")
     * @Method("POST")
     * @Template("AdminBundle:Conference:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Conference();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha registrado una nueva Conferencia.'
            );

            return $this->redirect($this->generateUrl('management_conference_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Conference entity.
     *
     * @param Conference $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Conference $entity)
    {
        $form = $this->createForm(new ConferenceType(), $entity, array(
            'action' => $this->generateUrl('management_conference_create'),
            'attr' => array('enctype' => 'multipart/form-data'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrar'));

        return $form;
    }

    /**
     * Displays a form to create a new Conference entity.
     *
     * @Route("/new", name="management_conference_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Conference();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Conference entity.
     *
     * @Route("/{id}", name="management_conference_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Conference')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conference entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Conference entity.
     *
     * @Route("/{id}/edit", name="management_conference_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Conference')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conference entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Conference entity.
     *
     * @param Conference $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Conference $entity)
    {
        $form = $this->createForm(new ConferenceType(), $entity, array(
            'action' => $this->generateUrl('management_conference_update', array('id' => $entity->getId())),
            'attr' => array('enctype' => 'multipart/form-data'),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    /**
     * Edits an existing Conference entity.
     *
     * @Route("/{id}", name="management_conference_update")
     * @Method("PUT")
     * @Template("AdminBundle:Conference:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Conference')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conference entity.');
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

            return $this->redirect($this->generateUrl('management_conference_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Conference entity.
     *
     * @Route("/{id}", name="management_conference_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Conference')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Conference entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha eliminado correctamente.'
            );
        }

        return $this->redirect($this->generateUrl('management_conference'));
    }

    /**
     * Creates a form to delete a Conference entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('management_conference_delete', array('id' => $id)))
            ->setAttribute('enctype', 'multipart/form-data')
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm();
    }
}
