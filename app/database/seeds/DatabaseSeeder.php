<?php

class DatabaseSeeder extends Seeder {

    private $tables = [
        'users','profiles', 'roles','payments'
    ];
    private $seeders = [
        'UsersTableSeeder','RolesTableSeeder','ProfilesTableSeeder',
        'UsersRolesTableSeeder'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();

        Eloquent::unguard();

        foreach ($this->seeders as $seederClass) {
           $this->call($seederClass);
        }

    }

    private function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($this->tables as $tablename) {
            DB::table($tablename)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

}
