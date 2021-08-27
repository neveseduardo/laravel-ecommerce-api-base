<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use App\Models\State;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path('city_state.json');
        $json = json_decode(file_get_contents($path), true);

        foreach ($json['estados'] as $state) {
            $parent = State::where('initials', $state['sigla'])->get()->first();

            foreach ($state['cidades'] as $city) {
                City::create(['name' => $city, 'state_id' => $parent->id, 'user_id' => 1]);
            }
        }
    }
}
