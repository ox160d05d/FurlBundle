<?php

namespace HardFAQCafe\FurlBundle\Util;


use HardFAQCafe\FurlBundle\Interfaces\UrlValidatorInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UrlValidator implements UrlValidatorInterface
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function isUrlValid($url)
    {
        $errors = $this->validator->validate($url, [new Url()]);

        return !boolval($errors->count());
    }
}