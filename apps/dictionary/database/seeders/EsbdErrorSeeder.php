<?php

namespace Database\Seeders;

use App\Models\EsbdError;
use Illuminate\Database\Seeder;

class EsbdErrorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = [
            [
                'method' => 'SetClient_ЮЛ_резидент',
                'error'  => "Ошибка! Строка не должна содержать одинарные кавычки '",
                'body'   => "System.Web.Services.Protocols.SoapException: Ошибка! Строка не должна содержать одинарные кавычки '
   at IICWEB.ExtensionString.checkQuotes(String Value)
   at IICWEB.IICWebService.checkClassQuotas(Object aClassObject)
   at IICWEB.IICWebService.SetClient(String aSessionID, Client aClient)",
            ],
        ];
        foreach ($templates as $value) {
            $template = EsbdError::firstWhere('error', $value['error']);
            if ($template) {
                $template->update($value);
            } else {
                EsbdError::create($value);
            }
        }
    }
}
