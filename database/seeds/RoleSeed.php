<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'title' => 'Administrators',],
            ['id' => 2, 'title' => 'Modarators',],
            ['id' => 3, 'title' => 'Users',],

        ];

        foreach ($items as $item) {
            \App\Role::create($item);
        }
    }
}
