<?php

namespace App\ModelBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Iri extends Constraint
{
    public $message = "'{{ iri }}' n'est pas une IRI valide.";

    /**
     * Microservice name.
     */
    public $microService;

    public function getDefaultOption()
    {
        return 'microService';
    }

    public function getRequiredOptions()
    {
        return ['microService'];
    }
}
