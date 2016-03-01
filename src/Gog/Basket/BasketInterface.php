<?php
/**
 * @author Piotr Strugacz <piotr.strugacz@xsolve.pl>
 */

namespace Gog\Basket;


/**
 * Interface BasketInterface
 * @package Gog\Basket
 */
interface BasketInterface
{
    /**
     * @return array
     */
    public function getValues() : array;

    /**
     * @return array
     */
    public function getId() : int;

    /**
     * @return int
     */
    public function getSize() : int;
}