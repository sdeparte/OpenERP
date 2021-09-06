<?php

namespace App\ModelBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Unique extends Constraint
{
    public string $message = "Un document '{{ class }}' existe déjà avec ces mêmes valeurs de clés.";

    public string $class;

    /**
     * @var array|string
     */
    public $fields;

    public function getTargets()
    {
        return [self::CLASS_CONSTRAINT, self::PROPERTY_CONSTRAINT];
    }

    public function getDefaultOption()
    {
        return 'class';
    }

    public function getRequiredOptions()
    {
        return ['class', 'fields'];
    }
}
