<?php declare(strict_types=1);

namespace Tamer\Test\Time;

use PHPUnit\Framework\TestCase;
use Tamer\Time;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class NowTest extends TestCase
{
    private const MICROSECONDS_PER_SECOND = 1_000_000;

    /**
     * @return void
     */
    public function testMicroseconds(): void
    {
        $now = new Time\Now();

        $this->assertEquals(time() * self::MICROSECONDS_PER_SECOND, $now->microseconds());
    }
}
