<?php
namespace Acme\TshirtBundle\Form\Type;

use
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder
;

class OrderItemType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('tshirt', 'entity', array(
                'class'         => 'Acme\TshirtBundle\Entity\Tshirt',
                'query_builder' => function ($repository) { return $repository->createQueryBuilder('t')->orderBy('t.name', 'ASC'); },
            ))
            ->add('count', 'integer')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'Acme\TshirtBundle\Entity\OrderItem');
    }

     public function getName()
    {
        return 'order_item';
    }
}

?>
