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

$delay = new Time\Second(5);                    // Delay between attempts.
$interrupt = new Interrupt\Usleep($delay);      // Interrupt implementation.
$sieve = new Problem\Sieve(\Throwable::class);  // Represents acceptable \Throwable. May take several class-strings.

$attempt = new Attempt($interrupt, $sieve);

$naughty = function (int $a, int $b): int {
    // A \Throwable may be thrown here.

    return $a + $b;
};

// Attempt to invoke the $naughty 3 times with 15 and 27.
$result = $attempt($naughty, 3)(15, 27);
```
