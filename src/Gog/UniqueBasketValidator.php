<?php
/**
 * @author Piotr Strugacz <piotr.strugacz@xsolve.pl>
 */

namespace Gog;
use Gog\Basket\BasketInterface;
use Gog\Basket\BasketValidatorInterface;


/**
 * Class UniqueBasketValidator
 * @package Gog
 */
class UniqueBasketValidator implements BasketValidatorInterface
{
    /**
     * @inheritdoc
     */
    public function validate(BasketInterface $basket)
    {
        $duplicates = [];
        for ($i = 0; $i < $basket->getSize(); ++$i) {
            if (!isset($duplicates[$i])) {
                $duplicates[$i] = 1;
            } else {
                $duplicates[$i]++;
            }

            if ($duplicates[$i] > 1) {
                return false;
            }
        }

        return true;
    }
}