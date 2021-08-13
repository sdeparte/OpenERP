<?php
namespace App\Users\DataPersister;

use App\Users\Documents\Utilisateur;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 *
 */
class UtilisateurDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var DocumentManager
     */
    private $docuementManager;

    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct(
        DocumentManager $docuementManager,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->docuementManager = $docuementManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Utilisateur;
    }

    /**
     * @param Utilisateur $data
     */
    public function persist($data, array $context = [])
    {
        if ($data->getPlainPassword()) {
            $data->setPassword(
                $this->passwordHasher->hashPassword(
                    $data,
                    $data->getPlainPassword()
                )
            );

            $data->eraseCredentials();
        }

        $this->docuementManager->persist($data);
        $this->docuementManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->docuementManager->remove($data);
        $this->docuementManager->flush();
    }
}