<?php

use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('colors')->insert([
			['name' => '0', 'color' => '#000000'],
			['name' => '1', 'color' => '#000000'],
			['name' => '+2', 'color' => '#000000'],
		]);
	}
}
