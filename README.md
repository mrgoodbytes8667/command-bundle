# command-bundle
[![Packagist Version](https://img.shields.io/packagist/v/mrgoodbytes8667/command-bundle?logo=packagist&logoColor=FFF&style=flat)](https://packagist.org/packages/mrgoodbytes8667/command-bundle)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/mrgoodbytes8667/command-bundle?logo=php&logoColor=FFF&style=flat)](https://packagist.org/packages/mrgoodbytes8667/command-bundle)
![Symfony Versions Supported](https://img.shields.io/endpoint?url=https%3A%2F%2Fshields.mrgoodbytes.dev%2Fshield%2Fsymfony%2F%255E6.1%2520%257C%257C%2520%255E7.0&logoColor=FFF&style=flat)
![Symfony Versions Tested](https://img.shields.io/endpoint?url=https%3A%2F%2Fshields.mrgoodbytes.dev%2Fshield%2Fsymfony-test%2F%253E%253D6.1%2520%253C7.1&logoColor=FFF&style=flat)
![Symfony LTS Version](https://img.shields.io/endpoint?url=https%3A%2F%2Fshields.mrgoodbytes.dev%2Fshield%2Flts%2F%255E6.1&logoColor=FFF&style=flat)
![Symfony Stable Version](https://img.shields.io/endpoint?url=https%3A%2F%2Fshields.mrgoodbytes.dev%2Fshield%2Fstable%2F%255E6.1&logoColor=FFF&style=flat)
![Symfony Dev Version](https://img.shields.io/endpoint?url=https%3A%2F%2Fshields.mrgoodbytes.dev%2Fshield%2Fdev%2F%255E6.1&logoColor=FFF&style=flat)
![Packagist License](https://img.shields.io/packagist/l/mrgoodbytes8667/command-bundle?logo=creative-commons&logoColor=FFF&style=flat)  
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/mrgoodbytes8667/command-bundle/release.yml?label=stable&logo=github&logoColor=FFF&style=flat)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/mrgoodbytes8667/command-bundle/run-tests.yml?logo=github&logoColor=FFF&style=flat)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/mrgoodbytes8667/command-bundle/run-tests-by-version.yml?logo=github&logoColor=FFF&style=flat)
[![codecov](https://img.shields.io/codecov/c/github/mrgoodbytes8667/command-bundle/2.0?logo=codecov&logoColor=FFF&style=flat)](https://codecov.io/gh/mrgoodbytes8667/command-bundle)  
A _slightly_ better version of Symfony's base command class

## Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require mrgoodbytes8667/command-bundle
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require mrgoodbytes8667/command-bundle
```

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Bytes\CommandBundle\BytesCommandBundle::class => ['all' => true],
];
```

## License
[![License](https://i.creativecommons.org/l/by-nc/4.0/88x31.png)]("http://creativecommons.org/licenses/by-nc/4.0/)  
command-bundle by [MrGoodBytes](https://mrgoodbytes.dev) is licensed under a [Creative Commons Attribution-NonCommercial 4.0 International License](http://creativecommons.org/licenses/by-nc/4.0/).  
Based on a work at [https://github.com/mrgoodbytes8667/command-bundle](https://github.com/mrgoodbytes8667/command-bundle).
