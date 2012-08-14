PHP Client for Aero.cx
====================================

The testing frameworks used are PHPUnit and Behat.

Installing PHPUnit
------------------------------------

Trying to install PHPUnit with the commands in the PHPUnit manual will possibly lead you to errors.
So you should definitely check this awesome article on installing PHPUnit, it really saved me:

```
[http://kubyshkin.ru/programming/phpunit-on-mac-os-x-snow-leopard-10-6/]
```

Installing Behat
------------------------------------

As the Behat documentation suggests in order to install Behat you first need to create composer.json containing:

```
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
