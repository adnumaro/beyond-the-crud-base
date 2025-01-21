<?php

declare(strict_types=1);

namespace Presentation\Web\User\Controllers;

use Domain\User\Actions\DeleteProfilePhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DeleteProfilePhotoController extends Controller
{
    public function __invoke(Request $request, DeleteProfilePhoto $deleteProfilePhoto): RedirectResponse
    {
        $deleteProfilePhoto($request->user());

        return back(303)->with('status', 'profile-photo-deleted');
    }
}
