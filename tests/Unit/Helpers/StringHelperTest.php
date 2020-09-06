<?php

namespace Tests\Unit\Helpers;

use PHPSoda\Helpers\StringHelper;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    /**
     * @dataProvider provideTestMatches
     * @param string $pattern
     * @param string $input
     * @param bool   $expected
     */
    public function testMatches(string $pattern, string $input, bool $expected)
    {
        self::assertEquals($expected, StringHelper::matches($pattern, $input));
    }

    /**
     * @return array
     */
    public function provideTestMatches(): array
    {
        return [
            ['a', 'abc', true],
            ['b', 'abc', true],
            ['c', 'abc', true],
            ['ab', 'abc', true],
            ['bc', 'abc', true],
            ['abc', 'abc', true],
            ['d', 'abc', false],
            ['\d', 'abc', false],
            ['\w', 'abc', true],
            ['\w{3}', 'abc', true],
            ['\w{4}', 'abc', false],
        ];
    }

    /**
     * @dataProvider provideTestEquals
     * @param string $pattern
     * @param string $input
     * @param bool   $expected
     */
    public function testEquals(string $pattern, string $input, bool $expected)
    {
        self::assertEquals($expected, StringHelper::equals($pattern, $input));
    }

    /**
     * @return array
     */
    public function provideTestEquals(): array
    {
        return [
            ['a', 'abc', false],
            ['b', 'abc', false],
            ['c', 'abc', false],
            ['ab', 'abc', false],
            ['bc', 'abc', false],
            ['abc', 'abc', true],
            ['d', 'abc', false],
            ['\d', 'abc', false],
            ['\w', 'abc', false],
            ['\w{3}', 'abc', true],
            ['\w{4}', 'abc', false],
        ];
    }

    /**
     * @dataProvider provideTestContains
     * @param string $haystack
     * @param string $needle
     * @param bool   $expected
     */
    public function testContains(string $haystack, string $needle, bool $expected)
    {
        self::assertEquals($expected, StringHelper::contains($haystack, $needle));
    }

    /**
     * @return array
     */
    public function provideTestContains(): array
    {
        return [
            ['abc', 'a', true],
            ['abc', 'b', true],
            ['abc', 'c', true],
            ['abc', 'ab', true],
            ['abc', 'bc', true],
            ['abc', 'abc', true],
            ['abc', 'd', false],
            ['abc', '\d', false],
            ['abc', '\w', true],
            ['abc', '\w{3}', true],
            ['abc', '\w{4}', false],
        ];
    }

    /**
     * @dataProvider provideTestStartsWith
     * @param string $haystack
     * @param string $needle
     * @param bool   $expected
     */
    public function testStartsWith(string $haystack, string $needle, bool $expected)
    {
        self::assertEquals($expected, StringHelper::startsWith($haystack, $needle));
    }

    /**
     * @return array
     */
    public function provideTestStartsWith(): array
    {
        return [
            ['abc', 'a', true],
            ['abc', 'b', false],
            ['abc', 'c', false],
            ['abc', 'ab', true],
            ['abc', 'bc', false],
            ['abc', 'abc', true],
            ['abc', 'd', false],
            ['abc', '\d', false],
            ['abc', '\w', true],
            ['abc', '\w{3}', true],
            ['abc', '\w{4}', false],
        ];
    }

    /**
     * @dataProvider provideTestEndsWith
     * @param string $haystack
     * @param string $needle
     * @param bool   $expected
     */
    public function testEndsWith(string $haystack, string $needle, bool $expected)
    {
        self::assertEquals($expected, StringHelper::endsWith($haystack, $needle));
    }

    /**
     * @return array
     */
    public function provideTestEndsWith(): array
    {
        return [
            ['abc', 'a', false],
            ['abc', 'b', false],
            ['abc', 'c', true],
            ['abc', 'ab', false],
            ['abc', 'bc', true],
            ['abc', 'abc', true],
            ['abc', 'd', false],
            ['abc', '\d', false],
            ['abc', '\w', true],
            ['abc', '\w{3}', true],
            ['abc', '\w{4}', false],
        ];
    }
}
