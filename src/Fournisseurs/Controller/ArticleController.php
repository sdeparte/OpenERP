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
     *     methods={"POST"},
     *     name="api_add_version",
     *     path="/articles/{id}/add_version"
     * )
     */
    public function addVersion(int $id, DocumentManager $documentManager, ValidatorInterface $validator, Request $request): Response
    {
        /** @var Article $article */
        $article = $documentManager->getRepository(Article::class)->find($id);

        if (empty($article)) {
            throw new NotFoundHttpException('Article not found');
        }

        $requestContent = json_decode($request->getContent(), true);

        $article->addVersionIri($requestContent['versionIri']);

        $validator->validate($article);

        $documentManager->persist($article);
        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route(
     *     methods={"POST"},
     *     name="api_remove_version",
     *     path="/articles/remove_version"
     * )
     */
    public function removeVersion(DocumentManager $documentManager, ValidatorInterface $validator, Request $request): Response
    {
        $requestContent = json_decode($request->getContent(), true);

        $articles = $documentManager->getRepository(Article::class)->findByVersionIri($requestContent['versionIri']);

        /** @var Article $article */
        foreach ($articles as $article) {
            $article->removeVersionIri($requestContent['versionIri']);

            $validator->validate($article);

            $documentManager->persist($article);
        }

        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}