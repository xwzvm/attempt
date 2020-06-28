# Attempt

[![Latest Stable Version](https://poser.pugx.org/xwzvm/attempt/v)](//packagist.org/packages/xwzvm/attempt)
[![Build Status](https://travis-ci.com/xwzvm/attempt.svg?branch=master)](https://travis-ci.com/xwzvm/attempt)
[![Coverage Status](https://coveralls.io/repos/github/xwzvm/attempt/badge.svg?branch=master)](https://coveralls.io/github/xwzvm/attempt?branch=master)
[![License](https://poser.pugx.org/xwzvm/attempt/license)](//packagist.org/packages/xwzvm/attempt)
[![Total Downloads](https://poser.pugx.org/xwzvm/attempt/downloads)](//packagist.org/packages/xwzvm/attempt)

**Attempt** is a flexible PHP library that makes repeated invocation of unstable callable less painful.

## Requirements
* PHP 7.4+
* [Composer](https://getcomposer.org/)

## Installation

```
composer require xwzvm/attempt
```

## Usage

```php
use Xwzvm\Attempt\Attempt;
use Xwzvm\Attempt\Delay\Time;
use Xwzvm\Attempt\Interrupt;
use Xwzvm\Attempt\Problem;

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
