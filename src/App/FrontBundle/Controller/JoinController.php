<?php

namespace App\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class JoinController extends Controller
{

    /**
     * @Route("/{_locale}/page/join", name="join", defaults={"_locale": "es"})
     */
    public function JoinAction($_locale)
    {
        $session = $this->get('session');
        if(!is_null($_locale)){
            $session->set('_locale', $_locale);
        } else {
            $session->set('_locale', 'es');
        }
        $affiliate = $session->get('affiliate');
        if (isset($affiliate) && !is_null($affiliate)) {
            return $this->redirect($this->generateUrl('affiliate_homepage', array('username' => $affiliate)));
        } else {
            $affiliate = null;
        }
        $em = $this->getDoctrine()->getManager();
        $countries = $em->getRepository('AdminBundle:Country')->findAll();
        return $this->render('FrontBundle:Join:join.html.twig', array(
            'countries' => $countries
        ));
    }

    /**
     * @Route("/{_locale}/{username}/page/join", name="affiliate_join")
     */
    public function affiliateAboutAction($username = null)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $affiliate = $session->get('affiliate');

//        if (isset($affiliate) && !is_null($affiliate)) {
//            return $this->redirect($this->generateUrl('affiliate_product', array('username' => $affiliate)));
//        }
        if (!is_null($username)) {
            $user = $em->getRepository('AdminBundle:User')->findBy(array('username' => $username));
            if (!$user) {
                throw $this->createNotFoundException('Usuario de afiliado no válido');
            }
        }
//        $session->set('affiliate', $username);
        $countries = $em->getRepository('AdminBundle:Country')->findAll();
        return $this->render('FrontBundle:Join:join.html.twig', array(
            'countries' => $countries
        ));
    }


}
