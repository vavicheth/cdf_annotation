<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'title_id' => null, 'name' => 'Administrator', 'name_kh' => '', 'email' => 'admin@calmette.org', 'password' => '$2y$10$X8n/bXT8gY4P4KWsXnbCV.gcVg/slN54tE68YaAgG1hA3ysW3olOC', 'gender' => '', 'dob' => '', 'phone' => null, 'staff_code' => null, 'position_id' => null, 'department_id' => null, 'role_id' => 1, 'remember_token' => '', 'photo' => null,],

        ];

        foreach ($items as $item) {
            \App\User::create($item);
        }
    }
}
