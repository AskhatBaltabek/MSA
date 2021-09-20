<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class GetUsersFromWB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:import-wb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получает из WebBox внешних пользователей';

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
        $sqlWB = "
            SELECT
              id_1c,
              id_ext,
              email login,
              `password`,
              email,
              last_name,
              first_name,
              third_name middle_name,
              account_name `name`,
              if(iin = '', `bin`, iin) iin,
              phone mobile_phone,
              NULL phone,
              address,
              NULL `city`,
              (SELECT title FROM data_Branch WHERE id_1c = u.parent_Branch_id) filial,
              NULL department,
              NULL division,
              NULL `position`,
              resident,
              1 external
            FROM data_User u
            WHERE u.id_ext <> ''
              AND u.status = 1
        ";

        $res = DB::connection('webbox')->select(DB::raw($sqlWB));
        $data = [];
        foreach ($res as $user)
        {
            if($user->iin == '') $user->iin = NULL;
            if(User::findBy('iin', $user->iin)) continue;
            if(User::findBy('email', $user->email)) continue;

            $data[] = (array)$user;
        }

        DB::beginTransaction();
        try {
            User::insert($data);
            DB::commit();
            $this->info('Success users!');
        } catch (QueryException $e) {
            DB::rollBack();
            $this->error($e->getMessage());
        }
    }
}
