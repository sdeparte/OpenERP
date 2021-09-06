<?php

namespace App\Fournisseurs\Controller;

use App\Fournisseurs\Documents\Parametre;
use App\Fournisseurs\Documents\ReferenceFournisseur;
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
        $requestContent = json_decode($request->getContent(), true);

        /** @var Version $version */
        $version = $documentManager->getRepository(Version::class)->find($id);

        if (empty($version)) {
            throw new NotFoundHttpException("Version #$id not found");
        }

        /** @var ReferenceFournisseur $referenceFournisseur */
        $referenceFournisseur = $documentManager->getRepository(ReferenceFournisseur::class)->find($requestContent['referenceFournisseurId']);

        if (empty($referenceFournisseur)) {
            throw new NotFoundHttpException('Reference Fournisseur #'.$requestContent['referenceFournisseurId'].' not found');
        }

        $version->addReferenceFournisseurIri($referenceFournisseur);

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

        /** @var ReferenceFournisseur $referenceFournisseur */
        $referenceFournisseur = $documentManager->getRepository(ReferenceFournisseur::class)->find($requestContent['parametreId']);

        if (empty($referenceFournisseur)) {
            throw new NotFoundHttpException('Reference Fournisseur #'.$requestContent['referenceFournisseurId'].' not found');
        }

        $versions = $documentManager->getRepository(Version::class)->findByReferenceFournisseurIri($requestContent['referenceFournisseurId']);

        /** @var Version $version */
        foreach ($versions as $version) {
            $version->removeReferenceFournisseurIri($referenceFournisseur);

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
        dump($request->getContent());
        $requestContent = json_decode($request->getContent(), true);

        /** @var Version $version */
        $version = $documentManager->getRepository(Version::class)->find($id);

        if (empty($version)) {
            throw new NotFoundHttpException("Version #$id not found");
        }

        /** @var Parametre $parametre */
        $parametre = $documentManager->getRepository($requestContent['parametreClass'])->find($requestContent['parametreId']);

        if (empty($parametre)) {
            throw new NotFoundHttpException('Parametre #'.$requestContent['parametreId'].' not found');
        }

        $version->addParametreIri($parametre);

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

        /** @var Parametre $parametre */
        $parametre = $documentManager->getRepository($requestContent['parametreClass'])->find($requestContent['parametreId']);

        if (empty($parametre)) {
            throw new NotFoundHttpException('Parametre #'.$requestContent['parametreId'].' not found');
        }

        $versions = $documentManager->getRepository(Version::class)->findByParametreIri($requestContent['parametreId']);

        /** @var Version $version */
        foreach ($versions as $version) {
            $version->removeParametreIri($parametre);

            $validator->validate($version);

            $documentManager->persist($version);
        }

        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}