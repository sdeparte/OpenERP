<?php

namespace App\Fournisseurs\Repositories;

use App\Fournisseurs\Documents\Article;
use App\Fournisseurs\Documents\Parametre;
use App\Fournisseurs\Documents\ReferenceFournisseur;
use App\Fournisseurs\Documents\Version;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class VersionRepository extends DocumentRepository
{
    public function findLastVersionOfArticle(Article $articleIri): ?Version
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

    public function findByReferenceFournisseurIri(ReferenceFournisseur $referenceFournisseurIri): iterable
    {
        return $this->dm->createQueryBuilder(Version::class)
            ->field('referenceFournisseurIris')->equals($referenceFournisseurIri)
            ->getQuery()
            ->execute();
    }

    public function findByParametreIri(Parametre $parametreIri): iterable
    {
        return $this->dm->createQueryBuilder(Version::class)
            ->field('parametreIris')->equals($parametreIri)
            ->getQuery()
            ->execute();
    }
}