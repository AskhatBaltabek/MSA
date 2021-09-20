<?php

namespace App\Console\Commands;

use App\Http\Requests\OnesRequest;
use App\Models\ProductAccess;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SyncUsersOneS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(): int
    {
        ini_set('max_execution_time', '300');
        set_time_limit(300);
        $onesReq = new OnesRequest();
        $staff = $onesReq->getData(OnesRequest::STAFF_URL);
        $agents = $onesReq->getData(OnesRequest::AGENTS_URL);

        if(!is_array($staff))
            return $staff;

        if(!is_array($agents))
            return $agents;

        $data = array_merge($agents['Agents'], $staff['Staff']);
        $data = collect($data);

        $result = [];

        $pass = Hash::make(Str::random(3));
        $accesses = [];
        foreach($data as $key => $rec)
        {
            $login = isset($rec['id_ЕСБД']) ? $rec['Email'] : substr($rec['Email'], 0, strpos($rec['Email'], "@"));

            if(!$login) continue;

            $userData = [
                'id_1c' => $rec['id_1c'],
                'id_ext' => $rec['id_ЕСБД'] ?? NULL,
                'natural_person_bool' => $rec['NaturalPersonBool'] ?? 1,
                'link_to_branch' => $rec['LinkToBranch'] ?? 0,
                'name' => $rec['JuridicalPersonName'] ?? NULL,
                'email' => $rec['Email'],
                'login' => $login,
                'last_name' => $rec['LastName'],
                'first_name' => $rec['FirstName'],
                'middle_name' => $rec['MiddleName'],
                'resident' => $rec['Resident'],
                'address' => $rec['Adress'],
                'manager_id' => !isset($rec['id_ЕСБД']) ? $rec['id_1c'] : $rec['Manager_id'],
                'agent_id' => isset($rec['id_ЕСБД']) ? $rec['id_1c'] : NULL,
                'filial' => $rec['Filial'],
                'filial_id_1c' => $rec['Filial_Id_1c'] ?? NULL,
                'department' => $rec['Department'],
                'position' => $rec['Position'],
                'sales' => $rec['IdSales'] ?? NULL,
                'document_number' => $rec['DocumentNumber'] ?? NULL,
                'document_start_date' => $rec['DocumentStartDate'] ?? NULL,
                'document_end_date' => $rec['DocumentEndDate'] ?? NULL,
                'iin' => $rec['IIN'],
                'mobile_phone' => $rec['TelephoneNumber'],
                'external' => isset($rec['id_ЕСБД']) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            if(!empty($rec['ID_Detailing']) && !empty($rec['ID_SalesChannel'])) {
                $accesses[] = [
                    'user_id' => $rec['id_1c'],
                    'product_id' => 0,
                    'sales_channel_id_1c' => $rec['ID_SalesChannel'],
                    'detailing_id_1c' => $rec['ID_Detailing'],
                    'online' => 0,
                ];
            }

            $user = $data->where('Email', $rec['Email'])->where('Email');

            if(count($user) > 1) continue;

            $user = User::findBy('login', $login);

            if($user)
            {
                $userData['updated_at'] = date('Y-m-d H:i:s');
                $user->update($userData);
                continue;
            }

            $userData['password'] = $pass;
            $userData['created_at'] = date('Y-m-d H:i:s');
            $result[$key] = $userData;
        }
        ProductAccess::truncate();
        ProductAccess::insert($accesses);
        User::insert($result);

        $this->info('Пользователи успешно синхронизированы!');
        return 0;
    }
}
