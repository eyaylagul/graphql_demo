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
        $states = array_merge(
            $this->getNameStates('ca', 5, 6, 1),
            $this->getNameStates('us', 3, 2, 2)
        );

        DB::table('state')->insert($states);
    }

    /**ii
     * @param string $nameFileCSV
     * @param int    $stateNameColumnIndex
     * @param int    $stateCodeColumnIndex
     * @param int    $countryID
     *
     * @return array
     */
    private function getNameStates(string $nameFileCSV, int $stateNameColumnIndex, int $stateCodeColumnIndex, int $countryID): array
    {
        $data     = array_map('str_getcsv', file(resource_path("region/$nameFileCSV.csv")));
        $allState = [];
        $states   = [];
        foreach ($data as $v) {
            $allState[] = [
                'code' => $v[$stateCodeColumnIndex],
                'state' => $v[$stateNameColumnIndex]
            ];
        }
        foreach ($this->unique_multidim_array($allState, 'state') as $v) {
            $states[] = [
                'code'       => $v['code'],
                'name'       => $v['state'],
                'country_id' => $countryID,
            ];
        }

        return $states;
    }

    private function unique_multidim_array(array $array, string $key) :array
    {
        $temp_array = [];
        $i = 0;
        $key_array = [];

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array, true)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
}
