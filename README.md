[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/abacaphiliac/php-library-skeleton/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/abacaphiliac/php-library-skeleton/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/abacaphiliac/php-library-skeleton/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/abacaphiliac/php-library-skeleton/?branch=master)
[![Build Status](https://travis-ci.org/abacaphiliac/php-library-skeleton.svg?branch=master)](https://travis-ci.org/abacaphiliac/php-library-skeleton)

# abacaphiliac/php-library-skeleton

## Description
An opinionated PHP library skeleton, with PHP-syntax and CodeSniffer-PSR2 linters, PHPUnit, and Travis CI.

## Installation
I suggest using Composer's (create-project)[https://getcomposer.org/doc/03-cli.md#create-project] command:
```bash
composer create-project abacaphiliac/php-library-skeleton your-new-php-lib
```

## Usage
Replace content, e.g. package and author name, in this package:
```
find ./ -type f -exec sed -i -e 's%abacaphiliac/php-library-skeleton%your-new-php-lib%g' {} \;
find ./ -type f -exec sed -i -e 's/Timothy Younger/Your Name/g' {} \;
find ./ -type f -exec sed -i -e 's/abacaphiliac@gmail.com/your-email@example.com/g' {} \;
```

Change the package description in (composer.json)[composer.json] and (README.md)[README.md].

## TODO
[x] - Add Composer `post-create-project-cmd` script(s)/wizard:
 [x] - Get new package name and perform a find-and-replace.
 [x] - Get min PHP version and update Travis config.
 [x] - Update Composer
  [x] - Update Composer package-name?
  [x] - Update Composer description?
  [x] - Update Composer author?
  [x] - Update Composer minimum-stability?
  [x] - Update Composer package-type?
  [x] - Update Composer license?
  [x] - Update Composer *additional* [dev] dependencies?
 [x] - Update Composer keywords?
 [x] - Update package license.
 [x] - Get root namespace and replace `src` and `tests` folder structure.
  [x] - Update Composer autoload(s)?
 [x] - add phpunit speedtrap
 [ ] - update README description
 [ ] - remove README usage
 [ ] - clean up README todo
 [ ] - update (LICENSE)[LICENSE]
 [ ] - update (composer)[composer.json] license
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
