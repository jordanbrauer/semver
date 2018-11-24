# semver

Programmatic handling of semver numbers.

## Installation

Install with Composer,

```bash
composer require jordanbrauer/semver
```

## Usage

There are two ways of using this package: as a class, or a function. 

The only difference between these methods is how Semver gets instantiated by the user. So choose the method that best suits your domain needs.

### Class

You know the drill: stick this in your DI/IoC container or call it where you need.

```php
use Semver\Semver;

$semver = new Semver(); # instantiate with the default scheme of 0.1.0
$semver = new Semver('1.0.0'); # instantiate with a specific scheme
```

### Function

If you would like to use a function as the entry point; this is supported by making use of PHP's `use function` feature. Simply prepend "`function`" to the FQCN when importing it.

```php
use function Semver\Semver;

$semver = semver(); # instantiate with the default scheme of 0.1.0
$semver = semver('1.0.0'); # instantiate with a specific scheme
```

## Why

No real reason other than fun! The real solution that you should use to compare semver version schemes, is Composer's [Comparator](https://github.com/composer/semver) library.
