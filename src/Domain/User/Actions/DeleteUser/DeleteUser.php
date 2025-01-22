<?php

declare(strict_types=1);

namespace Domain\User\Actions\DeleteUser;

class DeleteUser
{
    public function __invoke(DeleteUserInput $input): DeleteUserOutput
    {
        $input->user->deleteProfilePhoto();
        $input->user->tokens->each->delete();
        $input->user->delete();

        return new DeleteUserOutput;
    }
}
