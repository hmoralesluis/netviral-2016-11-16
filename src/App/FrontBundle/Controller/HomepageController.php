<?php

namespace App\FrontBundle\Controller;

use App\AdminBundle\Entity\Cart;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\SecurityBundle\Tests\Functional\Bundle\AclBundle\Entity\Car;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class HomepageController extends Controller
{
    /**
     * @Route("/{_locale}/", name="homepage", defaults={"_locale": "es"})
     */
    public function homepageAction($_locale)
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
        //$locales = $em->getRepository('AdminBundle:Country')->findAll();
        $locales = array('es','en','fr','ae','in','it','kr','pt','jp','ru','th','id','cn');
        $session->set('locales', $locales);
        $modules = $em->getRepository('AdminBundle:Module')->findToShow();
        $modulesregistro = $em->getRepository('AdminBundle:Module')->find('2');
        $testimonios = $em->getRepository('AdminBundle:Testimonial')->findAll();
        $countries = $em->getRepository('AdminBundle:Country')->findAll();
        return $this->render('FrontBundle:Homepage:homepage.html.twig', array(
            'modules' => $modules,
            'moduleregistro' => $modulesregistro,
            'testimonios' => $testimonios,
            'countries' => $countries
        ));
    }

    /**
     * @Route("/{_locale}/{username}/shop", name="shop")
     */
    public function shopAction($username, $_locale, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $session = $request->getSession();
        $category = $request->get('category');
        $session = $this->get('session');
        $session->set('carrito',array());
        $affiliate = $session->get('affiliate');
        $nombrecat = $request->get('nombcat');

        if ($category == 'Todos'){
            $subcategory = $em->getRepository('AdminBundle:ShopSubcategoryProduct')->findBy(array('subcategory'=>'1'));
        }else{
            $subcategory = $em->getRepository('AdminBundle:ShopSubcategoryProduct')->findBy(array('subcategory'=>$category));
        }

        return $this->render('FrontBundle:Shop:shop.html.twig',array(
            'categoria' => $category,
            'entity' => $affiliate,
            'subcategory' => $subcategory,
            'nombcateg' => $nombrecat
        ));
    }

    /**
     * @Route("/{_locale}/{username}/shop/cart", name="shopcart")
     */
    public function shopcartAction($username, $_locale, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $session = $request->getSession();
        $category = $request->get('category');
        $session = $this->get('session');
        $affiliate = $session->get('affiliate');
        $nombrecat = $request->get('nombcat');


//        var_dump($category);
        //$subcategory = $em->getRepository('AdminBundle:ShopSubcategoryProduct')->findBy(array('subcategory'=>$category));

        return $this->render('FrontBundle:Shop:cart.html.twig',array(
            'categoria' => $category,
            'entity' => $affiliate,
            'nombcateg' => $nombrecat
        ));
    }

    /**
     * @Route("/{_locale}/{username}", name="affiliate_homepage", defaults={"_locale": "es", "username" : null})
     */
    public function affiliateHomepageAction($username, $_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $affiliate = $session->get('affiliate');
        if(!is_null($_locale)){
            $session->set('_locale', $_locale);
        } else {
            $session->set('_locale', 'es');
        }
        //$locales = $em->getRepository('AdminBundle:Country')->findAll();
        $locales = array('es','en','fr','ae','in','it','kr','pt','jp','ru','th','id','cn');
        $session->set('locales', $locales);

        if (is_null($username) && isset($affiliate)) {
            return $this->redirect($this->generateUrl('affiliate_homepage', array('username' => $affiliate)));
        } elseif(is_null($username) && !isset($affiliate)){
            return $this->redirect($this->generateUrl('homepage'));
        }
        if (!is_null($username) && $username != 'page') {
            $user = $em->getRepository('AdminBundle:User')->findBy(array('username' => $username));
            if (!$user) {
                throw $this->createNotFoundException('Usuario de afiliado no válido');
            }
        }
        $session->set('affiliate', $username);

        $modules = $em->getRepository('AdminBundle:Module')->findToShow();
        $modulesregistro = $em->getRepository('AdminBundle:Module')->find('2');
        $testimonios = $em->getRepository('AdminBundle:Testimonial')->findAll();
        $countries = $em->getRepository('AdminBundle:Country')->findAll();
        return $this->render('FrontBundle:Homepage:homepage.html.twig', array(
            'modules' => $modules,
            'moduleregistro' => $modulesregistro,
            'testimonios' => $testimonios,
            'countries' => $countries
        ));
    }
}
