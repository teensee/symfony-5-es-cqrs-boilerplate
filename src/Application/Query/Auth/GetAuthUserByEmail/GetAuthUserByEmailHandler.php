<?php

declare(strict_types=1);

namespace App\Application\Query\Auth\GetAuthUserByEmail;

use App\Domain\User\Repository\GetUserCredentialsByEmailInterface;
use App\Infrastructure\Share\Bus\Query\QueryHandlerInterface;
use App\Infrastructure\User\Auth\Auth;
use Assert\AssertionFailedException;

class GetAuthUserByEmailHandler implements QueryHandlerInterface
{
    private GetUserCredentialsByEmailInterface $userCredentialsByEmail;

    public function __construct(
        GetUserCredentialsByEmailInterface $userCredentialsByEmail
    ) {
        $this->userCredentialsByEmail = $userCredentialsByEmail;
    }

    /**
     * @throws AssertionFailedException
     */
    public function __invoke(GetAuthUserByEmailQuery $query): Auth
    {
        [$uuid, $email, $hashedPassword] = $this->userCredentialsByEmail->getCredentialsByEmail($query->email);

        return Auth::create($uuid, $email, $hashedPassword);
    }
}