<?php

namespace App\Fournisseurs\Repositories;

use App\Fournisseurs\Documents\Plan;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class PlanRepository extends DocumentRepository
{
    public function findLastIndiceOfArticle(string $articleIri): ?Plan
    {
        return $this->dm->createQueryBuilder(Plan::class)
            ->select('indice')
            ->field('articleIri')->equals($articleIri)
            ->sort('id', 'desc')
            ->limit(1)
            ->readOnly()
            ->getQuery()
            ->getSingleResult();
    }
}