<?php
namespace App\Controller;

use App\Entity\Links;
use App\Services\LinksService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LinkController extends AbstractController
{

    /**
     * @Route("/create", methods="POST")
     * @param Request $request
     * @param LinksService $service
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Request $request, LinksService $service)
    {
        header('Access-Control-Allow-Origin: *');

        $request = json_decode($request->getContent(), true);

        if (! isset($request['url'])) {
            throw new HttpException(400, "Please provide an url!");
        }

        $code = $service->generateShorterUrl();
        $link_object = new Links();
        $link_object->setUrlFull($request['url']);
        $link_object->setUrlShorter($code);
        $link_object->setViews(0);
        $service->save($link_object);

        return new JsonResponse([
            'url_shorter' => $link_object->getUrlShorter(),
            'full_url' => $link_object->getUrlFull(),
        ]);
    }


    /**
     * @Route("/validate/{url_key}", methods="GET")
     * @param Request $request
     * @param LinksService $service
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function redirectTo(Request $request, LinksService $service)
    {
        header('Access-Control-Allow-Origin: *');

        $shorter_url = $request->get('url_key');
        $url_object = $service->findOneByShorterUrl($shorter_url);

        if (!is_null($url_object)) {
            $service->updateViews($url_object);
            return new JsonResponse(['redirect_to' => $url_object->getUrlFull()]);
        }

        return new JsonResponse(['redirect_to' => null]);
    }

    /**
     * @Route("/analyze/{url_key}", methods="GET")
     * @param Request $request
     * @param LinksService $service
     * @return JsonResponse
     */
    public function analyzeViews(Request $request, LinksService $service)
    {
        header('Access-Control-Allow-Origin: *');

        $shorter_url = $request->get('url_key');
        $url_object = $service->findOneByShorterUrl($shorter_url);

        if (!is_null($url_object)) {
            return new JsonResponse(['total_views' => $url_object->getViews()]);
        }

        return new JsonResponse(['total_views' => null]);
    }
}
