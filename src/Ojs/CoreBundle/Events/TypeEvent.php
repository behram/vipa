<?php

namespace Ojs\CoreBundle\Events;

use Symfony\Component\Form\AbstractType;

class TypeEvent
{
    /** @var AbstractType */
    private $type;

    /**
     * @param AbstractType $type
     */
    public function __construct(AbstractType $type)
    {
        $this->type = $type;
    }

    /**
     * @return AbstractType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param AbstractType $type
     * @return TypeEvent
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}