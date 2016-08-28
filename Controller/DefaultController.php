<?php

namespace HardFAQCafe\FurlBundle\Controller;

use HardFAQCafe\FurlBundle\Util\StorageManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        /** @var StorageManager $furlStorageManager */
        $furlStorageManager = $this->container->get('hard_faq_cafe_furl.storage_manager');

        return $this->render('HardFAQCafeFurlBundle:Default:index.html.twig', [
            'addUrlRoute' => $this->generateUrl('hard_faq_cafe_furl_add_new_url'),
        ]);
    }

    public function getShortUrlAction(Request $request)
    {
        $originalUrl = $request->query->get('originalUrl');

        if (empty($originalUrl)) {
            return new JsonResponse(['success' => false, 'shortUrl' => null]);
        }

        $furlStorageManager = $this->container->get('hard_faq_cafe_furl.storage_manager');
        $result = $furlStorageManager->addLink(urldecode($originalUrl));

        if ($result) {
            $result = [
                'success' => true,
                'shortUrl' => $this->generateUrl(
                    'hard_faq_cafe_furl_get_url', ['urlCode' => $result], UrlGeneratorInterface::ABSOLUTE_URL
                )
            ];
        } else {
            $result = ['success' => false, 'shortUrl' => null];
        }

        return new JsonResponse($result);
    }

    public function redirectByCodeAction($urlCode)
    {
        $furlStorageManager = $this->container->get('hard_faq_cafe_furl.storage_manager');
        $originalUrl = $furlStorageManager->getLinkByCode($urlCode);

        if (!$originalUrl) {
            throw new NotFoundHttpException();
        }

        if (!preg_match('/^https?:\//', $originalUrl)) {
            $originalUrl = 'http://' . $originalUrl;
        }

        return new RedirectResponse($originalUrl);
    }

}
