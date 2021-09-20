<?php

namespace App\Console\Commands;

use App\Http\Requests\OnesRequest;
use App\Models\InsuranceRisk;
use Illuminate\Console\Command;
use Illuminate\Http\Response;

class SyncInsuranceRisksOneS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:risks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация рисков каждый день с 1С';

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
        $data = $onesReq->getRisks();

        $risks = [];
        foreach ($data as $risk) {
            $risks[] = [
                'id_1c' => $risk->ID_WebBox,
                'title' => $risk->Risk,
                'active' => $risk->Active,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        try {
            InsuranceRisk::truncate();
            InsuranceRisk::insert($risks);
            $this->info('Риски успешно загружены!');
        } catch (\Exception $e) {
            $this->info($e->getMessage());
        }
    }
}
