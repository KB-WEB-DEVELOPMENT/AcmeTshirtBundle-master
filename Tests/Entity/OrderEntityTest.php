<?php

namespace Acme\TshirtBundle\Tests\Entity;

use
    Acme\TshirtBundle\Entity\Order,
    Acme\TshirtBundle\Entity\Shopper,
    Doctrine\Common\Collections\ArrayCollection
;

class OrderEntityTest extends AbstractEntityTest
{
    public static function provider()
    {
        $data = array();

        $data[] = array(
            'properties' => array(
                'date'     => new \DateTime(),
                'shopper' => new Shopper(),
                'items'    => new ArrayCollection(),
            ),
            'errors' => array(),
        );

        $data[] = array(
            'properties' => array(),
            'errors' => array(
                'shopper' => 'This value should not be blank',
            ),
        );

        return $data;
    }

    /**
     * @dataProvider provider
     */
    public function testValidation(array $properties, array $errors)
    {
        $order = new Order();

        foreach ($properties as $property => $value) {
            $order->set($property, $value);
        }

        $violations = self::$validator->validate($order);
        /* @var $violations \Symfony\Component\Validator\ConstraintViolationList */

        $this->assertEquals(count($errors), count($violations), (string) $violations);

        foreach ($errors as $property => $message) {
            $pattern = sprintf('/\.%s:\s+%s$/m', $property, $message);
            $this->assertRegExp($pattern, (string) $violations, $violations);
        }
    }
}
