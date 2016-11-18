<?php

namespace App\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\AdminBundle\Entity\Module;
use App\AdminBundle\Form\ModuleType;

/**
 * Module controller.
 *
 * @Route("/config/module")
 */
class ModuloController extends Controller
{

    /**
     * Lists all Module entities.
     *
     * @Route("/", name="config_module")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Module')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new module entity.
     *
     * @Route("/", name="config_module_create")
     * @Method("POST")
     * @Template("AdminBundle:Modulo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Module();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha creado un nuevo modulo.'
            );

            return $this->redirect($this->generateUrl('config_module_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a modulo entity.
     *
     * @param Module $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Module $entity)
    {
        $form = $this->createForm(new ModuleType(), $entity, array(
            'action' => $this->generateUrl('config_module_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrar'));

        return $form;
    }

    /**
     * Displays a form to create a new module entity.
     *
     * @Route("/new", name="config_module_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Module();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Module entity.
     *
     * @Route("/{id}", name="config_module_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Module')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Module entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Module entity.
     *
     * @Route("/{id}/edit", name="config_module_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Module')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find module entity.');
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
     * @param Module $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Module $entity)
    {
        $form = $this->createForm(new ModuleType(), $entity, array(
            'action' => $this->generateUrl('config_module_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }
    /**
     * Edits an existing Module entity.
     *
     * @Route("/{id}", name="config_module_update")
     * @Method("PUT")
     * @Template("AdminBundle:Modulo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Module')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Module entity.');
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

            return $this->redirect($this->generateUrl('config_module_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Module entity.
     *
     * @Route("/{id}", name="config_module_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Module')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find module entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha eliminado correctamente.'
            );
        }

        return $this->redirect($this->generateUrl('config_module'));
    }

    /**
     * Creates a form to delete a module entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('config_module_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
            ;
    }
}
