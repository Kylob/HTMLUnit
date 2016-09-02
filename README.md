# use BootPress\HTMLUnit\Component as HTMLUnit;

[![Packagist][badge-version]][link-packagist]
[![License MIT][badge-license]](LICENSE.md)
[![HHVM Tested][badge-hhvm]][link-travis]
[![PHP 7 Supported][badge-php]][link-travis]
[![Build Status][badge-travis]][link-travis]
[![Code Climate][badge-code-climate]][link-code-climate]
[![Test Coverage][badge-coverage]][link-coverage]

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

[badge-version]: https://img.shields.io/packagist/v/bootpress/htmlunit.svg?style=flat-square&label=Packagist
[badge-license]: https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square
[badge-hhvm]: https://img.shields.io/badge/HHVM-Tested-8892bf.svg?style=flat-square
[badge-php]: https://img.shields.io/badge/PHP%207-Supported-8892bf.svg?style=flat-square
[badge-travis]: https://img.shields.io/travis/Kylob/HTMLUnit/master.svg?style=flat-square
[badge-code-climate]: https://img.shields.io/codeclimate/github/Kylob/HTMLUnit.svg?style=flat-square
[badge-coverage]: https://img.shields.io/codeclimate/coverage/github/Kylob/HTMLUnit.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/bootpress/htmlunit
[link-travis]: https://travis-ci.org/Kylob/HTMLUnit
[link-code-climate]: https://codeclimate.com/github/Kylob/HTMLUnit
[link-coverage]: https://codeclimate.com/github/Kylob/HTMLUnit/coverage
