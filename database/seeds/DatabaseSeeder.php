<?php

use App\Category;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // TO PREVENT CHECKS FOR foreien key in seeding

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();

        DB::table('category_product')->truncate();

        $usersQuantities = 1000;
        $categoriesQuantities = 30;
        $productsQuantities = 1000;
        $transactionsQuantities = 1000;

        factory(User::class, $usersQuantities)->create();
        factory(Category::class, $categoriesQuantities)->create();

        factory(Product::class, $productsQuantities)->create()->each(
            function ($product) {
                $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
                $product->categories()->attach($categories);
            });

        factory(Transaction::class, $transactionsQuantities)->create();
    }
}
