<?php
/**
 * @author Piotr Strugacz <piotr.strugacz@xsolve.pl>
 */

namespace Gog\Basket;


/**
 * Interface BasketFactoryInterface
 * @package Gog\Basket
 */
interface BasketFactoryInterface
{
    /**
     * @param array $allowedValues
     * @return BasketFactoryInterface
     */
    public function setAllowedValues(array $allowedValues) : BasketFactoryInterface;

    /**
     * @param array $restrictedValues
     * @return BasketFactoryInterface
     */
    public function setRestrictedValues(array $restrictedValues) : BasketFactoryInterface;

    /**
     * @param int $id
     * @param int $size
     * @return BasketInterface
     */
    public function create(int $id, int $size);
}