<?php

namespace App\Users\Controller;

use App\Users\Documents\Utilisateur;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class UsersController extends AbstractController
{
    /**
     * @Route(
     *     methods={"GET"}
     *     name="api_get_user_by_username",
     *     path="/utilisateurs/by_username/{id}",
     *     defaults={
     *          "_api_resource_class"=Utilisateur::class,
     *          "_api_item_operation_name"="getByUsername"
     *      }
     * )
     */
    public function getUserByUsername($id, DocumentManager $documentManager)
    {
        $user = $documentManager->getRepository(Utilisateur::class)->findOneBy(['username' => $id]);

        if (empty($user)) {
             throw new NotFoundHttpException('User not found');
        }

        return $user;
    }
}