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

    /**
     * Skip validation on 4xx errors.
     */
    public $skipOnError = false;

    public function getDefaultOption()
    {
        return 'microService';
    }
}
