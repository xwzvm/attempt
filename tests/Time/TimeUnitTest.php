<?php declare(strict_types=1);

namespace Tamer\Test\Time;

use PHPUnit\Framework\TestCase;
use Tamer\Time;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
abstract class TimeUnitTest extends TestCase
{
    /**
     * @param float $amount
     * @return Time\Unit
     */
    abstract protected function unit(float $amount): Time\Unit;

    /**
     * @return int
     */
    abstract protected function factor(): int;

    /**
     * @param float $amount
     * @param float $expected
     * @dataProvider microseconds
     */
    public function testMicroseconds(float $amount, float $expected): void
    {
        $time = $this->unit($amount);

        $this->assertEquals($expected, $time->microseconds());
    }

    /**
     * @param float $x
     * @param float $y
     * @param float $expected
     * @dataProvider summands
     */
    public function testAdd(float $x, float $y, float $expected): void
    {
        $sum = $this->unit($x)->add($this->unit($y));

        $this->assertEquals($expected, $sum->microseconds());
    }

    /**
     * @return array[]
     */
    final public function microseconds(): array
    {
        $data = [];

        for ($i = 0; $i < 3; ++$i) {
            $amount = (float) mt_rand(0, 100);
            $data[] = [$amount, $amount * $this->factor()];
        }

        return $data;
    }

    /**
     * @return array[]
     */
    final public function summands(): array
    {
        return [
            [10., 25., 35. * $this->factor()],
            [-10., 25., 15. * $this->factor()],
            [-10., -25., -35. * $this->factor()],
        ];
    }
}
