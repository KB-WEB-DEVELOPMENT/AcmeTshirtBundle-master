<?php

namespace Acme\TshirtBundle\Tests\Entity;

use
    Acme\TshirtBundle\Entity\OrderItem,
    Acme\TshirtBundle\Entity\Order,
    Acme\TshirtBundle\Entity\Tshirt
;

class OrderItemEntityTest extends AbstractEntityTest
{
    public static function provider()
    {        
        $data = array();

        $data[] = array(
            'properties' => array(
                'order' => $order = new Order(),
                'tshirt' => $tshirt = new Tshirt(),
                'count' => 2,
            ),
            'errors' => array(),
        );

        $data[] = array(
            'properties' => array(),
            'errors' => array(
                'tshirt' => 'This value should not be blank',
                'count' => 'This value should not be blank',
            ),
        );

        $data[] = array(
            'properties' => array(
                'order' => $order,
                'tshirt' => $tshirt,
                'count' => 0,
            ),
            'errors' => array(
                'count' => 'This value should be 1 or more',
            ),
        );

        $data[] = array(
            'properties' => array(
                'order' => $order,
                'tshirt' => $tshirt,
                'count' => 1.5,
            ),
            'errors' => array(
                'count' => 'This value should be of type integer',
            ),
        );
        
        return $data;
    }

    /**
     * @dataProvider provider
     */
    public function testValidation(array $properties, array $errors)
    {
        $item = new OrderItem();

        foreach ($properties as $property => $value) {
            $item->set($property, $value);
        }

        $violations = self::$validator->validate($item);
        /* @var $violations \Symfony\Component\Validator\ConstraintViolationList */

        $this->assertEquals(count($errors), count($violations), (string) $violations);

        foreach ($errors as $property => $message) {
            $pattern = sprintf('/\.%s:\s+%s$/m', $property, $message);
            $this->assertRegExp($pattern, (string) $violations, $violations);
        }
    }
}
?>
