<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hobbies;

class HobbiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $hobbie = array(
            array('id' => '1', 'name' => 'hobbie1'),
            array('id' => '2', 'name' => 'hobbie2'),
            array('id' => '3', 'name' => 'hobbie3'),
            array('id' => '4', 'name' => 'hobbie4'),
            array('id' => '5', 'name' => 'hobbie5'),
        );

        foreach ($hobbie as $hobbies) {
            Hobbies::create([
                'id' => $hobbies['id'],
                'name' => $hobbies['name'],
            ]);
        }
    }
}
