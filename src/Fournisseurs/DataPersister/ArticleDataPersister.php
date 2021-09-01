<?php

namespace App\Fournisseurs\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Fournisseurs\Documents\Article;
use App\Fournisseurs\Repositories\ArticleRepository;
use Doctrine\ODM\MongoDB\DocumentManager;

class ArticleDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var DocumentManager
     */
    private $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Article;
    }

    /**
     * @param Article $data
     *
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function persist($data, array $context = [])
    {
        /** @var ArticleRepository $repository */
        $repository = $this->documentManager->getRepository(Article::class);
        $lastArticle = $repository->findLastNumOfSousEnsemble($data->getSousEnsembleIri());

        if (!empty($lastArticle)) {
            $numero = $lastArticle->getNumero();
            $numero++;

            while (strlen($numero) < 6) {
                $numero = '0'.$numero;
            }

            $data->setNumero($numero);
        }

        $this->documentManager->persist($data);
        $this->documentManager->flush();
    }

    /**
     * @param Article $data
     */
    public function remove($data, array $context = [])
    {
        $this->documentManager->remove($data);
        $this->documentManager->flush();
    }
}