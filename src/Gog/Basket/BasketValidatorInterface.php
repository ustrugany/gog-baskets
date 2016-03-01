<?php
/**
 * @author Piotr Strugacz <piotr.strugacz@xsolve.pl>
 */

namespace Gog\Basket;


/**
 * Interface BasketValidatorInterface
 * @package Gog\Basket
 */
interface BasketValidatorInterface
{
    /**
     * @param BasketInterface $basket
     * @return bool
     */
    public function validate(BasketInterface $basket);
}