<?php

namespace HardFAQCafe\FurlBundle\Interfaces;


interface IntegerEncoderDecoderInterface
{
    /**
     * Кодирует целое число или его строковое представление.
     * Возвращает false в случае некорректных входных данных
     *
     * @param int|string $val
     * @return string|bool
     */
    public function encode($val);

    /**
     * Декодирует строку и возвращает строковое представление целого числа.
     * В случае некорректных входных данных возвращает false
     *
     * @param string $val
     * @return string
     */
    public function decode($val);
}