<?php
/**
 * @author Piotr Strugacz <piotr.strugacz@xsolve.pl>
 */

namespace Gog;

use Gog\Basket\BasketDifferenceInterface;
use Gog\Basket\BasketInterface;


/**
 * Class BasketDifference
 * @package Gog
 */
class BasketDifference implements BasketDifferenceInterface
{
    /**
     * @inheritdoc
     */
    public function difference(BasketInterface $first, BasketInterface $second)
    {
        if ($first->getSize() < $second->getSize()) {
            $biggerBasket = $second;
            $smallerBasket = $first;
        } else {
            $biggerBasket = $first;
            $smallerBasket = $second;
        }

        $biggerSet = $this->sort($biggerBasket->getValues());
        $smallerSet = $this->sort($smallerBasket->getValues());
        $smallerSetSize = $smallerBasket->getSize();
        $biggerSetSize = $biggerBasket->getSize();

        $i = 0;
        $searchOffset = 0;
        while ($i < $smallerSetSize) {
            for ($j = $searchOffset; $j < $biggerSetSize; $j++) {
                if ($smallerSet[$i] == $biggerSet[$j]) {
                    unset($smallerSet[$i]);
                    $searchOffset = $j;
                    break;
                }
            }
            $i++;
        }

        return $smallerSet;
    }

    /**
     * @param array $values
     * @return array
     */
    private function sort(array $values) : array
    {
        sort($values);

        return $values;
    }
}