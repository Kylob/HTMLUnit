# use BootPress\HTMLUnit\Component;

[![Packagist](https://img.shields.io/packagist/v/bootpress/htmlunit.svg?style=flat)](https://packagist.org/packages/bootpress/htmlunit)
[![Downloads](https://img.shields.io/packagist/dt/bootpress/htmlunit.svg?style=flat&maxAge=3600)](https://packagist.org/packages/bootpress/htmlunit)
[![License MIT](https://img.shields.io/badge/License-MIT-blue.svg?style=flat)](LICENSE.md)
[![HHVM Tested](https://img.shields.io/badge/HHVM-Tested-blue.svg?style=flat)](https://travis-ci.org/Kylob/HTMLUnit)
[![PHP 7 Supported](https://img.shields.io/badge/PHP%207-Supported-blue.svg?style=flat)](https://travis-ci.org/Kylob/HTMLUnit)
[![Build Status](https://img.shields.io/travis/Kylob/HTMLUnit/master.svg?style=flat)](https://travis-ci.org/Kylob/HTMLUnit)
[![Code Climate](https://img.shields.io/codeclimate/github/Kylob/HTMLUnit.svg?style=flat)](https://codeclimate.com/github/Kylob/HTMLUnit)
[![Test Coverage](https://img.shields.io/codeclimate/coverage/github/Kylob/HTMLUnit.svg?style=flat)](https://codeclimate.com/github/Kylob/HTMLUnit/coverage)

https://img.shields.io/badge/HHVM-Tested-blue.svg?style=flat-square

Extends PHPUnit and combines the ``assertEquals`` and ``assertRegExp`` assertions into one ``assertEqualsRegExp`` method that enables you to thoroughly test the HTML output of your code.

## Installation

Add the following to your ``composer.json`` file.

``` bash
{
    "require-dev": {
        "bootpress/htmlunit": "^1.0"
    }
}
```

## Example Usage

``` php
<?php

class MyTest extends \BootPress\HTMLUnit\Component
{
    public function testOutput()
    {
        $html = <<<'EOT'
        
	<!doctype html>
<html lang="en-us">
<head><meta charset="UTF-8">

    <title>Title</title></head>
<body>            <p>Content</p>
    </body>     </html>
    
EOT;
        $this->assertEqualsRegExp(array(
            '<!doctype {{ [^>]+ }}>',
            '<html lang="{{ [a-z-]+ }}">',
            '<head>',
                '<meta charset="{{ [A-Z0-9-]+ }}">',
                '<title>Title</title>',
            '</head>',
            '<body>',
                '<p>Content</p>',
            '</body>',
            '</html>',
        ), $html);
    }
}
```

Notice that all of the whitespace surrounding the array values are ignored.  Regular expressions are enclosed Twig style ``{{ ... }}`` with two curly braces and a space on both ends.  Internally the regex is wrapped like so: ``/^...$/``.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
