<?php

namespace Acme\TshirtBundle\Controller;

use
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template
;

use
    Acme\TshirtBundle\Entity\Tshirt,
    Acme\TshirtBundle\Form\Type\TshirtType
;

/**
 * @Route("/tshirt")
 */
class TshirtController extends Controller
{
    /**
     * @Route("/create", name="acme_tshirt_tshirt_create"),
     * @Route("/update/{id}", name="acme_tshirt_tshirt_update", requirements={"id" = "\d+"})
     * @Template()
     */
    public function editAction($id = null)
    {
        $em = $this->getDoctrine()->getEntityManager();

        if (isset($id)) {
            $tshirt = $em->find('AcmeTshirtBundle:Tshirt', $id);

            if (!$tshirt) {
                throw new NotFoundHttpException("Invalid Tshirt.");
            }
        } else {
            $tshirt = new Tshirt();
        }

        $form = $this->createForm(new TshirtType(), $tshirt);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($tshirt);
                $em->flush();

                $this->get('session')->setFlash('success', 'New T-shirt was saved!');

                return $this->redirect($this->generateUrl('acme_tshirt_tshirt_list'));
            }
        }

        return array(
            'form'  => $form->createView(),
            'tshirt' => $tshirt,
        );
    }

    /**
     * @Route("/list")
     * @Template()
     */
    public function listAction()
    {
        $tshirts = $this->get('doctrine')->getEntityManager()
            ->createQuery('SELECT t FROM AcmeTshirtBundle:Tshirt t ORDER BY t.name ASC')
            ->getResult()
        ;

        return array('tshirts' => $tshirts);
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $tshirt = $em->find('AcmeTshirtBundle:Tshirt', $id);

        if (!$tshirt) {
            throw new NotFoundHttpException("Invalid T-shirt.");
        }

        $em->remove($tshirt);
        $em->flush();

        return $this->redirect($this->generateUrl('acme_tshirt_tshirt_list'));
    }
}

?>
