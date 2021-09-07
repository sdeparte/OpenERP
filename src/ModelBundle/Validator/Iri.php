<?php

namespace App\ModelBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Iri extends Constraint
{
    public string $message = "'{{ iri }}' n'est pas une IRI valide.";

    public array $types;

    public function getDefaultOption()
    {
        return 'types';
    }

    public function getRequiredOptions()
    {
        return ['types'];
    }
}
