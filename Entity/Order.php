<?php

namespace Acme\TshirtBundle\Entity;

use
    Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert
;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_")
 */
class Order
{
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    protected $date;

    /**
     * @var \Acme\TshirtBundle\Entity\Shopper
     *
     * @ORM\ManyToOne(targetEntity="Shopper", cascade={"persist"})
     * @Assert\NotBlank()
     */
    protected $shopper;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="OrderItem", mappedBy="order", cascade={"persist"})
     * @Assert\NotBlank()
     */
    protected $items;

    /**
     * 
     */
    public function __construct()
    {
        $this->date  = new \DateTime('now');
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get the id
     * 
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the date
     * 
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Get the date
     * 
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the related shopper
     * 
     * @param \Acme\TshirtBundle\Entity\Shopper $shopper
     */
    public function setShopper(Shopper $shopper)
    {
        $this->shopper = $shopper;
    }

    /**
     * Get the related shopper
     * 
     * @return \Acme\TshirtBundle\Entity\Shopper
     */
    public function getShopper()
    {
        return $this->shopper;
    }

    /**
     * Set the collection of related items
     * 
     * @param \Doctrine\Common\Collections\ArrayCollection $items
     */
    public function setItems(\Doctrine\Common\Collections\ArrayCollection $items)
    {
        $this->items = $items;
    }

    /**
     * Add a item to the collection of related items
     * 
     * @param \Acme\TshirtBundle\Entity\OrderItem $item
     */
    public function addItem(OrderItem $item)
    {
        $this->items->add($item);
        $item->setOrder($this);
    }

    /**
     * Remove a item from the collection of related items
     * 
     * @param \Acme\TshirtBundle\Entity\OrderItem $item
     */
    public function removeItem(OrderItem $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get the collection of related items
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set a property
     * 
     * @param string $name
     * @param mixed  $value
     * 
     * @throws \InvalidArgumentException If the property does not exists
     */
    public function set($name, $value)
    {
        switch ($name) {
            case 'date':
                $this->setDate($value);
                break;

            case 'shopper':
                $this->setShopper($value);
                break;

            case 'items':
                $this->setItems($value);
                break;

            default:
                throw new \InvalidArgumentException(sprintf('Generic setter for "%s" is not defined', $name));
        }
    }

    /**
     * Get a property
     * 
     * @param string $name
     * 
     * @return mixed
     * 
     * @throws \InvalidArgumentException If the property does not exists
     */
    public function get($name)
    {
        switch ($name) {
            case 'id':
                return $this->getId($value);

            case 'date':
                return $this->getDate($value);

            default:
                throw new \InvalidArgumentException(sprintf('Generic getter for "%s" is not defined', $name));
        }
    }

    public function getTotal()
    {
        $total = 0.0;

        foreach ($this->items as $item) {
            $total+= $item->getTotal();
        }

        return $total;
    }
}

?>
