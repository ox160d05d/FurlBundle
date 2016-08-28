<?php


namespace HardFAQCafe\FurlBundle\Util;


use HardFAQCafe\FurlBundle\Interfaces\IntegerEncoderDecoderInterface;

class GmpBase62Coder implements IntegerEncoderDecoderInterface
{
    public function __construct()
    {
        if (!function_exists('gmp_init')) {
            throw new \Exception('GMP library required!');
        }
    }

    public function encode($val)
    {
        $val = gmp_init(strval($val), 10);

        return gmp_strval($val, 62);
    }

    public function decode($val)
    {
        $val = gmp_init($val, 62);

        return gmp_strval($val, 10);
    }
}