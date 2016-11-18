<?php

namespace App\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\AdminBundle\Entity\Product;

/**
 * Product controller.
 *
 * @Route("/management/product")
 */
class ProductController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Route("/marketing", name="management_product_marketing")
     * @Method("GET")
     * @Template()
     */
    public function marketingAction()
    {
        return array();
    }

    /**
     * Lists all Product entities.
     *
     * @Route("/sotwares", name="management_product_softwares")
     * @Method("GET")
     * @Template()
     */
    public function softwaresAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Product')->findAll(); //type training plans

        return array(
            'entities' => $entities,
        );
    }

    /**
     *
     * @Route("/ebook", name="management_product_ebook")
     * @Method("GET")
     * @Template()
     */
    public function ebookAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Product')->findAll(); //type training plans

        return array(
            'entities' => $entities,
        );
    }

    /**
     *
     * @Route("/shop", name="management_product_shop")
     * @Method("GET")
     * @Template()
     */
    public function shopAction()
    {
        return array();
    }
}
