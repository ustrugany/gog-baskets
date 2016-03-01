<?php
/**
 * @author Piotr Strugacz <piotr.strugacz@xsolve.pl>
 */

namespace Gog\Basket;


/**
 * Interface BasketDifferenceInterface
 * @package Gog\Basket
 */
interface BasketDifferenceInterface
{
    /**
     * @param BasketInterface $first
     * @param BasketInterface $second
     * @return array
     */
    public function difference(BasketInterface $first, BasketInterface $second);
}