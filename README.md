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

```php
use Tamer\Attempt;
use Tamer\Delay\Time;
use Tamer\Interrupt;
use Tamer\Problem;

// Acceptable \Throwable. May take several class-strings.
$sieve = new Problem\Sieve(\Throwable::class);  

// Constant delay between attempts.
$delay = new Problem\Delay(new Interrupt\BySleepFunction(new Time\Second(5), new Interrupt\Usleep()));

// \Throwable handling order.
$sieve->before($delay);

$attempt = new Attempt($sieve);

$naughty = function (int $a, int $b): int {
    // A \Throwable may be thrown here.

    return $a + $b;
};

// Attempt to invoke the $naughty 3 times with 15 and 27.
$result = $attempt($naughty, 3)(15, 27);
```
