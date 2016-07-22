<?php
namespace Acme\TshirtBundle\Form\Type;

use
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder
;

class ShopperType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('street')
            ->add('city')
            ->add('phone')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'Acme\TshirtBundle\Entity\Shopper');
    }

    public function getName()
    {
        return 'shopper';
    }
}

?>
