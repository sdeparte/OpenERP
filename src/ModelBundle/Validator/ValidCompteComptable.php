<?php

namespace App\ModelBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidCompteComptable extends Constraint
{
    public const EMPLOYE = 'employe';
    public const CLIENT = 'client';
    public const FOURNISSEUR = 'fournisseur';
    public const TVA = 'tva';

    public string $messageNotFound = "'{{ compte }}' ne semble pas exister.";
    public string $messageDefault = "'{{ compte }}' n'est pas un numéro comptable valide.";
    public string $message = "'{{ compte }}' n'est pas un numéro comptable de type {{ type }} valide.";

    public ?string $type = null;

    public function getDefaultOption()
    {
        return 'type';
    }
}
