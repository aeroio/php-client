PHP Client for Aero.cx
====================================

The testing frameworks used are PHPUnit and Behat.

Installing PHPUnit
------------------------------------

Trying to install PHPUnit with the commands in the PHPUnit manual will possibly lead you to errors.
So you should definitely check this awesome article on installing PHPUnit, it really saved me:

(http://kubyshkin.ru/programming/phpunit-on-mac-os-x-snow-leopard-10-6/)

Installing Behat
------------------------------------

As the Behat documentation suggests in order to install Behat you first need to create composer.json containing:

```json
{
    "require": {
        "behat/behat": "2.4@stable"
    },

    "config": {
        "bin-dir": "bin/"
    }
}
```

Then in the command line enter the following:

```
curl http://getcomposer.org/installer | php
php composer.phar install
```

Running Test Cases
------------------------------------

## PHPUnit

If you want to run the unit(PHPUnit) tests you should put the path to the directory the files are in:

```
phpunit test/spec
```

## Behat

If you want to run the integration(Behat) tests just enter the following in the command line:

```
bin/behat
```

There are tags describing the different functionality for instance - `@http`, `@curl`, `@projects`, `@authorize`, etc.
If you want to only run the test cases linked to certain functionality, you can do this with:

```
bin/behat --tags="@tag_name"

bin/behat --tags="@tag1, @tag2"
```
