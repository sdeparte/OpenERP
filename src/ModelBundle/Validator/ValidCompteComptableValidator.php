<?php

namespace App\ModelBundle\Validator;

use App\ModelBundle\Iri\IriGetter;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidCompteComptableValidator extends ConstraintValidator
{
    private IriGetter $iriGetter;

    public function __construct(IriGetter $iriGetter) {
        $this->iriGetter = $iriGetter;
    }

    /**
     * @param ValidCompteComptable $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        $isArray = is_array($value);
        $values = $isArray ? $value : [$value];

        foreach ($values as $key => $value) {
            if (preg_match('#^/api/compte_comptables/#', $value)) {
                $compteComptable = $this->iriGetter->getIri($value);

                if (null === $compteComptable) {
                    $violation = $this->context->buildViolation($constraint->messageNotFound)
                        ->setParameter('{{ compte }}', $value);

                    if ($isArray) {
                        $violation->atPath("[$key]");
                    }

                    $violation->addViolation();

                    continue;
                }

                $value = $compteComptable['numero'];
            }

            $isValid = $this->isCompteValide($value);

            switch ($constraint->type) {
                case ValidCompteComptable::EMPLOYE:
                    $isValid = $this->isCompteEmploye($value);
                    break;
                case ValidCompteComptable::CLIENT:
                    $isValid = $this->isCompteClient($value);
                    break;
                case ValidCompteComptable::FOURNISSEUR:
                    $isValid = $this->isCompteFournisseur($value);
                    break;
                case ValidCompteComptable::TVA:
                    $isValid = $this->isCompteTVA($value);
                    break;
            }

            if (!$isValid) {
                if (null !== $constraint->type) {
                    $violation = $this->context->buildViolation($constraint->message)
                        ->setParameter('{{ compte }}', $value)
                        ->setParameter('{{ type }}', $constraint->type);
                } else {
                    $violation = $this->context->buildViolation($constraint->messageDefault)
                        ->setParameter('{{ compte }}', $value);
                }

                if ($isArray) {
                    $violation->atPath("[$key]");
                }

                $violation->addViolation();
            }
        }
    }

    private function isCompteEmploye(string $numero)
    {
        return intval($numero) >= 42100000 && intval($numero) <= 42199999;
    }

    private function isCompteClient(string $numero)
    {
        return intval($numero) >= 41000000 && intval($numero) <= 41099999;
    }

    private function isCompteFournisseur(string $numero)
    {
        return intval($numero) >= 40000000 && intval($numero) <= 40099999;
    }

    private function isCompteTVA(string $numero)
    {
        return intval($numero) >= 44000000 && intval($numero) <= 44999999;
    }

    private function isCompteValide(string $numero)
    {
        return intval($numero) > 9999999;
    }
}
