<?php
namespace Acme\TshirtBundle\DataFixtures\ORM;

use
    Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager
    ;

use
    Acme\TshirtBundle\Entity\OrderItem,
    Acme\TshirtBundle\Entity\Order
    ;

class Orders extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 3;
    }

    public function load(ObjectManager $manager)
    {
        foreach (array(
            'Kami Barut-Wanayo'  => array('S - small' => 1, 'M - Medium' => 1),
            'Sarah Watson'       => array('XL - Very large' => 2, 'XXL - Extra large' => 1, 'L - Large' => 1),
            'Jon Watkins'        => array('XXL - Extra large' => 1),
            'Jacqueline Rousseau'  => array('L - Large' => 1),
            'Laura Vecchio'        => array('L - Large' => 1, 'M - Medium' => 1),
            'Michael Müller'       => array('S - small' => 3, 'XXL - Extra large' => 1, 'XL - Very large' => 3, 'L - Large' => 1),
        ) as $i => $ii) {
            $shopper = $manager->getRepository('AcmeTshirtBundle:Shopper')->findOneByName($i);

            $items = array();

            foreach ($ii as $j => $jj) {

                $tshirt = $manager->getRepository('AcmeTshirtBundle:Tshirt')->findOneByName($j);
                $item = new OrderItem();
                $item->setTshirt($tshirt);
                $item->setCount($jj);

                $items[] = $item;
            }

            $order = new Order();
            $order->setShopper($shopper);
            foreach ($items as $item) {
                $order->addItem($item);
            }

            $manager->persist($order);
        }

        $manager->flush();
    }
}

?>
