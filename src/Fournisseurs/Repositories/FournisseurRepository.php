<?php

namespace App\Fournisseurs\Repositories;

use App\Fournisseurs\Documents\Fournisseur;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class FournisseurRepository extends DocumentRepository
{
    public function findByContactIri(string $contactIri): iterable
    {
        return $this->dm->createQueryBuilder(Fournisseur::class)
            ->field('contactIris')->equals($contactIri)
            ->getQuery()
            ->execute();
}
}