<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Suenos\Roles\Role;

class RolesTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        Role::create([
            'name' => 'administrator'
        ]);
        Role::create([
            'name' => 'subadministrator'
        ]);
        Role::create([
            'name' => 'tienda'
        ]);
        Role::create([
            'name' => 'member'
        ]);




    }

}