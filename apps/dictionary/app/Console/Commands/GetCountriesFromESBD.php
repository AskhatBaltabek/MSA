<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Services\EsbdService;
use Illuminate\Console\Command;

class GetCountriesFromESBD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получения в справочника COUNTRIES с ЕСБД';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $table_name = 'COUNTRIES';
        $result     = EsbdService::getItems($table_name);
        if (isset($result['GetItemsResult']['Item'])) {
            $countries = $result['GetItemsResult']['Item'];
            foreach ($countries as $value) {
                $value = [
                    'country_id' => $value['ID'],
                    'title'      => $value['Name'],
                    'code'       => isset($value['Code']) ? $value['Code'] : null,
                    'updated_at' => now()
                ];

                $country = Country::where('country_id', $value['country_id'])->first();
                if ($country) {
                    $country->update($value);
                } else {
                    $value = [
                        'program_id'  => 1,
                        'currency_id' => 2,
                        'multiply'    => 1,
                        'created_at'  => now()
                    ];
                    Country::create($value);
                }
            }
        }
    }
}
