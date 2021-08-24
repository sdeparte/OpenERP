<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tarif
 *
 * @ApiResource
 *
 * @ODM\Document
 */
class Tarif
{
    /**
     * @var int
     *
     * @ODM\Id(strategy="INCREMENT", type="int")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ODM\Field
     */
    private $devis = null;

    /**
     * @var float
     *
     * @ODM\Field(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="{{ value }} n'est pas une quantité valide."
     * )
     */
    private $quantite;

    /**
     * @var float
     *
     * @ODM\Field(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="{{ value }} n'est pas un prix unitaire valide."
     * )
     */
    private $prixUnitHT;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Fournisseurs")
     */
    private $deviseIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Fournisseurs")
     */
    private $referenceFournisseurIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Fournisseurs")
     */
    private $planIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Fournisseurs")
     */
    private $traitementIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Fournisseurs")
     */
    private $matiereIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Fournisseurs")
     */
    private $articleIri;


}