<?php

namespace BootPress\HTMLUnit;

abstract class Component extends \PHPUnit_Framework_TestCase
{
    /**
     * Combines the assertEquals and assertRegExp assertions into one assertEqualsRegExp method so that you can thoroughly test the HTML or XML output of your code.
     * 
     * @param string|array $compare
     * @param string       $string
     */
    public static function assertEqualsRegExp($compare, $string)
    {
        if (is_array($compare)) {
            $compare = implode('{{ \s* }}', $compare);
            $compare = str_replace(array('{{ \s* }}{{ ', ' }}{{ \s* }}'), array('{{ ', ' }}'), $compare);
        }
        if (empty($compare)) {
            return self::assertEquals($compare, $string);
        }
        $string = trim(str_replace(array("\r", "\n", "\t"), '', $string));
        $error = $string;
        preg_match_all('/{{\s[^\}]*\s}}/', $compare, $regexp);
        $equals = preg_split('/{{\s[^\}]*\s}}/', $compare);
        foreach ($equals as $key => $value) {
            if (!empty($value)) {
                try {
                    self::assertEquals($value, substr($string, 0, strlen($value)));
                } catch (\Exception $e) {
                    self::fail(implode("\n", array(
                        $e->getMessage(),
                        '--- Expected',
                        '+++ Actual',
                        '@@ @@',
                        self::merge(array_slice($equals, 0, $key, true), $regexp[0]),
                        '',
                        "-'".$value."'",
                        "+'".$string."'",
                    )));
                }
                $string = substr($string, strlen($value));
            }
            $next = (isset($equals[$key + 1])) ? $equals[$key + 1] : '';
            $length = (!empty($next)) ? strpos($string, $next) : 0;
            if (isset($regexp[0][$key]) && $length !== false) {
                $pattern = substr($regexp[0][$key], 3, -3);
                try {
                    self::assertRegExp('/^'.$pattern.'$/', substr($string, 0, $length));
                } catch (\Exception $e) {
                    if ('{{ '.$pattern.' }}' == substr($string, 0, $length)) {
                        // a literal (string) match
                    } else {
                        self::fail(implode("\n", array(
                            self::merge(array_slice($equals, 0, $key, true), $regexp[0]),
                            '',
                            $e->getMessage(),
                            $value.$regexp[0][$key].$next,
                            '',
                            self::merge(array_slice($equals, $key + 2, null, true), $regexp[0]),
                        )));
                    }
                }
                $string = substr($string, $length);
            }
        }
        if (!empty($string)) {
            return self::assertEquals(strstr($error, $string, true), $error);
        }
    }

    private static function merge(array $one, array $two)
    {
        $string = '';
        foreach ($one as $key => $value) {
            $string .= $value;
            if (isset($two[$key])) {
                $string .= $two[$key];
            }
        }

        return trim(implode("\n", explode('{{ \s* }}', $string)));
    }
}
