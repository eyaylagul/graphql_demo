<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $state = array_merge(
            $this->getNameStates('ca', 5, 1),
            $this->getNameStates('us', 3, 2)
        );

        DB::table('state')->insert($state);
    }

    /**
     * @param string $nameFileCSV
     * @param int    $stateColumnIndex
     * @param int    $countryID
     *
     * @return array
     */
    private function getNameStates(string $nameFileCSV, int $stateColumnIndex, int $countryID): array
    {
        $data     = array_map('str_getcsv', file(resource_path("region/$nameFileCSV.csv")));
        $allState = [];
        $states   = [];
        foreach ($data as $v) {
            $allState[] = $v[$stateColumnIndex];
        }
        foreach (array_unique($allState) as $v) {
            $states[] = [
                'name'       => $v,
                'country_id' => $countryID,
            ];
        }

        return $states;
    }
}
