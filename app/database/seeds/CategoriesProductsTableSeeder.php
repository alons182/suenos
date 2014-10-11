<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Suenos\Categories\Category;
use Suenos\Products\Product;


class CategoriesProductsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        $categoriesIds = Category::lists('id');
        $ProductsIds = Product::lists('id');
        foreach(range(1, Product::count()) as $index)
        {

            DB::table('category_product')->insert([
                'category_id' => $faker->randomElement($categoriesIds),
                'product_id' => $index,
            ]);

        }


    }

}