<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    public function destroy(User $currentUser, User $user){
        //當前用戶具管理員權限且刪除的用戶不是自己時才顯示
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }

}
