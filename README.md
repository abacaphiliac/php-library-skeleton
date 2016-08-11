[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/abacaphiliac/php-library-skeleton/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/abacaphiliac/php-library-skeleton/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/abacaphiliac/php-library-skeleton/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/abacaphiliac/php-library-skeleton/?branch=master)
[![Build Status](https://travis-ci.org/abacaphiliac/php-library-skeleton.svg?branch=master)](https://travis-ci.org/abacaphiliac/php-library-skeleton)

# abacaphiliac/php-library-skeleton

## Description
An opinionated PHP library skeleton, with:
* PHP-syntax and CodeSniffer-PSR2 linters
* PHPUnit
* Travis CI
* Scrutinizer

## Installation
```bash
composer create-project abacaphiliac/php-library-skeleton your-new-php-lib
```

## TODO
[ ] - update README description
[ ] - remove README usage
[ ] - clean up README todo
[ ] - add humbug

## Dependencies
See [composer.json](composer.json).

## Contributing
```
composer update && vendor/bin/phing
```

This library attempts to comply with [PSR-1][], [PSR-2][], and [PSR-4][]. If
you notice compliance oversights, please send a patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
