# Tamer

[![Latest Stable Version](https://poser.pugx.org/xwzvm/tamer/v)](//packagist.org/packages/xwzvm/tamer)
[![Build Status](https://travis-ci.com/xwzvm/tamer.svg?branch=master)](https://travis-ci.com/xwzvm/tamer)
[![Coverage Status](https://coveralls.io/repos/github/xwzvm/tamer/badge.svg?branch=master)](https://coveralls.io/github/xwzvm/tamer?branch=master)
[![License](https://poser.pugx.org/xwzvm/tamer/license)](//packagist.org/packages/xwzvm/tamer)
[![Total Downloads](https://poser.pugx.org/xwzvm/tamer/downloads)](//packagist.org/packages/xwzvm/tamer)

**Tamer** is a flexible PHP library that makes repeated invocation of unstable callable less painful.

## Requirements
* PHP 7.4+
* [Composer](https://getcomposer.org/)

## Installation
```
composer require xwzvm/tamer
```

## Usage
### With fluent interface
```php
use function Tamer\attempt;

$naughty = function (int $a, int $b): int {
    // A \Throwable may be thrown here.

    return $a + $b;
};

$result = attempt($naughty)
    ->until(3)                              // Number of attempts.
    ->retryingOn(\RuntimeException::class)  // Acceptable throwables.
    ->waitingFor(0.25, 2)                   // Waiting between attempts duration in seconds, doubles after each attempt.
    ->with(15, 27);                         // Invokes $naughty with passed arguments.
```

### With some boilerplate
```php
use Tamer\Attempt;
use Tamer\Time;
use Tamer\Interrupt;
use Tamer\Problem;

// Acceptable \Throwable. May take several class-strings.
$filter = new Problem\Filter(\RuntimeException::class);

// Constant wait between attempts.
$wait = new Problem\Wait(new Interrupt\Usleep(), new Time\Second(1));

// \Throwable handling order.
$filter->before($wait);

$attempt = new Attempt($filter);

$naughty = function (int $a, int $b): int {
    // A \Throwable may be thrown here.

    return $a + $b;
};

// Attempt to invoke the $naughty 3 times with 15 and 27.
$result = $attempt($naughty, 3)(15, 27);
```
