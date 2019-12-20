<?php

namespace App\User\Controllers;

use App\User\Controllers\UserSourcesController;
use Domain\User\Actions\SendUserVerificationAction;
use Domain\User\Actions\VerifyUserAction;
use Domain\User\Models\User;
use Illuminate\Http\Response;

final class UserVerificationController
{
    public function verify(
        User $user,
        string $verificationToken,
        VerifyUserAction $verifyUserAction
    ) {
        abort_unless($user->verification_token === $verificationToken, Response::HTTP_NOT_FOUND);

        $verifyUserAction($user);

        return redirect()->action([UserSourcesController::class, 'index']);
    }

    public function resend(
        User $user,
        SendUserVerificationAction $sendUserVerificationAction
    ) {
        $sendUserVerificationAction($user);

        return redirect()->back();
    }
}