<?php


namespace HardFAQCafe\FurlBundle\Interfaces;


interface UrlValidatorInterface
{
    /**
     * @param string $url
     *
     * @return bool
     */
    public function isUrlValid($url);
}