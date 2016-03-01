<?php
/**
 * @author Piotr Strugacz <piotr.strugacz@xsolve.pl>
 */

namespace Gog;
use Gog\Basket\BasketFactoryInterface;
use Gog\Basket\BasketInterface;

/**
 * Class BasketFactory
 * @package Gog
 */
class BasketFactory implements BasketFactoryInterface
{
    /**
     * @var int
     */
    private $high;

    /**
     * @var int
     */
    private $low;

    /**
     * @var array
     */
    private $allowedValues;

    /**
     * @var array
     */
    private $restrictedValues;

    /**
     * @var int
     */
    private $allowedValuesSize;

    /**
     * BasketFactory constructor.
     * @param int $low
     * @param int $high
     */
    public function __construct(int $low, int $high)
    {
        $this->high = $high;
        $this->low = $low;
        $this->allowedValues = range($low, $high);
        $this->allowedValuesSize = count($this->allowedValues);
        $this->restrictedValues = [];
    }

    /**
     * @inheritdoc
     */
    public function create(int $id, int $size) : BasketInterface
    {
        $usedIndexesCount = 0;
        $usedIndexes = [];
        $values = [];
        while (0 < $size) {
            if ($usedIndexesCount == $this->allowedValuesSize) {
                throw new \OutOfRangeException('Out of allowed values range, change restricted/allowed values parameters');
            }

            $index = $this->getRandomIndex();
            if (in_array($index, $usedIndexes)) {
                continue;
            }

            if (!$this->isRestrictedValue($this->allowedValues[$index])) {
                $values[] = $this->allowedValues[$index];
                $size--;
            }

            $usedIndexesCount++;
            $usedIndexes[] = $index;
        }

        return new Basket($id, $values);
    }

    /**
     * @inheritdoc
     */
    public function setAllowedValues(array $allowedValues) : BasketFactoryInterface
    {
        $this->allowedValues = $allowedValues;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setRestrictedValues(array $restrictedValues) : BasketFactoryInterface
    {
        $this->restrictedValues = $restrictedValues;

        return $this;
    }

    /**
     * @return int
     */
    private function getRandomIndex() : int
    {
        return rand(0, $this->allowedValuesSize - 1);
    }

    /**
     * @param int $value
     * @return bool
     */
    private function isRestrictedValue(int $value) : bool
    {
        return in_array($value, $this->restrictedValues);
    }
}