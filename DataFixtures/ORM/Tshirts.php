<?php
namespace Acme\TshirtBundle\DataFixtures\ORM;

use
    Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager
    ;

use
    Acme\TshirtBundle\Entity\Tshirt
    ;

class Tshirts extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        foreach (array(
            'S - small'            =>  9.99,
            'M - Medium'           =>  14.99,
            'L - Large'            =>  19.99,
            'XL - Very large'      =>  24.99,
            'XXL - Extra large'    =>  29.99,     
        ) as $name => $price) {

            $tshirt = new Tshirt();
            $tshirt->setName($name);
            $tshirt->setPrice($price);

            $manager->persist($tshirt);
        }

        $manager->flush();
    }
}

?>
