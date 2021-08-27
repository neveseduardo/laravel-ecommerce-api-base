<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;
use App\Models\City;
use Faker\Generator as Faker;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = User::get();
        $cities = City::get()->count();

        foreach ($users as $user) {
            Address::create([
                'street' => $faker->streetName(),
                'address_number' => $faker->buildingNumber(),
                'city_id' => $faker->numberBetween(1, $cities),
                'user_id' => $user->id,
            ]);
        }
        
    }
}
