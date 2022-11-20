<?php

namespace App\Policies;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ChirpPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Chirp $chirp): Response|bool
    {
        return $chirp->user()->is($user);
    }
}
