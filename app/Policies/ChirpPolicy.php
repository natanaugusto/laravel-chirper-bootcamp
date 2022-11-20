<?php

namespace App\Policies;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ChirpPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Chirp $chirp): Response|bool
    {
        return $chirp->user()->is(model:$user);
    }

    public function delete(User $user, Chirp $chirp): Response|bool
    {
        return $this->update($user, $chirp);
    }
}
