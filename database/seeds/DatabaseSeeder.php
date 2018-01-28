<?php

use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileSystem = new Filesystem();
        $database = $fileSystem->get(base_path('database/seeds') . '/' . 'init.sql');
        DB::connection()->getPdo()->exec($database);
        DB::table('admin_users')->insert([
            'name' => 'user1',
            'real_name' => 'user1',
            'password' => bcrypt('123456'),
            'email' => 'user1@163.com',
            'mobile' => '123456',
            'avatar' => 'http://webimg-handle.liweijia.com/upload/avatar/avatar_0.jpg',
            'type' => 0,
            'is_root' => 1
        ]);

        DB::table('classes')->insert([
            'class' => '未分类',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
