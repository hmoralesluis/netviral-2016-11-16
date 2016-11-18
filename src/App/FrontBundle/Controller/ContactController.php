<?php

namespace App\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class ContactController extends Controller
{
    /**
     * @Route("/page/contact", name="contact")
     */
    public function contactAction()
    {
        $session = $this->get('session');
        $affiliate = $session->get('affiliate');
        if (isset($affiliate) && !is_null($affiliate)) {
            return $this->redirect($this->generateUrl('affiliate_contact', array('username' => $affiliate)));
        }
        return $this->render('FrontBundle:Contact:contact.html.twig');
    }

    /**
     * @Route("/{username}/page/contact", name="affiliate_contact")
     */
    public function affiliateContactAction($username = null)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $affiliate = $session->get('affiliate');
        if (is_null($username) && isset($affiliate)) {
            return $this->redirect($this->generateUrl('affiliate_contact', array('username' => $affiliate)));
        } elseif(is_null($username) && !isset($affiliate)){
            return $this->redirect($this->generateUrl('contact'));
        }
        if (!is_null($username)) {
            $user = $em->getRepository('AdminBundle:User')->findBy(array('username' => $username));
            if (!$user) {
                throw $this->createNotFoundException('Usuario de afiliado no válido');
            }
        }
        $session->set('affiliate', $username);
        return $this->render('FrontBundle:Contact:contact.html.twig');
    }
}
