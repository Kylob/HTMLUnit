<?php

namespace BootPress\Tests;

class HTMLUnitTest extends \BootPress\HTMLUnit\Component
{
    public function testAssertEqualsRegExp()
    {
        $this->assertEqualsRegExp('string', "\nstr\ting ");
        $this->assertEqualsRegExp('id="unique{{ [A-Z]+ }}"', 'id="uniqueXIV"');
    }
    
    public function testEmptyAssertions()
    {
        $this->assertEqualsRegExp(array(), '');
    }

    public function testEqualsException()
    {
        $this->setExpectedException('\PHPUnit_Framework_AssertionFailedError');
        $this->assertEqualsRegExp('string', "\nstr\tng ");
    }

    public function testRegExpException()
    {
        $this->setExpectedException('\PHPUnit_Framework_AssertionFailedError');
        $this->assertEqualsRegExp('id="unique{{ [A-Z]+ }}"', 'id="unique123"');
    }
    
    public function testTrailingStringFails()
    {
        $this->setExpectedException('\PHPUnit_Framework_AssertionFailedError');
        $this->assertEqualsRegExp(array('Trailing'), 'Trailing ...');
    }
    
    public function testLiteralRegExpPattern()
    {
        $this->assertEqualsRegExp(array(
            'Literal',
            '{{ RegExp }}',
            'Pattern',
        ), 'LiteralRegExpPattern');
        
        $this->assertEqualsRegExp(array(
            'Literal',
            '{{ RegExp }}',
            'Pattern',
        ), 'Literal{{ RegExp }}Pattern');
    }
    
    public function testRealCaseScenario()
    {
        $content = <<<'EOT'
        
	<!doctype html>
<html lang="en-us">
<head><meta charset="UTF-8">

    <title>Title</title></head>
<body>            <p>Content</p>
    </body>     </html>
    
EOT;
        $this->setExpectedException('\PHPUnit_Framework_AssertionFailedError');
        $this->assertEqualsRegExp(array(
            '<!doctype {{ [^>]+ }}>',
            '<html lang="{{ [a-z-]+ }}">',
            '<head>',
                '<meta charset="{{ [A-Z-]+ }}">',
                '<title>Title</title>',
            '</head>',
            '<body>',
                '<p>Content</p>',
            '</body>',
            '</html>',
        ), $content);
    }
}
