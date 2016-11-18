<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\CompensationPlan;
use App\AdminBundle\Form\CompensationPlanType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * CompensationPlan controller.
 *
 * @Route("/config/compensationplan")
 */
class CompensationPlanController extends Controller
{

    /**
     * Lists all CompensationPlan entities.
     *
     * @Route("/", name="config_compensationplan")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:CompensationPlan')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new CompensationPlan entity.
     *
     * @Route("/", name="config_compensationplan_create")
     * @Method("POST")
     * @Template("AdminBundle:CompensationPlan:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CompensationPlan();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha creado un nuevo plan de compensación.'
            );

            return $this->redirect($this->generateUrl('config_compensationplan_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CompensationPlan entity.
     *
     * @param CompensationPlan $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CompensationPlan $entity)
    {
        $form = $this->createForm(new CompensationPlanType(), $entity, array(
            'action' => $this->generateUrl('config_compensationplan_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrar'));

        return $form;
    }

    /**
     * Displays a form to create a new CompensationPlan entity.
     *
     * @Route("/new", name="config_compensationplan_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CompensationPlan();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a CompensationPlan entity.
     *
     * @Route("/{id}", name="config_compensationplan_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:CompensationPlan')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CompensationPlan entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CompensationPlan entity.
     *
     * @Route("/{id}/edit", name="config_compensationplan_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:CompensationPlan')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CompensationPlan entity.');
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
     * Creates a form to edit a CompensationPlan entity.
     *
     * @param CompensationPlan $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CompensationPlan $entity)
    {
        $form = $this->createForm(new CompensationPlanType(), $entity, array(
            'action' => $this->generateUrl('config_compensationplan_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    /**
     * Edits an existing CompensationPlan entity.
     *
     * @Route("/{id}", name="config_compensationplan_update")
     * @Method("PUT")
     * @Template("AdminBundle:CompensationPlan:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:CompensationPlan')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CompensationPlan entity.');
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

            return $this->redirect($this->generateUrl('config_compensationplan_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CompensationPlan entity.
     *
     * @Route("/{id}", name="config_compensationplan_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:CompensationPlan')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CompensationPlan entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha eliminado correctamente.'
            );
        }

        return $this->redirect($this->generateUrl('config_compensationplan'));
    }

    /**
     * Creates a form to delete a CompensationPlan entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('config_compensationplan_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm();
    }
}
