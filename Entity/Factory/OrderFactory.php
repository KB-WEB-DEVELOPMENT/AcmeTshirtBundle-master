<?php

namespace Acme\TshirtBundle\Entity\Factory;

use
    Symfony\Component\Validator\ExecutionContext,
    Symfony\Component\Validator\Constraints as Assert,
    Acme\TshirtBundle\Entity\Order,
    Acme\TshirtBundle\Entity\Shopper
;

/**
 * @Assert\Callback(methods={"isValidShopper"})
 */
class OrderFactory
{
    /**
     * @var bool
     */
    private $known_shopper = false;

    /**
     * Phone number of known shopper.
     *
     * @var string
     */
    private $known_phone = '';

    /**
     * @var Shopper
     */
    private $shopper;

    /**
     * @Assert\Valid()
     */
    private $items = array();

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct($em)
    {
        $this->em = $em;
        $this->customer = new Shopper();
    }

    public function setKnownPhone($known_phone)
    {
        $this->known_phone = $known_phone;
    }

    public function getKnownPhone()
    {
        return $this->known_phone;
    }

    public function isKnownShopper()
    {
        return $this->known_customer;
    }

    public function setKnownShopper($boolean)
    {
        $this->known_shopper = $boolean;
    }

    public function setShopper(Shopper $shopper)
    {
        $this->shopper = $shopper;
    }

    public function getShopper()
    {
        return $this->shopper;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @param  ExecutionContext $context
     * @return bool
     */
    public function isValidShopper(ExecutionContext $context)
    {
        

        if (true === $this->known_shopper) {

            $this->customer = $this->em
                ->getRepository('AcmeTshirtBundle:Shopper')
                ->findOneBy(array(
                    'phone' => $this->known_phone,
                ))
            ;

            if (false === ($this->shopper instanceof Shopper)) {
                $property_path = $context->getPropertyPath() . '.known_phone';

                $context->setPropertyPath($property_path);
                $context->addViolation('Phone number is not registered', array(), null);
            }

        } else {

            /*
            $context->setGroup('MyTest');
            var_dump($context->getGroup());
            */

            $group = $context->getGroup();
            $group = 'Shopper';

            $context->getGraphWalker()->walkReference(
                $this->shopper,
                $group,
                $context->getPropertyPath() . ".shopper",
                true
            );
        }

        /*
        if (!($this->customer instanceof Shopper)) {
            $context->addViolation('Invalid shopper given', array(), $this->shopper);
        }
        */
    }

    /**
     * @param  ExecutionContext $context
     * @return void
     * @deprecated
     */
    public function pickedOrderItems(ExecutionContext $context)
    {
        $count = 0;

        foreach ($this->items as $item) {
            $count += $item->getCount();
        }

        if ($count === 0) {
            /*
            $property_path = $context->getPropertyPath() . '.shopper.phone';
            $property_path = $context->getPropertyPath() . '.items[0].count';
            $property_path = $context->getPropertyPath() . '.items.[0].count';
            $property_path = $context->getPropertyPath() . '.items.0.count';
            */
            $property_path = $context->getPropertyPath() . '.items[0].count';
            $context->setPropertyPath($property_path);
            $context->addViolation('You have to pick at least one T-shirt size .', array(), null);
        }
    }

    /**
     * @return \Acme\TshirtBundle\Entity\Order
     */
    public function make()
    {
        $order = new Order();
        $order->setCustomer($this->shopper);

        foreach ($this->items as $item) {
            $order->addItem($item);
        }

        return $order;
    }
}

?>
