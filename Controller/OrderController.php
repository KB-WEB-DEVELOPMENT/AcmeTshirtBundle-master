<?php

namespace Acme\TshirtBundle\Controller;

use
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template
;

use
    Acme\TshirtBundle\Entity\Factory\OrderFactory,
    Acme\TshirtBundle\Entity\Order,
    Acme\TshirtBundle\Form\OrderFormType
;

/**
 * @Route("/order")
 */
class OrderController extends Controller
{
     /**
     * @Route("/index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $factory = new OrderFactory($em);

        $form = $this->createForm(new OrderFormType(), $factory);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {

            $form->bindRequest($request);

            if ($form->isValid()) {

                $em->persist($order = $factory->make());
                $em->flush();

                $this->get('session')->setFlash('success', 'New T-shirt orders were saved!');

                return $this->redirect($this->generateUrl('acme_tshirt_order_show', array(
                    'id' => $order->getId(),
                )));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/list")
     * @Template()
     */
    public function listAction()
    {
        $orders = $this->getDoctrine()->getEntityManager()
            ->createQuery('SELECT o FROM AcmeTshirtBundle:Order o ORDER BY o.id DESC')
            ->getResult()
        ;

        return array('orders' => $orders);
    }

    /**
     * @Route("/show/{id}")
     * @Template()
     */
    public function showAction($id)
    {
        $order = $this->getDoctrine()->getEntityManager()->find('AcmeTshirtBundle:Order', $id);

        if (!$order) {
            throw $this->createNotFoundException('The T-shirt order does not exist');
        }

        return array('order' => $order);
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $order = $em->find('AcmeTshirtBundle:Order', $id);
        /* @var \Acme\TshirtBundle\Entity\Order $order */
        if (!$order) {
            throw new NotFoundHttpException("Invalid T-shirt Order.");
        }

        $form = $this->createForm(new OrderType());
        $form->setData($order);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {

            $form->bindRequest($request);

            if ($form->isValid()) {

                $em->flush();

                return $this->redirect($this->generateUrl('acme_tshirt_order_edit', array(
                    'id' => $order->getId(),
                )));
            }
        }

        return array(
            'form'  => $form->createView(),
            'order' => $order,
        );
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $order = $em->find('AcmeTshirtBundle:Order', $id);

        if (!$order) {
            throw $this->createNotFoundException("Invalid T-shirt order.");
        }

        foreach ($order->getItems() as $item) {
            $em->remove($item);
        }

        $em->remove($order);
        $em->flush();

        return $this->redirect($this->generateUrl('acme_tshirt_order_list'));
    }
}

?>
