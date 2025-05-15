<?php

declare(strict_types=1);

namespace FormatPHP\Test\Intl;

use FormatPHP\Exception\UnableToFormatDisplayNameException;
use FormatPHP\Intl\DisplayNames;
use FormatPHP\Intl\DisplayNamesOptions;
use FormatPHP\Intl\Locale;
use FormatPHP\Test\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class DisplayNamesTest extends TestCase
{
    /**
     * @param "region" | "script" $type
     */
    #[DataProvider('invalidValueProvider')]
    public function testThrowsExceptionForInvalidValue(string $value, string $type): void
    {
        $locale = new Locale('en-US');
        $options = new DisplayNamesOptions(['type' => $type]);
        $displayNames = new DisplayNames($locale, $options);

        $this->expectException(UnableToFormatDisplayNameException::class);
        $this->expectExceptionMessage("Invalid value \"$value\" for option $type");

        $displayNames->of($value);
    }

    /**
     * @return array<array{value: string, type: string}>
     */
    public static function invalidValueProvider(): array
    {
        return [
            ['value' => 'A', 'type' => 'region'],
            ['value' => 'a', 'type' => 'region'],
            ['value' => 'AAA', 'type' => 'region'],
            ['value' => 'aaa', 'type' => 'region'],
            ['value' => '1', 'type' => 'region'],
            ['value' => '12', 'type' => 'region'],
            ['value' => '1234', 'type' => 'region'],
            ['value' => 'A', 'type' => 'script'],
            ['value' => 'Ab', 'type' => 'script'],
            ['value' => 'Abc', 'type' => 'script'],
            ['value' => 'Abcde', 'type' => 'script'],
            ['value' => 'Abc1', 'type' => 'script'],
            ['value' => 'a', 'type' => 'currency'],
            ['value' => 'ab', 'type' => 'currency'],
            ['value' => 'abcd', 'type' => 'currency'],
            ['value' => 'ab1', 'type' => 'currency'],
        ];
    }
}
