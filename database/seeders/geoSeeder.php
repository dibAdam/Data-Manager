<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Geo;
class geoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('geos')->truncate();

        Geo::insert(
            [
                'geo_name' => 'france',
                'geo_code' => 'fr',
            ],
        );

        Geo::insert(
            [
                'geo_name' => 'germany',
                'geo_code' => 'de',
            ],
        );

        Geo::insert(
            [
                'geo_name' => 'morocco',
                'geo_code' => 'ma',
            ]
        );
    }
}
