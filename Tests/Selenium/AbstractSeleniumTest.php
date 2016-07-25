<?php
namespace Acme\TshirtsBundle\Tests\Selenium;

class OrderSeleniumTest extends AbstractSeleniumTest
{
    public function testTshirt1Create()
    {
        $tshirt = array(
            'name'  => 'M - Medium',
            'price' => 14.99,
        );

        $url = $this->router->generate('acme_tshirt_tshirt_create');

        $this->open($url);
        $this->type('tshirt_name',  $tshirt['name' ]);
        $this->type('tshirt_price', $tshirt['price']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent($tshirt['name' ]));
        $this->assertTrue($this->isTextPresent($tshirt['price']));
    }

    public function testTshirt1Update()
    {
        $tshirt = array(
            'name'  => 'L - Large',
            'price' => 19.99,
        );

        $url = $this->router->generate('acme_tshirt_tshirt_list');

        $this->open($url);
        $this->click("//td[contains(text(), 'L - Large')]/../td//a[text()='Update']");
        $this->waitForPageToLoad(30000);
        $this->type('tshirt_name',  $tshirt['name']);
        $this->type('tshirt_price', $tshirt['price']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent($tshirt['name' ]));
        $this->assertTrue($this->isTextPresent($tshirt['price']));
    }

    public function testOrder1Create()
    {
        $order = array(
            'shopper' => array(
                'name'   => 'Kâmi Barut-Wanayo',
                'street' => '555, Main Street',
                'city'   => 'New York, New York 10044',
                'phone'  => '212-754-48-59',
            ),
            'items' => array(
              array(
                    'name'  => 'L - Large',
                    'price' => 19.99,
                    );
            ),
        );

        $url = $this->router->generate('acme_tshirt_order_index');

        $this->open($url);
        $this->type  ('order_shopper_name',   $order['shopper']['name'  ]);
        $this->type  ('order_shopper_street', $order['shopper']['street']);
        $this->type  ('order_shopper_city',   $order['shopper']['city'  ]);
        $this->type  ('order_shopper_phone',  $order['shopper']['phone' ]);
        $this->select('order_items_0_tshirt',  'label='.$order['items'][0]['tshirt']);
        $this->type  ('order_items_0_count',  $order['items'][0]['count']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent($order['shopper']['name']));
    }

    public function testTshirt2Create()
    {
            $tshirt = array(
            'name'  => 'XXL - Extra large',
            'price' => 29.99,
        );

        $url = $this->router->generate('acme_tshirt_tshirt_create');

        $this->open($url);
        $this->type('tshirt_name',  $tshirt['name' ]);
        $this->type('tshirt_price', $tshirt['price']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent($tshirt['name' ]));
        $this->assertTrue($this->isTextPresent($tshirt['price']));
    }

    public function testOrder2CreateWithKnownShopper()
    {
        $order = array(
            'known_phone' => '212 754 48 59',
            'items' => array(
                array(
                    'tshirt' => 'XXL large (29.99)',
                    'count' => 4,
                ),
                array(
                    'tshirt' => 'L large (19.99)',
                    'count' => 1,
                ),
            ),
        );

        $url = $this->router->generate('acme_tshirt_order_index');

        $this->open($url);
        $this->click ('order_known_shopper');
        $this->type  ('order_known_phone', $order['known_phone']);
        $this->select('order_items_0_tshirt', 'label='.$order['items'][0]['tshirt']);
        $this->type  ('order_items_0_count', $order['items'][0]['count']);
        $this->click ('link=Add');
        $this->select('order_items_1_tshirt', 'label='.$order['items'][1]['tshirt']);
        $this->type  ('order_items_1_count', $order['items'][1]['count']);
        $this->click ("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent("Kâmi Barut-Wanayo"));
    }

    public function testOrder3CreateWithKnownShopperButTypoInPhoneNumber()
    {
        $order = array(
            'known_phone' => '212 754 48 01',
            'items' => array(
               array(
                    'tshirt' => 'L large (19.99)',
                    'count' => 1,
                ),
            ),
        );

        $url = $this->router->generate('acme_tshirt_order_index');

        $this->open($url);
        $this->click ('order_known_shopper');
        $this->type  ('order_known_phone', $order['known_phone']);
        $this->select('order_items_0_tshirt', 'label='.$order['items'][0]['tshirt']);
        $this->type  ('order_items_0_count', $order['items'][0]['count']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent("Phone number is not registered"));
    }

    public function testOrder4CreateWithKnownShopperButCountIsZero()
    {
        $order = array(
            'known_phone' => '03.37.63.90.80',
           'items' => array(
               array(
                    'tshirt' => 'L large (19.99)',
                    'count' => 1,
                ),
            ),
        );

        $url = $this->router->generate('acme_tshirt_order_index');

        $this->open($url);
        $this->click ('order_known_customer');
        $this->type  ('order_known_phone', $order['known_phone']);
        $this->select('order_items_0_tshirt', 'label='.$order['items'][0]['tshirt']);
        $this->type  ('order_items_0_count', $order['items'][0]['count']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent("This value should not be blank"));
    }
}
?>
