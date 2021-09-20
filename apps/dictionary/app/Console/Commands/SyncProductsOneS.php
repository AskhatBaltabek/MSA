<?php

namespace App\Console\Commands;

use App\Http\Requests\OnesRequest;
use App\Models\Product;
use App\Models\ProductDefault;
use App\Models\ProductsRelation;
use Exception;
use Illuminate\Console\Command;

class SyncProductsOneS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация продуктов каждый день с 1С';

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
        $data = $onesReq->getProducts();

        $products = [];
        $relations = [];
        $defaults = [];
        foreach ($data as $product) {
            $products[] = [
                'id_1c' => $product->ID_WebBox,
                'title' => $product->Product,
                'code' => $product->Code,
                'obligate' => $product->Obligate,
                'complex' => $product->Complex,
                'not_quoted' => 1,
                'prolongation_type' => $product->Prolongation_Type,
                'active' => $product->Active,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            foreach($product->TypesRisks as $rel)
            {
                $relations[] = [
                    'product_id_1c' => $product->ID_WebBox,
                    'insurance_risk_id_1c' => $rel->RiskID_WebBox,
                    'insurance_object_id_1c' => $rel->ObjectID_WebBox,
                    'insurance_type_id_1c' => $rel->TypeID_WebBox,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                if($rel->Risk_Default == 1)
                {
                    $defaults[$product->ID_WebBox.'-'.$rel->RiskID_WebBox] = [
                        'product_id_1c' => $product->ID_WebBox,
                        'default_key' => 'risk_default',
                        'default_id' => $rel->RiskID_WebBox,
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }

                if($rel->TypeDefault == 1)
                {
                    $defaults[$product->ID_WebBox.'-'.$rel->TypeID_WebBox] = [
                        'product_id_1c' => $product->ID_WebBox,
                        'default_key' => 'type_default',
                        'default_id' => $rel->TypeID_WebBox,
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }
            }
        }
        try {
            Product::truncate();
            Product::insert($products);
            ProductsRelation::truncate();
            ProductsRelation::insert($relations);
            ProductDefault::truncate();
            ProductDefault::insert($defaults);
            $this->info('Продукты успешно загружены!');
        } catch (Exception $e) {
            $this->info($e->getMessage());
        }
    }
}
