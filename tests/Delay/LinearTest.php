<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Test\Delay;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Xwzvm\Attempt\Delay;
use Xwzvm\Attempt\Delay\Time;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class LinearTest extends TestCase
{
    /**
     * @param Time\InMicroseconds $time
     * @param int $factor
     * @param Time\InMicroseconds $addition
     * @param int[] $expected
     * @dataProvider data
     */
    public function testMicroseconds(
        Time\InMicroseconds $time,
        int $factor,
        Time\InMicroseconds $addition,
        array $expected
    ): void {
        $delay = new Delay\Linear($time, $factor, $addition);

        foreach ($expected as $microseconds) {
            $this->assertEquals($microseconds, $delay->microseconds());
        }
    }

    /**
     * @return void
     */
    public function testInvalidFactorValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument $factor cannot be 0.');

        new Delay\Linear(new Time\Second(5), 0);
    }

    /**
     * @return array[]
     */
    public function data(): array
    {
        return [
            'positive_factor_and_negative_addition' => [
                new Time\Microsecond(10.),
                10,
                new Time\Microsecond(-5.),
                [10., 95., 945., 9445., 94_445.],
            ],
            'only_positive_addition' => [
                new Time\Second(1.),
                1,
                new Time\Second(5),
                [1_000_000, 6_000_000., 11_000_000., 16_000_000., 21_000_000.],
            ],
            'only_positive_factor' => [
                new Time\Minute(1.),
                2,
                new Time\Minute(0.),
                [60_000_000., 120_000_000., 240_000_000., 480_000_000., 960_000_000.],
            ],
            'only_negative_factor' => [
                new Time\Microsecond(100.),
                -10,
                new Time\Microsecond(0.),
                [100., 10., 1., 0., 0.],
            ],
            'negative_factor_positive_addition' => [
                new Time\Second(1.),
                -10,
                new Time\Microsecond(500.),
                [1_000_000., 100_500., 10_550., 1555., 656.],
            ],
            'negative_factor_negative_addition' => [
                new Time\Minute(1.),
                -5,
                new Time\Microsecond(-100.),
                [60_000_000., 11_999_900., 2_399_880., 479_876., 95_875.],
            ],
        ];
    }
}
