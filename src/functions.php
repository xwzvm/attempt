<?php declare(strict_types=1);

namespace Tamer;

if (!function_exists('attempt')) {
    function attempt(callable $action): Tamer
    {
        return (new Tamer())($action);
    }
}
