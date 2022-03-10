<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        //獲得去掉ID為1(管理員)的用戶
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        //追蹤除了1號用戶之外的所有用戶
        $user->follow($follower_ids);

        //除1號用戶之外的所有用戶都關注1號用戶
        foreach ($followers as $follower) {
            $follower->follow($user_id);
        }
    }
}
