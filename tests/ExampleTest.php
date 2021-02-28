<?php

declare(strict_types=1);

namespace Khandurdyiev\MonoClient\Tests;

use PHPUnit\Framework\TestCase;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class ExampleTest extends TestCase
{
    public function testSimple(): void
    {
        self::assertTrue(true);
    }
}
