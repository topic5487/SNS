<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Status;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function destroy(User $user, Status $status)
    {   //當前用戶ID和文章作者ID相同才能刪除文章
        return $user->id === $status->user_id;
    }

    public function edit(User $user, Status $status)
    {   //當前用戶ID和文章作者ID相同才能編輯文章
        return $user->id === $status->user_id;
    }
}
