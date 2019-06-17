<?php

use Illuminate\Database\Seeder;
use App\Models\State;

class CityTableSeeder extends Seeder
{
    private $states = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $cities = collect(
            array_merge(
                $this->getNameCities('ca', 5, [0, 1, 2]),
                $this->getNameCities('us', 3, [0, 6, 7])
            )
        ); // Make a collection to use the chunk method

        // it will chunk the dataset in smaller collections containing number values.
        $chunks = $cities->chunk(1000);

        foreach ($chunks as $chunk) {
            DB::table('city')->insert($chunk->toArray());
        }
    }

    /**
     * @param string $nameFileCSV
     * @param int    $stateColumnIndex
     * @param array  $options - index columns which has to be parsed
     *
     * @return array
     */
    private function getNameCities(string $nameFileCSV, int $stateColumnIndex, array $indexFields): array
    {
        $data = array_map('str_getcsv', file(resource_path("region/$nameFileCSV.csv")));
        if (empty($this->states)) {
            $this->states = State::all()->toArray();
        }

        $cities = [];
        foreach ($data as $v) {
            $state    = array_search($v[$stateColumnIndex], array_column($this->states, 'name'), true);
            $cities[] = [
                'name'     => $v[$indexFields[0]],
                'lat'      => $v[$indexFields[1]],
                'lng'      => $v[$indexFields[2]],
                'state_id' => $this->states[$state]['id']
            ];
        }

        return $cities;
    }
}
