<?php

declare(strict_types=1);

namespace FormatPHP\Test\Icu\MessageFormat\Parser;

use FormatPHP\Icu\MessageFormat\Parser\Error;
use FormatPHP\Icu\MessageFormat\Parser\Type\Location;
use FormatPHP\Icu\MessageFormat\Parser\Type\LocationDetails;
use FormatPHP\Test\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use RuntimeException;

/**
 * @phpstan-import-type ErrorKind from Error
 */
class ErrorTest extends TestCase
{
    public function testConstructor(): void
    {
        $start = new LocationDetails(0, 1, 1);
        $end = new LocationDetails(2, 4, 6);
        $location = new Location($start, $end);

        $error = new Error(Error::EMPTY_ARGUMENT, 'a test message', $location);

        $this->assertSame(Error::EMPTY_ARGUMENT, $error->kind);
        $this->assertSame('a test message', $error->message);
        $this->assertSame($location, $error->location);
        $this->assertNull($error->getThrowable());
    }

    public function testConstructorAcceptsThrowable(): void
    {
        $start = new LocationDetails(0, 1, 1);
        $end = new LocationDetails(2, 4, 6);
        $location = new Location($start, $end);
        $exception = new RuntimeException();

        $error = new Error(Error::EMPTY_ARGUMENT, 'a test message', $location, $exception);

        $this->assertSame($exception, $error->getThrowable());
    }

    /**
     * @param ErrorKind $kind
     */
    #[DataProvider('provideErrorKind')]
    public function testGetErrorKindName(int $kind, string $expected): void
    {
        $start = new LocationDetails(0, 1, 1);
        $end = new LocationDetails(2, 4, 6);
        $location = new Location($start, $end);

        $error = new Error($kind, 'A test message', $location);

        $this->assertSame($expected, $error->getErrorKindName());
    }

    /**
     * @return array<array{kind: ErrorKind, expected: string}>
     */
    public static function provideErrorKind(): array
    {
        return [
            ['kind' => 0, 'expected' => 'OTHER'],
            ['kind' => 1, 'expected' => 'EXPECT_ARGUMENT_CLOSING_BRACE'],
            ['kind' => 2, 'expected' => 'EMPTY_ARGUMENT'],
            ['kind' => 3, 'expected' => 'MALFORMED_ARGUMENT'],
            ['kind' => 4, 'expected' => 'EXPECT_ARGUMENT_TYPE'],
            ['kind' => 5, 'expected' => 'INVALID_ARGUMENT_TYPE'],
            ['kind' => 6, 'expected' => 'EXPECT_ARGUMENT_STYLE'],
            ['kind' => 7, 'expected' => 'INVALID_NUMBER_SKELETON'],
            ['kind' => 8, 'expected' => 'INVALID_DATE_TIME_SKELETON'],
            ['kind' => 9, 'expected' => 'EXPECT_NUMBER_SKELETON'],
            ['kind' => 10, 'expected' => 'EXPECT_DATE_TIME_SKELETON'],
            ['kind' => 11, 'expected' => 'UNCLOSED_QUOTE_IN_ARGUMENT_STYLE'],
            ['kind' => 12, 'expected' => 'EXPECT_SELECT_ARGUMENT_OPTIONS'],
            ['kind' => 13, 'expected' => 'EXPECT_PLURAL_ARGUMENT_OFFSET_VALUE'],
            ['kind' => 14, 'expected' => 'INVALID_PLURAL_ARGUMENT_OFFSET_VALUE'],
            ['kind' => 15, 'expected' => 'EXPECT_SELECT_ARGUMENT_SELECTOR'],
            ['kind' => 16, 'expected' => 'EXPECT_PLURAL_ARGUMENT_SELECTOR'],
            ['kind' => 17, 'expected' => 'EXPECT_SELECT_ARGUMENT_SELECTOR_FRAGMENT'],
            ['kind' => 18, 'expected' => 'EXPECT_PLURAL_ARGUMENT_SELECTOR_FRAGMENT'],
            ['kind' => 19, 'expected' => 'INVALID_PLURAL_ARGUMENT_SELECTOR'],
            ['kind' => 20, 'expected' => 'DUPLICATE_PLURAL_ARGUMENT_SELECTOR'],
            ['kind' => 21, 'expected' => 'DUPLICATE_SELECT_ARGUMENT_SELECTOR'],
            ['kind' => 22, 'expected' => 'MISSING_OTHER_CLAUSE'],
            ['kind' => 23, 'expected' => 'INVALID_TAG'],
            ['kind' => 25, 'expected' => 'INVALID_TAG_NAME'],
            ['kind' => 26, 'expected' => 'UNMATCHED_CLOSING_TAG'],
            ['kind' => 27, 'expected' => 'UNCLOSED_TAG'],
        ];
    }
}
