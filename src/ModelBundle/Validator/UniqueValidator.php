<?php

namespace App\ModelBundle\Validator;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueValidator extends ConstraintValidator
{
    /**
     * @var DocumentManager
     */
    private $documentManager;

    public function __construct(DocumentManager $documentManager) {
        $this->documentManager = $documentManager;
    }

    /**
     * @param Unique $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        $values = (array) $value;
        $keys = array_keys($values);
        $fields = (array) $constraint->fields;
        $findBy = [];

        foreach ($fields as $field) {
            foreach ($keys as $key) {
                if (str_contains($key, $constraint->class) && str_contains($key, $field)) {
                    $findBy[$field] = $values[$key];
                    break;
                }
            }
        }

        if (null !== $this->documentManager->getRepository($constraint->class)->findOneBy($findBy)) {
            $violation = $this->context->buildViolation($constraint->message)
                ->setParameter('{{ class }}', $constraint->class);

            $violation->addViolation();
        }
    }
}
