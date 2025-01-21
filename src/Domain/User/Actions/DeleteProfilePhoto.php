<?php

declare(strict_types=1);

namespace Domain\User\Actions;

use Domain\User\Models\User;

class DeleteProfilePhoto
{
    public function __invoke(User $user): void
    {
        $user->deleteProfilePhoto();
    }
}
