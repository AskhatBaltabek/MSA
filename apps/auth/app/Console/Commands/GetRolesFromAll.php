<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class GetRolesFromAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получает роли из всех внешних систем';

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
        $sqlWB = "SELECT itemname FROM AuthAssignment a GROUP BY a.itemname";
        $sqlCab = "SELECT item_name itemname FROM auth_assignment a GROUP BY a.item_name";
        $sqlCrm = "SELECT name itemname FROM user_roles";
        $sqlEq = "SELECT item_name itemname FROM auth_assignment a GROUP BY a.item_name";
        $wbRoles = DB::connection('webbox')->select(DB::raw($sqlWB));
        $cabRoles = DB::connection('cabinet')->select(DB::raw($sqlCab));
        $crmRoles = DB::connection('crm')->select(DB::raw($sqlCrm));
        $eqRoles = DB::connection('eq')->select(DB::raw($sqlEq));
        $data = [];

        $res = array_merge($wbRoles, $cabRoles, $crmRoles, $eqRoles);

        foreach ($res as $role) {
            if(Role::where('title', $role->itemname)->exists()) continue;

            $data[] = [
                'title' => $role->itemname,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }

        DB::beginTransaction();
        try {
            Role::insert($data);
            DB::commit();
            $this->info('Roles getting success!');
        } catch (QueryException $e) {
            DB::rollBack();
            $this->error($e->getMessage());
        }
    }
}
