<?php

namespace App\Users\Command;

use App\Users\Documents\Utilisateur;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var DocumentManager
     */
    private $documentManager;

    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct(ValidatorInterface $validator, DocumentManager $documentManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();

        $this->validator = $validator;
        $this->documentManager = $documentManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('pseudonym',  InputArgument::REQUIRED, 'User pseudonym')
            ->addArgument('username',  InputArgument::REQUIRED, 'User login')
            ->addArgument('password',  InputArgument::REQUIRED, 'User password')
            ->addArgument('employeIri',  InputArgument::OPTIONAL, 'User linked employe');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $utilisateur = (new Utilisateur())
            ->setPseudonym($input->getArgument('pseudonym'))
            ->setUsername($input->getArgument('username'))
            ->setPlainPassword($input->getArgument('password'))
            ->setEmployeIri($input->getArgument('employeIri'));

        $utilisateur->setPassword(
            $this->passwordHasher->hashPassword(
                $utilisateur,
                $utilisateur->getPlainPassword()
            )
        );

        $utilisateur->eraseCredentials();

        $violations = $this->validator->validate($utilisateur);

        if ($violations->count() > 0) {
            $message = '';

            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $message .= $violation->getPropertyPath().': '.$violation->getMessage().PHP_EOL;
            }

            throw new \Exception($message);
        }

        $this->documentManager->persist($utilisateur);
        $this->documentManager->flush();

        $output->writeln('Pseudonym: '.$utilisateur->getPseudonym());
        $output->writeln('Username: '.$utilisateur->getUsername());
        $output->writeln('Password: '.str_repeat('*', strlen($utilisateur->getPassword())));
        $output->writeln('EmployeIri: '.$utilisateur->getEmployeIri());

        return Command::SUCCESS;
    }
}