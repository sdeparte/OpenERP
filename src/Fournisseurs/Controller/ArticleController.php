<?php

namespace App\Fournisseurs\Controller;

use App\Fournisseurs\Documents\Article;
use App\Fournisseurs\Documents\Version;
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
        $requestContent = json_decode($request->getContent(), true);

        /** @var Article $article */
        $article = $documentManager->getRepository(Article::class)->find($id);

        if (empty($article)) {
            throw new NotFoundHttpException("Article #$id not found");
        }

        /** @var Version $version */
        $version = $documentManager->getRepository(Version::class)->find($requestContent['versionId']);

        if (empty($version)) {
            throw new NotFoundHttpException('Version #'.$requestContent['versionId'].' not found');
        }

        $article->addVersionIri($version);

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

        /** @var Version $version */
        $version = $documentManager->getRepository(Version::class)->find($requestContent['versionId']);

        if (empty($version)) {
            throw new NotFoundHttpException('Version #'.$requestContent['versionId'].' not found');
        }

        $articles = $documentManager->getRepository(Article::class)->findByVersionIri($requestContent['versionId']);

        /** @var Article $article */
        foreach ($articles as $article) {
            $article->removeVersionIri($version);

            $validator->validate($article);

            $documentManager->persist($article);
        }

        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}