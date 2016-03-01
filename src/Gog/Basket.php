<?php
/**
 * @author Piotr Strugacz <piotr.strugacz@xsolve.pl>
 */

namespace Gog;
use Gog\Basket\BasketInterface;


/**
 * Class Basket
 * @package Gog
 */
class Basket implements BasketInterface
{
    /**
     * @var array
     */
    private $values;

    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $id;

    /**
     * Basket constructor.
     * @param int $id
     * @param array $values
     */
    public function __construct(int $id, array $values)
    {
        $this->id = $id;
        $this->size = count($values);
        $this->values = $values;
    }

    /**
     * @inheritdoc
     */
    public function getValues() : array
    {
        return $this->values;
    }

    /**
     * @inheritdoc
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getSize() : int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(',', $this->values);
    }
}