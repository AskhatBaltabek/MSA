<?php

namespace App\Console\Commands;

use App\Models\ActivityKind;
use App\Services\EsbdService;
use App\Services\RestService;
use Illuminate\Console\Command;

class GetActivityKindsItemsESBD extends Command
{
    public $restService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:activity-kinds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получения в справочника ACTIVITY KINDS через сервис Rest';

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
        $table_name = 'ACTIVITY_KINDS';
        $response   = EsbdService::getItems($table_name);
        if (isset($response['GetItemsResult']['Item'])) {
            $data  = $response['GetItemsResult']['Item'];
            $items = [];
            foreach ($data as $item) {
                $items[] = [
                    'id_esbd'        => $item['ID'],
                    'parent_id_esbd' => $item['PARENT_ID'] == 0 ? null : $item['PARENT_ID'],
                    'title'          => isset($item['Name']) ? $item['Name'] : '-',
                    'code'           => $item['Code'],
                    'created_at'     => now(),
                    'updated_at'     => now()
                ];
            }
            if (count($items)) {
                ActivityKind::truncate();
                ActivityKind::insert($items);
            }
        }
    }
}
