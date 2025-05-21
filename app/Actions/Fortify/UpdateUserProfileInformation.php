<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

/**
 * Class UpdateUserProfileInformation
 *
 * Kelas ini digunakan untuk mengupdate informasi profil user
 */
class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        // Buat validator untuk memvalidasi inputan
        Validator::make($input, [
            'name' => [ // Kolom nama harus diisi dan harus berupa string dengan panjang maksimal 255 karakter
                'required',
                'string',
                'max:255',
            ],

            'email' => [ // Kolom email harus diisi dan harus berupa string dengan panjang maksimal 255 karakter
                'required',
                'string',
                'email',
                'max:255',
                // Rule unik untuk memastikan email tidak sama dengan email yang sudah ada di database
                Rule::unique('users')->ignore($user->id),
            ],
        ])->validateWithBag('updateProfileInformation');

        // Jika email yang diinputkan berbeda dengan email yang ada di database
        // dan user harus memverifikasi email, maka update user yang sudah diverifikasi
        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            // Jika tidak, maka update user yang belum diverifikasi
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        // Update user yang sudah diverifikasi dengan mengisi kolom name dan email
        // serta menghapus kolom email_verified_at
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        // Kirimkan email verifikasi lagi ke user
        $user->sendEmailVerificationNotification();
    }
}

