<?php

namespace App\ModelBundle\Validator;

use App\ModelBundle\Iri\IriChecker;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class IriValidator extends ConstraintValidator
{
    private IriChecker $iriExistenceChecker;

    public function __construct(IriChecker $iriExistenceChecker) {
        $this->iriExistenceChecker = $iriExistenceChecker;
    }

    /**
     * @param Iri $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (empty($constraint->types)) {
            throw new \LogicException(sprintf("You must specify 'types' attribute of '%s'", Iri::class));
        }

        if (!$value) {
            return;
        }

        try {
            $checkedIris = $this->iriExistenceChecker->getIriExistenceStatuses($constraint->types, is_array($value) ? $value : [$value]);
        } catch (ClientExceptionInterface|ExceptionInterface $e) {
        }

        $isArray = is_array($value);
        $values = $isArray ? $value : [$value];

        foreach ($values as $key => $iri) {
            if (!($checkedIris[$iri] ?? false)) {
                $violation = $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ iri }}', $iri);

                if ($isArray) {
                    $violation->atPath("[$key]");
                }

                $violation->addViolation();
            }
        }
    }
}
