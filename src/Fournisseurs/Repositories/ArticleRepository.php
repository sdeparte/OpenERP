<?php

namespace App\Fournisseurs\Repositories;

use App\Fournisseurs\Documents\Article;
use App\Fournisseurs\Documents\SousEnsemble;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class ArticleRepository extends DocumentRepository
{
    public function findLastNumOfSousEnsemble(SousEnsemble $sousEnsembleIri): ?Article
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

    public function findByVersionIri(string $articleIri): iterable
    {
        return $this->dm->createQueryBuilder(Article::class)
            ->field('versionIris')->equals($articleIri)
            ->getQuery()
            ->execute();
    }
}