<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\Testimonial;
use App\AdminBundle\Form\TestimonialType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Testimonial controller.
 *
 * @Route("/config/testimonial")
 */
class TestimonialController extends Controller
{
    /**
     * Lists all testimonials
     *
     * @Route("/", name="config_testimonial")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $audios = $em->getRepository('AdminBundle:Testimonial')->findAll();

        return $this->render('AdminBundle:Testimonial:index.html.twig', array(
            'entities' => $audios
        ));
    }

    /**
     * Creates a new testimonial entity.
     *
     * @Route("/", name="config_testimonial_create")
     * @Method("POST")
     * @Template("AdminBundle:Testimonial:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Testimonial();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        var_dump('error en validacion formulario');
        exit;

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha registrado un nuevo Testimonio.'
            );

            //return $this->redirect($this->generateUrl('config_testimonial_show', array('id' => $entity->getId())));
        }
        return $this->redirect($this->generateUrl('config_testimonial_show', array('id' => $entity->getId())));

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a testimonial entity.
     *
     * @param Testimonial $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Testimonial $entity)
    {
        $form = $this->createForm(new TestimonialType(), $entity, array(
            'action' => $this->generateUrl('config_testimonial_create'),
            'attr' => array('enctype' => 'multipart/form-data'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }

    /**
     * Displays a form to create a new testimonial entity.
     *
     * @Route("/new", name="config_testimonial_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Testimonial();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a testimonial entity.
     *
     * @Route("/{id}", name="config_testimonial_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Testimonial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find testimonial entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing testimonial entity.
     *
     * @Route("/{id}/edit", name="config_testimonial_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Testimonial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find testimonial entity.');
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
     * Creates a form to edit a testimonial entity.
     *
     * @param Testimonial $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Testimonial $entity)
    {
        $form = $this->createForm(new TestimonialType(), $entity, array(
            'action' => $this->generateUrl('config_testimonial_update', array('id' => $entity->getId())),
            'attr' => array('enctype' => 'multipart/form-data'),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    /**
     * Edits an existing testimonial entity.
     *
     * @Route("/{id}", name="config_testimonial_update")
     * @Method("PUT")
     * @Template("AdminBundle:Testimonial:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Testimonial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find testimonial entity.');
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

            return $this->redirect($this->generateUrl('config_testimonial_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a testimonial entity.
     *
     * @Route("/{id}", name="config_testimonial_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Testimonial')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find testimonial entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha eliminado correctamente.'
            );
        }

        return $this->redirect($this->generateUrl('config_testimonial'));
    }

    /**
     * Creates a form to delete a testimonial entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('config_testimonial_delete', array('id' => $id)))
            ->setAttribute('enctype', 'multipart/form-data')
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm();
    }
}
