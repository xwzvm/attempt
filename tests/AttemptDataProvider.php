<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Test;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
trait AttemptDataProvider
{
    /**
     * @return array[]
     */
    public function actions(): array
    {
        $actions = [];

        for ($i = 0; $i < 3; ++$i) {
            $bound = mt_rand(2, 1000);
            $argument = mt_rand(0, 100);

            $square = function (int $x) use ($bound): int {
                static $count = 0;

                if ($count++ < $bound) {
                    throw new \RuntimeException();
                }

                return $x * $x;
            };

            $actions[] = [$square, $bound, [$argument], $argument * $argument, \RuntimeException::class];
        }

        return $actions;
    }

    /**
     * @return array[]
     */
    public function problems(): array
    {
        $problems = [];

        for ($i = 0; $i < 3; ++$i) {
            $times = mt_rand(1, 10);

            $square = function (): void {
                static $count = 0;

                if ($count++ % 2 === 0) {
                    throw new \RuntimeException();
                }

                throw new \LogicException();
            };

            $problems[] = [$square, $times, $times % 2 === 0 ? \LogicException::class : \RuntimeException::class];
        }

        return $problems;
    }
}
