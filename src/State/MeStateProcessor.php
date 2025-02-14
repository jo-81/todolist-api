<?php

namespace App\State;

use App\Entity\User;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class MeStateProcessor implements ProcessorInterface /* @phpstan-ignore-line */
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private Security $security,
    ) {
    }

    /**
     * process.
     *
     * @param User $data
     *
     * @return User|null
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $user = $this->security->getUser();
        if (!$user instanceof User) {
            return null;
        }

        $email = $data->getEmail();
        if (!is_null($email)) {
            $user->setEmail($email);
        }

        return $this->persistProcessor->process($user, $operation, $uriVariables, $context);
    }
}
