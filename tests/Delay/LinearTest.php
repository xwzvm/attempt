<?php declare(strict_types=1);

namespace Tamer\Test\Delay;

use PHPUnit\Framework\TestCase;
use Tamer\Delay;
use Tamer\Delay\Time;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class LinearTest extends TestCase
{
    /**
     * @param Time\InMicroseconds $time
     * @param float $factor
     * @param Time\InMicroseconds $increment
     * @param int[] $expected
     * @dataProvider data
     */
    public function testMicroseconds(
        Time\InMicroseconds $time,
        float $factor,
        Time\InMicroseconds $increment,
        array $expected
    ): void {
        $delay = new Delay\Linear($time, $factor, $increment);

        foreach ($expected as $microseconds) {
            $this->assertEquals($microseconds, $delay->microseconds());
        }
    }

    /**
     * @return array[]
     */
    public function data(): array
    {
        return [
            'multiplying' => [
                new Time\Minute(1.),
                2.,
                new Time\Minute(0.),
                [60_000_000., 120_000_000., 240_000_000., 480_000_000., 960_000_000.],
            ],
            'multiplying_subtraction' => [
                new Time\Microsecond(10.),
                10.,
                new Time\Microsecond(-5.),
                [10., 95., 945., 9445., 94_445.],
            ],
            'addition' => [
                new Time\Second(1.),
                1.,
                new Time\Second(5),
                [1_000_000, 6_000_000., 11_000_000., 16_000_000., 21_000_000.],
            ],
            'dividing' => [
                new Time\Microsecond(100.),
                0.1,
                new Time\Microsecond(0.),
                [100., 10., 1., 0.1, 0.01],
            ],
            'dividing_addition' => [
                new Time\Second(1.),
                0.1,
                new Time\Microsecond(500.),
                [1_000_000., 100_500., 10_550., 1555., 655.5],
            ],
            'dividing_subtraction' => [
                new Time\Minute(1.),
                0.2,
                new Time\Microsecond(-100.),
                [60_000_000., 11_999_900., 2_399_880., 479_876., 95_875.2],
            ],
        ];
    }
}
