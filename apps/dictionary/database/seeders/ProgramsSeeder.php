<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = [
            [1, 'Программа 1', 10000],
            [2, 'Программа 2', 30000],
            [3, 'Программа 3', 50000],
            [4, 'Автосалоны', 0],
            [5, 'Шанырак', 0],
        ];

        foreach($programs as $value)
        {
            $value = [
                'id' => $value[0],
                'title' => $value[1],
                'amount' => $value[2]
            ];
            $program = Program::find($value['id']);
            if($program) {
                $program->update($value);
            }
            else
                Program::create($value);
        }
    }
}
