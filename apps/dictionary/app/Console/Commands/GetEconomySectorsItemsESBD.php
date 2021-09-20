<?php

namespace App\Console\Commands;

use App\Models\EconomicsSector;
use App\Services\EsbdService;
use App\Services\RestService;
use Illuminate\Console\Command;

class GetEconomySectorsItemsESBD extends Command
{
    public $restService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:economy-sectors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получения в справочника ECONOMY SECTORS через сервис Rest';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(RestService $restService)
    {
        $this->restService = $restService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $table_name = 'ECONOMICS_SECTORS';
        $response   = EsbdService::getItems($table_name);
        if (isset($response['GetItemsResult']['Item'])) {
            $data  = $response['GetItemsResult']['Item'];
            $items = [];
            foreach ($data as $item) {
                $items[] = [
                    'id_esbd'        => $item['ID'],
                    'parent_id_esbd' => $item['PARENT_ID'],
                    'title'          => $item['Name'],
                    'code'           => $item['Code'],
                    'updated_at'     => now()
                ];
            }
            if (count($items)) {
                EconomicsSector::truncate();
                EconomicsSector::insert($items);
            }
        }
    }
}
