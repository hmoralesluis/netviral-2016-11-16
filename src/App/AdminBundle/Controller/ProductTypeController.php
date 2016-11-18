<?php

namespace App\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\AdminBundle\Entity\ProductType;
use App\AdminBundle\Form\ProductTypeType;

/**
 * ProductType controller.
 *
 * @Route("/config/producttype")
 */
class ProductTypeController extends Controller
{

    /**
     * Lists all ProductType entities.
     *
     * @Route("/", name="config_producttype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:ProductType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ProductType entity.
     *
     * @Route("/", name="config_producttype_create")
     * @Method("POST")
     * @Template("AdminBundle:ProductType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ProductType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha creado un nuevo tipo de producto.'
            );

            return $this->redirect($this->generateUrl('config_producttype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ProductType entity.
     *
     * @param ProductType $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ProductType $entity)
    {
        $form = $this->createForm(new ProductTypeType(), $entity, array(
            'action' => $this->generateUrl('config_producttype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrar'));

        return $form;
    }

    /**
     * Displays a form to create a new ProductType entity.
     *
     * @Route("/new", name="config_producttype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ProductType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ProductType entity.
     *
     * @Route("/{id}", name="config_producttype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:ProductType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ProductType entity.
     *
     * @Route("/{id}/edit", name="config_producttype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:ProductType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductType entity.');
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
    * Creates a form to edit a ProductType entity.
    *
    * @param ProductType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ProductType $entity)
    {
        $form = $this->createForm(new ProductTypeType(), $entity, array(
            'action' => $this->generateUrl('config_producttype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }
    /**
     * Edits an existing ProductType entity.
     *
     * @Route("/{id}", name="config_producttype_update")
     * @Method("PUT")
     * @Template("AdminBundle:ProductType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:ProductType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductType entity.');
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

            return $this->redirect($this->generateUrl('config_producttype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ProductType entity.
     *
     * @Route("/{id}", name="config_producttype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:ProductType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProductType entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha eliminado correctamente.'
            );
        }

        return $this->redirect($this->generateUrl('config_producttype'));
    }

    /**
     * Creates a form to delete a ProductType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('config_producttype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
        ;
    }
}
