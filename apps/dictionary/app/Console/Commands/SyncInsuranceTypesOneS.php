<?php

namespace App\Console\Commands;

use App\Http\Requests\OnesRequest;
use App\Models\InsuranceType;
use Illuminate\Console\Command;

class SyncInsuranceTypesOneS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация типов страхования каждый день с 1С';

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
        $onesReq = new OnesRequest();
        $data = $onesReq->getInsuranceTypes();

        $types = [];
        foreach ($data as $type) {
            $types[] = [
                'id_1c' => $type->ID_WebBox,
                'title' => $type->Type,
                'serial_number' => $type->SerialNumber,
                'obligate' => $type->SerialObligate,
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        try {
            InsuranceType::truncate();
            InsuranceType::insert($types);
            $this->info('Типы успешно загружены!');
        } catch (\Exception $e) {
            $this->info($e->getMessage());
        }
    }
}
