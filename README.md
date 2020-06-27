# Attempt

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
$delay = new Problem\Delay(new Interrupt\Usleep(new Time\Second(5)));

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
