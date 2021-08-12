<?php

namespace App\ModelBundle\Validator;

use App\ModelBundle\Checker\IriExistenceChecker;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class IriValidator extends ConstraintValidator
{
    /**
     * @var IriExistenceChecker
     */
    private $iriExistenceChecker;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(IriExistenceChecker $iriExistenceChecker, LoggerInterface $logger) {
        $this->iriExistenceChecker = $iriExistenceChecker;
        $this->logger = $logger;
    }

    /**
     * @param Iri $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (empty($constraint->microService)) {
            throw new \LogicException(sprintf("You must specify 'microService' attribute of '%s'", Iri::class));
        }

        if (!$value) {
            return;
        }

        try {
            $checkedIris = $this->iriExistenceChecker->getIriExistenceStatuses($constraint->microService, is_array($value) ? $value : [$value]);
        } catch (ClientExceptionInterface $e) {
            if ($constraint->skipOnError) {
                return;
            }

            throw new \RuntimeException(sprintf("Unable to validate IRIs of microservice '%s': %s", $constraint->microService, $e->getMessage()));
        } catch (ExceptionInterface $e) {
            $this->logger->notice(sprintf("Unable to validate IRIs of microservice '%s': %s", $constraint->microService, $e->getMessage()));

            return;
        }

        $isArray = is_array($value);
        $value = $isArray ? $value : [$value];
        foreach ($value as $k => $iri) {
            if (!($checkedIris[$iri] ?? false)) {
                $violation = $this->context->buildViolation($constraint->message)->setParameter('{{ iri }}', $iri);
                if ($isArray) {
                    $violation->atPath("[$k]"); // define the violation path if we got an array of iris
                }
                $violation->addViolation();
            }
        }
    }
}
