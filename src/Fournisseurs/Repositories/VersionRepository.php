<?php

namespace App\Fournisseurs\Repositories;

use App\Fournisseurs\Documents\Version;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class VersionRepository extends DocumentRepository
{
    public function findLastVersionOfArticle(string $articleIri): ?Version
    {
        return $this->dm->createQueryBuilder(Version::class)
            ->select('lettre')
            ->field('articleIri')->equals($articleIri)
            ->sort('id', 'desc')
            ->limit(1)
            ->readOnly()
            ->getQuery()
            ->getSingleResult();
    }

    public function findByReferenceFournisseurIri(string $referenceFournisseurIri): iterable
    {
        return $this->dm->createQueryBuilder(Version::class)
            ->field('referenceFournisseurIris')->equals($referenceFournisseurIri)
            ->getQuery()
            ->execute();
    }

    public function findByParametreIri(string $parametreIri): iterable
    {
        return $this->dm->createQueryBuilder(Version::class)
            ->field('parametreIris')->equals($parametreIri)
            ->getQuery()
            ->execute();
    }
}