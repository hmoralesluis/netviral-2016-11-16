<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\Ebook;
use App\AdminBundle\Form\EbookType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ebook controller.
 *
 * @Route("/management/ebook")
 */
class EbookController extends Controller
{

    /**
     * Creates a new Ebook entity.
     *
     * @Route("/", name="management_ebook_create")
     * @Method("POST")
     * @Template("AdminBundle:Ebook:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Ebook();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha registrado un nuevo Ebook.'
            );

            return $this->redirect($this->generateUrl('management_ebook_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Ebook entity.
     *
     * @param Ebook $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ebook $entity)
    {
        $form = $this->createForm(new EbookType(), $entity, array(
            'action' => $this->generateUrl('management_ebook_create'),
            'attr' => array('enctype' => 'multipart/form-data'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrar'));

        return $form;
    }

    /**
     * Displays a form to create a new Ebook entity.
     *
     * @Route("/new", name="management_ebook_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Ebook();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Ebook entity.
     *
     * @Route("/{id}", name="management_ebook_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Ebook')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ebook entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Ebook entity.
     *
     * @Route("/{id}/edit", name="management_ebook_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Ebook')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ebook entity.');
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
     * Creates a form to edit a Ebook entity.
     *
     * @param Ebook $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Ebook $entity)
    {
        $form = $this->createForm(new EbookType(), $entity, array(
            'action' => $this->generateUrl('management_ebook_update', array('id' => $entity->getId())),
            'attr' => array('enctype' => 'multipart/form-data'),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    /**
     * Edits an existing Ebook entity.
     *
     * @Route("/{id}", name="management_ebook_update")
     * @Method("PUT")
     * @Template("AdminBundle:Ebook:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Ebook')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ebook entity.');
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

            return $this->redirect($this->generateUrl('management_ebook_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Ebook entity.
     *
     * @Route("/{id}", name="management_ebook_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Ebook')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ebook entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha eliminado correctamente.'
            );
        }

        return $this->redirect($this->generateUrl('management_audio_ebook'));
    }

    /**
     * Creates a form to delete a Ebook entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('management_ebook_delete', array('id' => $id)))
            ->setAttribute('enctype', 'multipart/form-data')
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm();
    }
}
