<?php

namespace App\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\AdminBundle\Entity\TransactionType;
use App\AdminBundle\Form\TransactionTypeType;

/**
 * TransactionType controller.
 *
 * @Route("/config/transactiontype")
 */
class TransactionTypeController extends Controller
{

    /**
     * Lists all TransactionType entities.
     *
     * @Route("/", name="config_transactiontype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:TransactionType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TransactionType entity.
     *
     * @Route("/", name="config_transactiontype_create")
     * @Method("POST")
     * @Template("AdminBundle:TransactionType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TransactionType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha creado un nuevo tipo de transacción.'
            );

            return $this->redirect($this->generateUrl('config_transactiontype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a TransactionType entity.
     *
     * @param TransactionType $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TransactionType $entity)
    {
        $form = $this->createForm(new TransactionTypeType(), $entity, array(
            'action' => $this->generateUrl('config_transactiontype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrar'));

        return $form;
    }

    /**
     * Displays a form to create a new TransactionType entity.
     *
     * @Route("/new", name="config_transactiontype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TransactionType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TransactionType entity.
     *
     * @Route("/{id}", name="config_transactiontype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:TransactionType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TransactionType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TransactionType entity.
     *
     * @Route("/{id}/edit", name="config_transactiontype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:TransactionType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TransactionType entity.');
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
    * Creates a form to edit a TransactionType entity.
    *
    * @param TransactionType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TransactionType $entity)
    {
        $form = $this->createForm(new TransactionTypeType(), $entity, array(
            'action' => $this->generateUrl('config_transactiontype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }
    /**
     * Edits an existing TransactionType entity.
     *
     * @Route("/{id}", name="config_transactiontype_update")
     * @Method("PUT")
     * @Template("AdminBundle:TransactionType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:TransactionType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TransactionType entity.');
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

            return $this->redirect($this->generateUrl('config_transactiontype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TransactionType entity.
     *
     * @Route("/{id}", name="config_transactiontype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:TransactionType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TransactionType entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha eliminado correctamente.'
            );
        }

        return $this->redirect($this->generateUrl('config_transactiontype'));
    }

    /**
     * Creates a form to delete a TransactionType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('config_transactiontype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
        ;
    }
}
