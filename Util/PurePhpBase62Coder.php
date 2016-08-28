<?php


namespace HardFAQCafe\FurlBundle\Util;


use HardFAQCafe\FurlBundle\Interfaces\IntegerEncoderDecoderInterface;

class PurePhpBase62Coder implements  IntegerEncoderDecoderInterface
{
    public static $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

    public function encode($data)
    {
        $converted = self::baseConvert([strval($data)], 10, 62);

        return implode('', array_map(function ($index) {
            return self::$characters[$index];
        }, $converted));
    }

    public function decode($data)
    {
        $data = str_split(strval($data));
        $data = array_map(function ($character) {
            return strpos(self::$characters, $character);
        }, $data);

        $converted = self::baseConvert($data, 62, 10);

        return strval(implode("", $converted));

    }

    /* http://codegolf.stackexchange.com/a/21672 */
    private function baseConvert(array $source, $sourceBase, $targetBase)
    {
        $result = [];

        while ($count = count($source)) {
            $quotient = [];
            $remainder = 0;

            for ($i = 0; $i !== $count; $i++) {
                $accumulator = $source[$i] + $remainder * $sourceBase;
                $digit = (integer) ($accumulator / $targetBase);
                $remainder = $accumulator % $targetBase;

                if (count($quotient) || $digit) {
                    array_push($quotient, $digit);
                };
            }

            array_unshift($result, $remainder);
            $source = $quotient;
        }

        return $result;
    }
}