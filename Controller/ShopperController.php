<?php

namespace Acme\TshirtBundle\Controller;

use
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template
;

/**
 * @Route("/shopper")
 */
class ShopperController extends Controller
{
    /**
     * @Route("/list")
     * @Template()
     */
    public function listAction()
    {
        $shoppers = $this->getDoctrine()->getEntityManager()
            ->createQuery('SELECT c FROM AcmeTshirtBundle:Shopper s ORDER BY s.name ASC')
            ->getResult()
        ;

        return array('shoppers' => $shoppers);
    }
}

?>
