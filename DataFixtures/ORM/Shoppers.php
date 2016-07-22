<?php
namespace Acme\TshirtsBundle\DataFixtures\ORM;

use
    Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager
    ;

use
    Acme\TshirtBundle\Entity\Shopper
    ;

class Shoppers extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 2;
    }

    public function load(ObjectManager $manager)
    {
        foreach(array(
            array(
                'name'   => 'Kami Barut-Wanayo',
                'street' => '125 Main Street',
                'city'   => 'New York City, NY 10044',
                'phone'  => '650-813-0200',
            ),
            array(
                'name'   => 'Sarah Watson',
                'street' => '3849 Emeral Dreams Drive',
                'city'   => 'Seward, IL 61063',
                'phone'  => '817-842-7812',
            ),
            array(
                'name'   => 'Jon Watkins',
                'street' => '15, Waterbridge Street',
                'city'   => '21200 London',
                'phone'  => '15.09.78.45.12',
            ),
            array(
                'name'   => 'Jacqueline Rousseau',
                'street' => '64, rue Reine Elisabeth',
                'city'   => '75012 Paris',
                'phone'  => '06.12.15.78.19',
            ),
            array(
                'name'   => 'Laura Vecchio',
                'street' => 'Via Partenope, 114',
                'city'   => '90152 Roma ',
                'phone'  => '0343 1789426',
            ),
            array(
                'name'   => 'Michael Müller',
                'street' => 'Leopold Straße 23',
                'city'   => '13059 Berlin ',
                'phone'  => '030 75 12 78 12',
            ),
        ) as $data) {

            $shopper = new Shopper();

            $shopper->setName($data['name']);
            $shopper->setStreet($data['street']);
            $shopper->setCity($data['city']);
            $shopper->setPhone($data['phone']);

            $manager->persist($shopper);
        }

        $manager->flush();
    }
}

?>
