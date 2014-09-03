<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Suenos\Users\User;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        User::create([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => "123"//,
            //'parent_id' => null

        ]);

      /*  foreach (range(1, 10) as $index)
        {
            User::create([
                'username' => $faker->word . $index,
                'email' => $faker->email,
                'password' => "123",
                'parent_id' => $faker->randomElement([1,2,3,4])

            ]);
        }*/

    }

}