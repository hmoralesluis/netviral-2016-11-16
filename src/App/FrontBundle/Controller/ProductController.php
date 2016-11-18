<?php

namespace App\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class ProductController extends Controller
{
    /**
     * @Route("/{_locale}/page/product/{id}", name="product", defaults={"_locale": "es", "id" : null, "tipo" : null})
     */
    public function productAction($id,$tipo)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $affiliate = $session->get('affiliate');
        if (isset($affiliate) && !is_null($affiliate)) {
            return $this->redirect($this->generateUrl('affiliate_product', array('username' => $affiliate,'id' => $id)));
        }
        if ($id == 'hive'){$tipo = 2;};
        if ($id == 'Thunder'){$tipo = 3;};
        if ($id == 'Win'){$tipo = 4;};
        if ($id == 'Mind'){$tipo = 5;};
        if ($id == 'Global'){$tipo = 6;};

        $precio = $em->getRepository('AdminBundle:Module')->find($tipo);
        return $this->render('FrontBundle:Products:'.$id.'.html.twig',array(
            'precio' => $precio
        ));
    }

    /**
     * @Route("/{_locale}/{username}/page/product/{id}", name="affiliate_product", defaults={"_locale": "es", "username" : null, "id" : null})
     */
    public function affiliateProductAction($username, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $affiliate = $session->get('affiliate');
        if (is_null($username) && isset($affiliate)) {
            return $this->redirect($this->generateUrl('affiliate_product', array('username' => $affiliate)));
        } elseif(is_null($username) && !isset($affiliate)){
            return $this->redirect($this->generateUrl('product'));
        }
        if (!is_null($username)) {
            $user = $em->getRepository('AdminBundle:User')->findBy(array('username' => $username));
            if (!$user) {
                throw $this->createNotFoundException('Usuario de afiliado no válido');
            }
        }
        $session->set('affiliate', $username);
        //$product = $em->getRepository('AdminBundle:Module')->find($id);
        //if(!$product){
        //    throw $this->createNotFoundException('Módulo no encontrado');
        //}
        return $this->render('FrontBundle:Products:'.$id.'.html.twig');
    }

    /**
     * @Route("/{_locale}/page/plan", name="plan", defaults={"_locale": "es", "id" : null})
     */
    public function planAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $affiliate = $session->get('affiliate');
        if (isset($affiliate) && !is_null($affiliate)) {
            return $this->redirect($this->generateUrl('affiliate_product', array('username' => $affiliate)));
        }
        return $this->render('FrontBundle:Products:plan.html.twig');
    }

}
