<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Test\Delay\Time;

use PHPUnit\Framework\TestCase;
use Xwzvm\Attempt\Delay\Time\Second;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class SecondTest extends TestCase
{
    private const MICROSECONDS_PER_SECOND = 1_000_000;

    /**
     * @param int $amount
     * @param int $expected
     * @dataProvider data
     */
    public function testMicroseconds(int $amount, int $expected): void
    {
        $seconds = new Second($amount);

        $this->assertEquals($expected, $seconds->microseconds());
    }

    /**
     * @return void
     */
    public function testNegativeAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument $amount must be at least 0.');

        new Second(-1);
    }

    /**
     * @return array[]
     */
    public function data(): array
    {
        $data = [];

        for ($i = 0; $i < 3; ++$i) {
            $amount = mt_rand(0, 100);
            $data[] = [$amount, $amount * self::MICROSECONDS_PER_SECOND];
        }

        return $data;
    }
}
