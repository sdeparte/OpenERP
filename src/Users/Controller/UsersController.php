<?php

namespace App\Users\Controller;

use App\Users\Documents\Utilisateur;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class UsersController
{
    /**
     * @var DocumentManager
     */
    private $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * @Route(
     *     name="api_test",
     *     path="/utilisateurs/by_username/{id}",
     *     defaults={
     *          "_api_resource_class"=Utilisateur::class,
     *          "_api_item_operation_name"="getByUsername"
     *      }
     * )
     */
    public function __invoke($id)
    {
        $user = $this->documentManager->getRepository(Utilisateur::class)->findOneBy(['username' => $id]);

        if (empty($user)) {
             throw new NotFoundHttpException('User not found');
        }

        return $user;
    }
}