<?php

declare(strict_types=1);

namespace Domain\User\Actions;

use Domain\User\Models\User;

class DeleteUser
{
    public function __invoke(User $user): void
    {
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
    }
}
