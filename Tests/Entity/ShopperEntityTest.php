<?php

namespace Acme\TshirtBundle\Tests\Entity;

use
    Acme\TshirtBundle\Entity\Shopper
;

class CustomerEntityTest extends AbstractEntityTest
{
    public static function provider()
    {
        $data = array();

        $data[] = array(
            'properties' => array(
                'name'   => 'Kâmi Barut-Wanayo',
                'street' => '555 Main Street',
                'city'   => 'New York, New York 10044',
                'phone'  => '212-754-48-59',
            ),
            'errors' => array(),
        );

        $data[] = array(
            'properties' => array(),
            'errors' => array(
                'name'   => 'This value should not be blank',
                'street' => 'This value should not be blank',
                'city'   => 'This value should not be blank',
                'phone'  => 'This value should not be blank',
            ),
        );

        return $data;
    }

    /**
     * @dataProvider provider
     */
    public function testValidation(array $properties, array $errors)
    {
        $customer = new Customer();

        foreach ($properties as $property => $value) {
            $customer->set($property, $value);
        }

        $violations = self::$validator->validate($customer, array('Customer'));
        /* @var $violations \Symfony\Component\Validator\ConstraintViolationList */

        $this->assertEquals(count($errors), count($violations), (string) $violations);

        foreach ($errors as $property => $message) {
            $pattern = sprintf('/\.%s:\s+%s$/m', $property, $message);
            $this->assertRegExp($pattern, (string) $violations, $violations);
        }
    }
}
