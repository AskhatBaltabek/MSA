<?php

namespace App\Console\Commands;

use App\Http\Requests\OnesRequest;
use App\Models\InsuranceObject;
use App\Models\InsuranceType;
use Illuminate\Console\Command;
use Illuminate\Http\Response;

class SyncInsuranceObjectsOneS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:objects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация объектов страхования каждый день с 1С';

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
     */
    public function handle()
    {
        $onesReq = new OnesRequest();
        $data = $onesReq->getInsuranceObjects();

        $objects = [];
        foreach ($data as $object) {
            $objects[] = [
                'id_1c' => $object->ID_WebBox,
                'title' => $object->Object,
                'type' => $object->Object_Type,
                'active' => $object->Active,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        try {
            InsuranceObject::truncate();
            InsuranceObject::insert($objects);
            $this->info('Объекты успешно загружены!');
        } catch (\Exception $e) {
            $this->info($e->getMessage());
        }
    }
}
