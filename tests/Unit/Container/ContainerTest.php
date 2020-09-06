<?php

namespace Tests\Unit\Container;

use ArrayIterator;
use Exception;
use PHPSoda\Container\Container;
use Tests\TestCase;

/**
 * Class ContainerTest
 *
 * @package Tests\Unit\Container
 */
class ContainerTest extends TestCase
{
    /**
     * @dataProvider provideItems
     * @param array $items
     */
    public function testHas(array $items)
    {
        $container = new Container($items);
        $keys = array_keys($items);

        foreach ($keys as $key) {
            self::assertTrue($container->has($key));
        }

        self::assertSameSize($items, $container);
    }

    /**
     * @dataProvider provideItems
     * @param array $items
     */
    public function testGet(array $items)
    {
        $container = new Container($items);
        $keys = array_keys($items);

        foreach ($keys as $key) {
            self::assertEquals($items[$key], $container->get($key));
        }

        self::assertSameSize($items, $container);
    }

    /**
     * @dataProvider provideItems
     * @param array $items
     */
    public function testSet(array $items)
    {
        $container = new Container();
        $keys = array_keys($items);

        foreach ($keys as $key) {
            $container->set($key, $items[$key]);

            self::assertEquals($items[$key], $container->get($key));
        }

        self::assertSameSize($items, $container);
    }

    /**
     * @dataProvider provideItems
     * @param array $items
     */
    public function testClear(array $items)
    {
        $container = new Container($items);
        $keys = array_keys($items);

        foreach ($keys as $key) {
            $container->clear($key);

            self::assertFalse($container->has($key));
        }

        self::assertCount(0, $container);
    }

    /**
     * @dataProvider provideItems
     * @param array $items
     */
    public function testJsonSerialize(array $items)
    {
        $container = new Container($items);

        self::assertEquals($items, $container->jsonSerialize());
    }

    /**
     * @dataProvider provideItems
     * @param array $items
     * @throws Exception
     */
    public function testGetIterator(array $items)
    {
        $container = new Container($items);

        self::assertEquals(new ArrayIterator($items), $container->getIterator());
    }

    /**
     * @dataProvider provideItems
     * @param array $items
     */
    public function testCount(array $items)
    {
        self::assertSameSize($items, new Container($items));
    }

    /**
     * @return array
     */
    public function provideItems(): array
    {
        return [
            [[]],
            [[1, 2, 3]],
            [['a', 'b', 'c']],
            [['x' => 1, 'y' => 2]],
        ];
    }
}