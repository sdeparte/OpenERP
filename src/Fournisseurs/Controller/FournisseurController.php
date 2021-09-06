<?php

namespace App\Fournisseurs\Controller;

use App\Common\Documents\Contact;
use App\Fournisseurs\Documents\Fournisseur;
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
class FournisseurController extends AbstractController
{
    /**
     * @Route(
     *     methods={"POST"},
     *     name="api_fournisseur_add_contact",
     *     path="/fournisseurs/{id}/add_contact"
     * )
     */
    public function addContact(int $id, DocumentManager $documentManager, ValidatorInterface $validator, Request $request): Response
    {
        $requestContent = json_decode($request->getContent(), true);

        /** @var Fournisseur $fournisseur */
        $fournisseur = $documentManager->getRepository(Fournisseur::class)->find($id);

        if (empty($fournisseur)) {
            throw new NotFoundHttpException("Fournisseur #$id not found");
        }

        $fournisseur->addContactIri($requestContent['contactIri']);

        $validator->validate($fournisseur);

        $documentManager->persist($fournisseur);
        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route(
     *     methods={"POST"},
     *     name="api_fournisseur_remove_contact",
     *     path="/articles/remove_version"
     * )
     */
    public function removeVersion(DocumentManager $documentManager, ValidatorInterface $validator, Request $request): Response
    {
        $requestContent = json_decode($request->getContent(), true);

        $fournisseurs = $documentManager->getRepository(Fournisseur::class)->findByContactIri($requestContent['contactId']);

        /** @var Fournisseur $fournisseur */
        foreach ($fournisseurs as $fournisseur) {
            $fournisseur->removeContactIri($requestContent['contactIri']);

            $validator->validate($fournisseur);

            $documentManager->persist($fournisseur);
        }

        $documentManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}