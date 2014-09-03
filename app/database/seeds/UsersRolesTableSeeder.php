<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Suenos\Roles\Role;
use Suenos\Users\User;

class UsersRolesTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        $usersIds = User::lists('id');
        $rolesIds = Role::lists('id');
        foreach(range(1, 5) as $index)
        {

            DB::table('role_user')->insert([
                'role_id' => $faker->randomElement($rolesIds),
                'user_id' => $faker->randomElement($usersIds)
            ]);

        }
    }

}