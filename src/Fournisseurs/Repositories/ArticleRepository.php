<?php

namespace App\Fournisseurs\Repositories;

use App\Fournisseurs\Documents\Article;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class ArticleRepository extends DocumentRepository
{
    public function findLastNumOfSousEnsemble(string $sousEnsembleIri): ?Article
    {
        return $this->dm->createQueryBuilder(Article::class)
            ->select('numero')
            ->field('sousEnsembleIri')->equals($sousEnsembleIri)
            ->sort('id', 'desc')
            ->limit(1)
            ->readOnly()
            ->getQuery()
            ->getSingleResult();
    }

    public function findByPlanIri(string $articleIri): iterable
    {
        return $this->dm->createQueryBuilder(Article::class)
            ->field('planIris')->equals($articleIri)
            ->getQuery()
            ->execute();
    }

    public function findByTarifIri(string $tarifIri): iterable
    {
        return $this->dm->createQueryBuilder(Article::class)
            ->field('tarifIris')->equals($tarifIri)
            ->getQuery()
            ->execute();
    }
}