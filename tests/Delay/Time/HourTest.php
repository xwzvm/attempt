<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Test\Delay\Time;

use PHPUnit\Framework\TestCase;
use Xwzvm\Attempt\Delay\Time\Hour;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class HourTest extends TestCase
{
    private const MICROSECONDS_PER_HOUR = 3_600_000_000;

    /**
     * @param int $amount
     * @param int $expected
     * @dataProvider data
     */
    public function testMicroseconds(int $amount, int $expected): void
    {
        $hours = new Hour($amount);

        $this->assertEquals($expected, $hours->microseconds());
    }

    /**
     * @return void
     */
    public function testNegativeAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument $amount must be at least 0.');

        new Hour(-1);
    }

    /**
     * @return array[]
     */
    public function data(): array
    {
        $data = [];

        for ($i = 0; $i < 3; ++$i) {
            $amount = mt_rand(0, 100);
            $data[] = [$amount, $amount * self::MICROSECONDS_PER_HOUR];
        }

        return $data;
    }
}
