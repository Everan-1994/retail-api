<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 创建超级管理员
        User::insert([
            [
                'name'     => 'Everan',
                'truename' => 'Everan',
                'phone'    => '18818801234',
                'identify' => 1,
                'password' => bcrypt('199457'),
                'avatar'   => 'https://lccdn.phphub.org/uploads/avatars/17854_1500883966.jpeg?imageView2/1/w/100/h/100'
            ],
            [
                'name'     => '鲜果助手',
                'truename' => '小桂子',
                'phone'    => '18777163309',
                'identify' => 1,
                'password' => bcrypt('a18777163309'),
                'avatar'   => 'https://lccdn.phphub.org/uploads/avatars/17854_1500883966.jpeg?imageView2/1/w/100/h/100'
            ]
        ]);
    }
}
