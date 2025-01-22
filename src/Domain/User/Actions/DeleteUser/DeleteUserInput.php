<?php

declare(strict_types=1);

namespace Domain\User\Actions\DeleteUser;

use Domain\User\Models\User;

readonly class DeleteUserInput
{
    public function __construct(
        public User $user,
    ) {}
}
