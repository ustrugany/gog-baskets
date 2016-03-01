<?php
/**
 * @author Piotr Strugacz <piotr.strugacz@xsolve.pl>
 */

namespace Gog\Tests;
use Gog\Basket;
use Gog\Basket\BasketFactoryInterface;
use Gog\Basket\BasketInterface;
use Gog\BasketDifference;
use Gog\BasketFactory;
use Gog\Solution;
use Gog\UniqueBasketValidator;


/**
 * Class BasketFactoryTest
 * @package Gog\Tests
 */
class BasketFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testThatFactoryCreateBasketInstance()
    {
        $basketFactory = new BasketFactory(0, 10);
        $basket = $basketFactory->create(1, 5);
        $this->assertInstanceOf('Gog\Basket\BasketInterface', $basket);
    }

    public function testThatCreatedBasketHasCorrectAttributes()
    {
        $basketFactory = new BasketFactory(0, 10);
        $basket = $basketFactory->create(1, 5);
        $this->assertEquals(5, $basket->getSize());
        $this->assertEquals(1, $basket->getId());
    }

    public function testThatCreatedBasketDoesNotContainExcludedValues()
    {
        $basketFactory = new BasketFactory(1, 5);
        $basketFactory->setRestrictedValues([5, 4, 3]);
        $basket = $basketFactory->create(1, 2);
        $this->assertNotContains([5, 4, 3], $basket->getValues());
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testInvalidBasketFactoryConfiguration()
    {
        $basketFactory = new BasketFactory(1, 5);
        $basketFactory->setRestrictedValues([5, 4, 3, 2, 1]);
        $basketFactory->create(1, 2);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testThatOutOfRangeExceptionIsThrown()
    {
        $basketFactory = new BasketFactory(1, 5);
        $basketFactory->setRestrictedValues([5, 4, 3, 2, 1]);
        $basketFactory->create(1, 100);
    }

    public function testThatCreatedBasketContainsUniqueValues()
    {
        $validator = new UniqueBasketValidator();
        $basketFactory = new BasketFactory(1, 100);
        $basket = $basketFactory->create(1, 100);
        $this->assertEquals(true, $validator->validate($basket));
    }
}