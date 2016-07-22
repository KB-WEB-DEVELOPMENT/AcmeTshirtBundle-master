<?php
namespace Acme\TshirtBundle\Form\Type;

use
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder
;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('shopper', new ShopperType())
            ->add('items', 'collection', array(
                'type'      => new OrderItemType(),
                'allow_add' => true,
                'prototype' => true,
            ))
        ;
    }

     public function getName()
    {
        return 'order';
    }
}
?>
