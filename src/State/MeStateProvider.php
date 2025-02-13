<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * MeStateProvider.
 *
 * @implements ProviderInterface<UserInterface>
 */
class MeStateProvider implements ProviderInterface
{
    public function __construct(private Security $security)
    {
    }

    /**
     * provide.
     *
     * @return UserInterface|UserInterface[]|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->security->getUser();
    }
}
