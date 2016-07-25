<?php

namespace Acme\TshirtsBundle\Tests\Entity;

use
    Acme\TshirtBundle\Entity\Tshirt
;

class TshirtEntityTest extends AbstractEntityTest
{
    public static function provider()
    {
        $data = array();

        $data[] = array(
            'properties' => array(
                'name'  => 'L - Large',
                'price' => 19.99,
            ),
            'errors' => array(),
        );

        $data[] = array(
            'properties' => array(
                'name'  => 'XXL - Extra large',
                'price' => 29.99,
            ),
            'errors' => array(),
        );

        $data[] = array(
            'properties' => array(),
            'errors' => array(
                'name'  => 'This value should not be blank',
                'price' => 'This value should not be blank',
            ),
        );

        $data[] = array(
            'properties' => array(
                'name'  => 'test',
                'price' => 'wronginput',
            ),
            'errors' => array(
                'name'  => 'This value is too short. It should have 5 characters or more',
                'price' => 'This value should be a valid number',
            ),
        );

        $data[] = array(
            'properties' => array(
                'name'  => 'Big Sicilian',
                'price' => -5.40,
            ),
            'errors' => array(
                'price' => 'This value should be a positive number',
            ),
        );

        return $data;
    }

    /**
     * @dataProvider provider
     */
    public function testValidation(array $properties, array $errors)
    {
        $tshirt = new Tshirt();

        foreach ($properties as $property => $value) {
            $tshirt->set($property, $value);
        }

        $violations = self::$validator->validate($tshirt);
        /* @var $violations \Symfony\Component\Validator\ConstraintViolationList */

        $this->assertEquals(count($errors), count($violations), (string) $violations);

        foreach ($errors as $property => $message) {
            $pattern = sprintf('/\.%s:\s+%s$/m', $property, $message);
            $this->assertRegExp($pattern, (string) $violations, $violations);
        }
    }
}
?>
