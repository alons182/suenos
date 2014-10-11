<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Suenos\Products\Product;


class ProductsTableSeeder extends Seeder {

    /**
     *
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index)
        {

            $name_product = $faker->word;
            Product::create([
                'name'        => $name_product,
                'slug'        => Str::slug($name_product),
                'description' => $faker->text(),
                'price' => $faker->randomFloat(),
                'promo_price' => 0,
                'discount' => 0,
                'sizes' => [],
                'colors' => [],
                'relateds' => [],
                'published'   => 1,
                'featured'    => $faker->randomDigit([1,0])

            ]);
        }


    }
}