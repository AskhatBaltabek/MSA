<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetRolesFromAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:set-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Устанавливаем роли для всех пользователей в соответствий внешних систем';

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
        $emails = User::get(['email', 'id'])->pluck('email', 'id')->toArray();

        $sqlWB = "SELECT u.email, a.itemname
                       FROM data_User u
                       LEFT JOIN AuthAssignment a
                         ON a.userid = u.id";
        $sqlCab = "SELECT u.varEmail email, a.item_name itemname
                        FROM admin u
                        LEFT JOIN auth_assignment a
                          ON a.user_id = u.intAdminID";
        $sqlEq = "SELECT u.varEmail email, a.item_name itemname
                        FROM user u
                        LEFT JOIN auth_assignment a
                          ON a.user_id = u.intUserID";
        $sqlCrm = "SELECT u.email, r.name itemname
                        FROM users u
                        LEFT JOIN user_roles r
                          ON r.user_role_id = u.user_role_id";

        $wb = DB::connection('webbox')->select(DB::raw($sqlWB));
        $cab = DB::connection('cabinet')->select(DB::raw($sqlCab));
        $eq = DB::connection('eq')->select(DB::raw($sqlEq));
        $crm = DB::connection('crm')->select(DB::raw($sqlCrm));

        $res = collect(array_merge($wb, $cab, $eq, $crm));
        $noRoles = [];
        foreach($emails as $id => $email)
        {
            $user = User::find($id);
            $userRoles = $res->where('email', $email);

            $roleIds = [];
            foreach($userRoles as $role)
            {
                $r = Role::where('title', $role->itemname)->first();

                if(!$r)
                {
                    $noRoles[] = $role;
                    continue;
                }

                $roleIds[] = $r->id;
            }
            $user->roles()->sync($roleIds);
        }

        $this->info('Setting roles successfully!');
    }
}
