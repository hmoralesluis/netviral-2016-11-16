<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\Audio;
use App\AdminBundle\Form\AudioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Audio controller.
 *
 * @Route("/management/audio")
 */
class AudioController extends Controller
{

    /**
     * Lists all Audio and Ebook entities.
     *
     * @Route("/download", name="download_file")
     */
    public function DownloadAction()
    {
//        $path = $this->get('kernel')->getRootDir(). "/../web/upload/" . $video->getPath();
  //      if (!file_exists($path)) {
    //        throw $this->createNotFoundException();
    //    }
        $response = new Response();
        $response->headers->set('Content-type', 'video/mpeg');
     //   $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $path));
  //      $response->headers->set('Content-Length', filesize($path));
        return $response;
    }

    /**
     * Lists all Audio and Ebook entities.
     *
     * @Route("/ebook", name="management_audio_ebook")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $audios = $em->getRepository('AdminBundle:Audio')->findAll();
        $ebooks = $em->getRepository('AdminBundle:Ebook')->findAll();

        return $this->render('AdminBundle:Product:audio_ebook.html.twig', array(
            'audios' => $audios,
            'ebooks' => $ebooks
        ));
    }

    /**
     * Creates a new Audio entity.
     *
     * @Route("/", name="management_audio_create")
     * @Method("POST")
     * @Template("AdminBundle:Audio:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Audio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Se ha registrado un nuevo Audio.'
            );

            return $this->redirect($this->generateUrl('management_audio_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Audio entity.
     *
     * @param Audio $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Audio $entity)
    {
        $form = $this->createForm(new AudioType(), $entity, array(
            'action' => $this->generateUrl('management_audio_create'),
            'attr' => array('enctype' => 'multipart/form-data'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrar'));

        return $form;
    }

    /**
     * Displays a form to create a new Audio entity.
     *
     * @Route("/new", name="management_audio_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Audio();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Audio entity.
     *
     * @Route("/{id}", name="management_audio_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Audio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Audio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Audio entity.
     *
     * @Route("/{id}/edit", name="management_audio_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Audio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Audio entity.');
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
     * Creates a form to edit a Audio entity.
     *
     * @param Audio $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Audio $entity)
    {
        $form = $this->createForm(new AudioType(), $entity, array(
            'action' => $this->generateUrl('management_audio_update', array('id' => $entity->getId())),
            'attr' => array('enctype' => 'multipart/form-data'),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    /**
     * Edits an existing Audio entity.
     *
     * @Route("/{id}", name="management_audio_update")
     * @Method("PUT")
     * @Template("AdminBundle:Audio:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Audio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Audio entity.');
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

            return $this->redirect($this->generateUrl('management_audio_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Audio entity.
     *
     * @Route("/{id}", name="management_audio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Audio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Audio entity.');
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
     * Creates a form to delete a Audio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('management_audio_delete', array('id' => $id)))
            ->setAttribute('enctype', 'multipart/form-data')
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm();
    }
}
