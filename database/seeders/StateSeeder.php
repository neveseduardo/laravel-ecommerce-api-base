<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
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
            State::create(['name' => $state['nome'], 'initials' => $state['sigla'], 'user_id' => 1]);
        }
    }
}
