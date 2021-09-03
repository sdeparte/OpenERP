<?php

namespace App\Fournisseurs\Controller;

use App\Fournisseurs\Documents\Version;
use App\Fournisseurs\Repositories\VersionRepository;
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
class VersionController extends AbstractController
{
    /**
     * @Route(
     *     methods={"POST"},
     *     name="api_add_reference_fournisseur",
     *     path="/versions/{id}/add_reference_fournisseur"
     * )
     */
    public function addReferenceFournisseur(int $id, DocumentManager $documentManager, ValidatorInterface $validator, Request $request): Response
    {
        /** @var Version $version */
        $version = $documentManager->getRepository(Version::class)->find($id);

        if (empty($version)) {
            throw new NotFoundHttpException('Version not found');
        }

        $requestContent = json_decode($request->getContent(), true);

        $version->addReferenceFournisseurIri($requestContent['referenceFournisseurIri']);

        $validator->validate($version);

        $documentManager->persist($version);
        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route(
     *     methods={"POST"},
     *     name="api_remove_reference_fournisseur",
     *     path="/versions/remove_reference_fournisseur"
     * )
     */
    public function removeReferenceFournisseur(DocumentManager $documentManager, ValidatorInterface $validator, Request $request): Response
    {
        $requestContent = json_decode($request->getContent(), true);

        $versions = $documentManager->getRepository(Version::class)->findByReferenceFournisseurIri($requestContent['referenceFournisseurIri']);

        /** @var Version $version */
        foreach ($versions as $version) {
            $version->removeReferenceFournisseurIri($requestContent['referenceFournisseurIri']);

            $validator->validate($version);

            $documentManager->persist($version);
        }

        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route(
     *     methods={"POST"},
     *     name="api_add_parametre",
     *     path="/versions/{id}/add_parametre"
     * )
     */
    public function addParametre(int $id, DocumentManager $documentManager, ValidatorInterface $validator, Request $request): Response
    {
        /** @var Version $version */
        $version = $documentManager->getRepository(Version::class)->find($id);

        if (empty($version)) {
            throw new NotFoundHttpException('Version not found');
        }

        $requestContent = json_decode($request->getContent(), true);

        $version->addParametreIri($requestContent['parametreIri']);

        $validator->validate($version);

        $documentManager->persist($version);
        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route(
     *     methods={"POST"},
     *     name="api_remove_parametre",
     *     path="/versions/remove_parametre"
     * )
     */
    public function removeParametre(DocumentManager $documentManager, ValidatorInterface $validator, Request $request): Response
    {
        $requestContent = json_decode($request->getContent(), true);

        $versions = $documentManager->getRepository(Version::class)->findByParametreIri($requestContent['parametreIri']);

        /** @var Version $version */
        foreach ($versions as $version) {
            $version->removeParametreIri($requestContent['parametreIri']);

            $validator->validate($version);

            $documentManager->persist($version);
        }

        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}