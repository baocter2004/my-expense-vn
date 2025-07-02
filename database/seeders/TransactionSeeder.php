<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Illuminate\Support\Arr;
use Faker\Factory as Faker;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $walletIds   = \App\Models\Wallet::pluck('id')->toArray();
        $categoryIds = \App\Models\Category::pluck('id')->toArray();

        for ($i = 0; $i < 300; $i++) {
            Transaction::create([
                'user_id'          => 1,
                'wallet_id'        => Arr::random($walletIds),
                'category_id'      => Arr::random($categoryIds),
                'amount'           => $faker->randomFloat(2, 10, 10000),
                'transaction_type' => Arr::random([
                    \App\Consts\TransactionConst::EXPENSE,
                    \App\Consts\TransactionConst::INCOME,
                ]),
                'occurred_at'      => $faker->dateTimeBetween('-1 year', 'now'),
                'description'      => $faker->sentence(),
                // 'code' để trống, sẽ tự động sinh trong Event created của Model
            ]);
        }
    }
}
