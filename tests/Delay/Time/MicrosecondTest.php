<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Test\Delay\Time;

use PHPUnit\Framework\TestCase;
use Xwzvm\Attempt\Delay\Time\Microsecond;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class MicrosecondTest extends TestCase
{
    /**
     * @param int $amount
     * @param int $expected
     * @dataProvider data
     */
    public function testMicroseconds(int $amount, int $expected): void
    {
        $microseconds = new Microsecond($amount);

        $this->assertEquals($expected, $microseconds->microseconds());
    }

    /**
     * @return void
     */
    public function testNegativeAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument $amount must be at least 0.');

        new Microsecond(-1);
    }

    /**
     * @return array[]
     */
    public function data(): array
    {
        $data = [];

        for ($i = 0; $i < 3; ++$i) {
            $amount = mt_rand(0, 100);
            $data[] = [$amount, $amount];
        }

        return $data;
    }
}
