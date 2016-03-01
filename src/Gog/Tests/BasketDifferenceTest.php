<?php
/**
 * @author Piotr Strugacz <piotr.strugacz@xsolve.pl>
 */

namespace Gog\Tests;
use Gog\Basket;
use Gog\Basket\BasketInterface;
use Gog\BasketDifference;
use Gog\BasketFactory;


/**
 * Class BasketsTest
 * @package Gog\Tests
 */
class BasketDifferenceTest extends \PHPUnit_Framework_TestCase
{
    const MIN_VALUE = 0;
    const MAX_VALUE = 999;
    const MIN_BASKET_SIZE = 1;
    const MAX_BASKET_SIZE = 10;
    const NUMBER_OF_BASKETS = 30;
    const USER_BASKET_SIZE = 100;

    /**
     * @dataProvider provideDynamicBaskets
     */
    public function testDynamicBaskets(array $baskets, BasketInterface $userBasket)
    {
        echo PHP_EOL . "UserBasket#{$userBasket->getId()}" . $userBasket;

        $matchingAllElements = [];
        $matchingExactlyOneElement = [];
        $basketDifference = new BasketDifference();

        /**
         * @var BasketInterface $basket
         */
        foreach ($baskets as $basket) {
            $differenceCount = count($basketDifference->difference($basket, $userBasket));
            switch ($differenceCount) {
                case 1:
                    if (1 == $basket->getSize()) {
                        $matchingAllElements[] = $basket;
                    } else {
                        $matchingExactlyOneElement[] = $basket;
                    }
                    break;
                case $basket->getSize():
                    $matchingAllElements[] = $basket;
                    break;
            }
        }

        if ([] != $matchingAllElements) {
            echo PHP_EOL . 'Baskets matching all elements:';
            foreach ($matchingAllElements as $basket) {
                echo PHP_EOL . "Basket#{$basket->getId()}" . $basket;
            }
        }

        if ([] != $matchingExactlyOneElement) {
            echo PHP_EOL . 'Baskets matching exactly one element:';
            foreach ($matchingExactlyOneElement as $basket) {
                echo PHP_EOL . "Basket#{$basket->getId()}" . $basket;
            }
        }
    }

    /**
     * @return array
     */
    public function provideDynamicBaskets()
    {
        $basketFactory = new BasketFactory(static::MIN_VALUE, static::MAX_VALUE);
        $baskets = [];
        for ($i = 0; $i < static::NUMBER_OF_BASKETS; $i++) {
            $baskets[] = $basketFactory->create(
                $i,
                rand(
                    static::MIN_BASKET_SIZE,
                    static::MAX_BASKET_SIZE
                )
            );
        }

        return [
            [
                $baskets,
                $basketFactory->create(
                    static::NUMBER_OF_BASKETS,
                    rand(static::MIN_BASKET_SIZE, static::USER_BASKET_SIZE)
                )
            ],
        ];
    }

    /**
     * @dataProvider provideStaticBasketsMatchingExactlyOneElement
     */
    public function testMatchingExactlyOneElement(array $baskets)
    {
        $userBasket = $this->provideStaticUserBasket();
        $difference = new BasketDifference();
        echo PHP_EOL . 'Matching exactly one element';
        echo PHP_EOL . "user#{$userBasket->getId()} ". $userBasket;
        foreach ($baskets as $basket) {
            echo PHP_EOL . "#{$basket->getId()} " . $basket;
            $this->assertGreaterThanOrEqual(1, count($difference->difference($basket, $userBasket)));
        }
    }

    /**
     * @dataProvider provideStaticBasketsMatchingAllElements
     */
    public function testMatchingAllElements(array $baskets)
    {
        $userBasket = $this->provideStaticUserBasket();
        $difference = new BasketDifference();
        echo PHP_EOL . 'Matching all elements';
        echo PHP_EOL . "UserBasket#{$userBasket->getId()} " . $userBasket;
        foreach ($baskets as $basket) {
            echo PHP_EOL . "Basket#{$basket->getId()} " . $basket;
            $this->assertEquals(0, count($difference->difference($basket, $userBasket)));
        }
    }

    /**
     * @return array
     */
    public function provideStaticBasketsMatchingAllElements()
    {
        return [
            [
                [
                    new Basket(999, [1, 2, 4, 5]),
                    new Basket(1000, [6, 7, 8, 9])
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function provideStaticBasketsMatchingExactlyOneElement()
    {
        return [
            [
                [
                    new Basket(888, [1, 10]),
                    new Basket(889, [2, 11]),
                    new Basket(890, [3, 12])
                ]
            ]
        ];
    }

    /**
     * @return Basket
     */
    public function provideStaticUserBasket()
    {
        return new Basket(777, [1, 2, 4, 5, 6, 7, 8, 9]);
    }
}