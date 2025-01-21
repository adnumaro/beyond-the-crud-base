<?php

declare(strict_types=1);

namespace Presentation\Web\User\Controllers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\ConfirmPassword;

class DeleteOtherBrowserSessionsController extends Controller
{
    public function __invoke(
        Request $request,
        StatefulGuard $guard,
        ConfirmPassword $confirmPassword,
    ): RedirectResponse {
        $confirmed = $confirmPassword(
            $guard, $request->user(), $request->password,
        );

        if (! $confirmed) {
            throw ValidationException::withMessages([
                'password' => __('The password is incorrect.'),
            ]);
        }

        $guard->logoutOtherDevices($request->password);

        $this->deleteOtherSessionRecords($request);

        return back(303);
    }

    protected function deleteOtherSessionRecords(Request $request): void
    {
        if ('database' !== config('session.driver')) {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }
}
