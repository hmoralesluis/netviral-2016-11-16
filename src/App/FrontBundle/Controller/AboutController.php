<?php

namespace App\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class AboutController extends Controller
{
    /**
     * @Route("/page/about", name="about")
     */
    public function aboutAction()
    {
        $session = $this->get('session');
        $affiliate = $session->get('affiliate');
        if (isset($affiliate) && !is_null($affiliate)) {
            return $this->redirect($this->generateUrl('affiliate_about', array('username' => $affiliate)));
        }
        return $this->render('FrontBundle:About:about.html.twig');
    }

    /**
     * @Route("/{username}/page/about", name="affiliate_about")
     */
    public function affiliateAboutAction($username = null)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $affiliate = $session->get('affiliate');
        if (is_null($username) && isset($affiliate)) {
            return $this->redirect($this->generateUrl('affiliate_about', array('username' => $affiliate)));
        } elseif(is_null($username) && !isset($affiliate)){
            return $this->redirect($this->generateUrl('about'));
        }
        if (!is_null($username)) {
            $user = $em->getRepository('AdminBundle:User')->findBy(array('username' => $username));
            if (!$user) {
                throw $this->createNotFoundException('Usuario de afiliado no válido');
            }
        }
        $session->set('affiliate', $username);
        return $this->render('FrontBundle:About:about.html.twig');
    }
}
