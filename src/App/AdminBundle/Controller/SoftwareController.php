<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\Software;
use App\AdminBundle\Form\SoftwareType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Software controller.
 *
 * @Route("/management/software")
 */
class SoftwareController extends Controller
{

    /**
     * Lists all Software entities.
     *
     * @Route("/", name="management_software")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Software')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Software entity.
     *
     * @Route("/", name="management_software_create")
     * @Method("POST")
     * @Template("AdminBundle:Software:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Software();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha registrado un nuevo software.'
            );

            return $this->redirect($this->generateUrl('management_software_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Software entity.
     *
     * @param Software $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Software $entity)
    {
        $form = $this->createForm(new SoftwareType(), $entity, array(
            'action' => $this->generateUrl('management_software_create'),
            'attr' => array('enctype' => 'multipart/form-data'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrar'));

        return $form;
    }

    /**
     * Displays a form to create a new Software entity.
     *
     * @Route("/new", name="management_software_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Software();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Software entity.
     *
     * @Route("/{id}", name="management_software_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Software')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Software entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Software entity.
     *
     * @Route("/{id}/edit", name="management_software_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Software')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Software entity.');
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
     * Creates a form to edit a Software entity.
     *
     * @param Software $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Software $entity)
    {
        $form = $this->createForm(new SoftwareType(), $entity, array(
            'action' => $this->generateUrl('management_software_update', array('id' => $entity->getId())),
            'attr' => array('enctype' => 'multipart/form-data'),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    /**
     * Edits an existing Software entity.
     *
     * @Route("/{id}", name="management_software_update")
     * @Method("PUT")
     * @Template("AdminBundle:Software:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Software')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Software entity.');
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

            return $this->redirect($this->generateUrl('management_software_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Software entity.
     *
     * @Route("/{id}", name="management_software_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Software')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Software entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha eliminado correctamente.'
            );
        }

        return $this->redirect($this->generateUrl('management_software'));
    }

    /**
     * Creates a form to delete a Software entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('management_software_delete', array('id' => $id)))
            ->setAttribute('enctype', 'multipart/form-data')
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm();
    }
}
