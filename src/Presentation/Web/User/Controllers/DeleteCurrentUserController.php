<?php

declare(strict_types=1);

namespace Presentation\Web\User\Controllers;

use Domain\User\Actions\DeleteUser;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Laravel\Fortify\Actions\ConfirmPassword;
use Symfony\Component\HttpFoundation\Response;

class DeleteCurrentUserController extends Controller
{
    public function __invoke(
        Request $request,
        StatefulGuard $guard,
        ConfirmPassword $confirmPassword,
        DeleteUser $deleteUser,
    ): Response {
        $confirmed = $confirmPassword(
            $guard, $request->user(), $request->password,
        );

        if (! $confirmed) {
            throw ValidationException::withMessages([
                'password' => __('The password is incorrect.'),
            ]);
        }

        $deleteUser($request->user()->fresh());

        $guard->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Inertia::location(url('/'));
    }
}
