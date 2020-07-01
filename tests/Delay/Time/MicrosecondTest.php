<?php declare(strict_types=1);

namespace Tamer\Test\Delay\Time;

use PHPUnit\Framework\TestCase;
use Tamer\Delay\Time\Microsecond;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class MicrosecondTest extends TestCase
{
    /**
     * @param float $amount
     * @param float $expected
     * @dataProvider data
     */
    public function testMicroseconds(float $amount, float $expected): void
    {
        $microseconds = new Microsecond($amount);

        $this->assertEquals($expected, $microseconds->microseconds());
    }

    /**
     * @return array[]
     */
    public function data(): array
    {
        $data = [];

        for ($i = 0; $i < 3; ++$i) {
            $amount = (float) mt_rand(0, 100);
            $data[] = [$amount, $amount];
        }

        return $data;
    }
}
