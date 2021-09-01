<?php

namespace App\Fournisseurs\Controller;

use App\Fournisseurs\Documents\Article;
use App\Fournisseurs\Repositories\ArticleRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route(
     *     methods={"PATCH"},
     *     name="api_add_tarif",
     *     path="/articles/{id}/add_tarif"
     * )
     */
    public function addTarif(int $id, DocumentManager $documentManager, ValidatorInterface $validator, Request $request)
    {
        $article = $documentManager->getRepository(Article::class)->find($id);

        if (empty($article)) {
            throw new NotFoundHttpException('Article not found');
        }

        $requestContent = json_decode($request->getContent(), true);

        /** @var Article $article */
        $article->addTarifIri($requestContent['tarifIri']);

        $validator->validate($article);

        $documentManager->persist($article);
        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route(
     *     methods={"POST"},
     *     name="api_remove_tarif",
     *     path="/articles/remove_tarif"
     * )
     */
    public function removeTarif(DocumentManager $documentManager, ValidatorInterface $validator, Request $request): Response
    {
        $requestContent = json_decode($request->getContent(), true);

        /** @var ArticleRepository $articles */
        $articles = $documentManager->getRepository(Article::class)->findByTarifIri($requestContent['tarifIri']);

        foreach ($articles as $article) {
            $article->removeTarifIri($requestContent['tarifIri']);

            $validator->validate($article);

            $documentManager->persist($article);
        }

        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route(
     *     methods={"POST"},
     *     name="api_add_plan",
     *     path="/articles/{id}/add_plan"
     * )
     */
    public function addPlan(int $id, DocumentManager $documentManager, ValidatorInterface $validator, Request $request): Response
    {
        $article = $documentManager->getRepository(Article::class)->find($id);

        if (empty($article)) {
            throw new NotFoundHttpException('Article not found');
        }

        $requestContent = json_decode($request->getContent(), true);

        /** @var Article $article */
        $article->addPlanIri($requestContent['planIri']);

        $validator->validate($article);

        $documentManager->persist($article);
        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route(
     *     methods={"POST"},
     *     name="api_remove_plan",
     *     path="/articles/remove_plan"
     * )
     */
    public function removePlan(DocumentManager $documentManager, ValidatorInterface $validator, Request $request): Response
    {
        $requestContent = json_decode($request->getContent(), true);

        /** @var ArticleRepository $articles */
        $articles = $documentManager->getRepository(Article::class)->findByPlanIri($requestContent['planIri']);

        foreach ($articles as $article) {
            $article->removePlanIri($requestContent['planIri']);

            $validator->validate($article);

            $documentManager->persist($article);
        }

        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}