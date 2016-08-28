<?php


namespace HardFAQCafe\FurlBundle\Util;


use HardFAQCafe\FurlBundle\Entity\FurlLink;
use HardFAQCafe\FurlBundle\Interfaces\IntegerEncoderDecoderInterface;
use HardFAQCafe\FurlBundle\Interfaces\UrlValidatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class StorageManager
{
    private $doctrine;
    private $coder;
    private $urlValidator;

    public function __construct(RegistryInterface $doctrine, IntegerEncoderDecoderInterface $coder)
    {
        $this->doctrine = $doctrine;
        $this->coder = $coder;
    }

    public function setUrlValidator(UrlValidatorInterface $urlValidator)
    {
        $this->urlValidator = $urlValidator;
    }

    /**
     * @param string $originalUrl
     *
     * @return false|string короткий код исходной ссылки или false в случае ошибкии
     */
    public function addLink($originalUrl)
    {
        if ($this->urlValidator instanceof UrlValidatorInterface) {
            if (!$this->urlValidator->isUrlValid($originalUrl)) {
                return false;
            }
        }

        $entityManager = $this->doctrine->getEntityManager();

        $newUrl = new FurlLink();
        $newUrl->setOriginalUrl($originalUrl);
        $entityManager->persist($newUrl);
        $entityManager->flush($newUrl);

        return $this->coder->encode($newUrl->getId());
    }

    /**
     * @param string $urlCode
     *
     * @return false|string
     */
    public function getLinkByCode($urlCode)
    {
        $urlId = $this->coder->decode($urlCode);

        if (!$urlId) {
            return false;
        }

        $furlLink = $this->doctrine->getEntityManager()->getRepository(FurlLink::class)->find($urlId);

        if (!$furlLink instanceof FurlLink) {
            return false;
        }

        return $furlLink->getOriginalUrl();
    }


}