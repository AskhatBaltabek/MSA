<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\OnesRequest;
use App\Jobs\UserCreated;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use function PHPUnit\TestFixture\func;

class UsersController extends BaseController
{
    /**
     * @return User[]|Collection
     */
    public function getUsers()
    {
        $users = User::with('roles')->get();
        foreach ($users as $key => $user) {
            $users[$key]['roles_ids'] = $user->rolesIds();
        }
        return $users;

//        $users = DB::table('users', 'u')->leftJoin('users_roles', 'user_id', '=', 'u.id')->get();
    }

    /**
     * @return Authenticatable|null
     */
    public function getUser()
    {
        return Auth::user();
    }

    public function deleteUser(Request $request)
    {
        /** @var User $user */
        $user = User::find($request->id);
        $user->delete();
        return $this->sendResponse($user, "User: $user->first_name deleted!");
    }

    public function storeUser(Request $request)
    {
        try {
            if(isset($request->id))
            {
                $user = User::with('roles')->find($request->id);
            }
            else
            {
                $user = new User;
            }

            if(isset($request->last_name) && isset($request->first_name)) {
                $user->last_name = $request->last_name;
                $user->first_name = $request->first_name;
            }
            if(array_key_exists('middle_name', $request->all())) $user->middle_name = $request->middle_name;
            if(isset($request->iin)) $user->iin = $request->iin;

            $user->login = $request->login ? $request->login : $request->email;
            $user->email = $request->email;
            if(isset($request->password))
            {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            if(isset($request->roles_ids))
            {
                $user->roles()->sync($request->roles_ids);
            }
            $user = $user->refresh();

            UserCreated::dispatch($user);

            return $this->sendResponse($user, "User: $request->first_name saved!");
        } catch (ClientException $e) {
            return $this->sendError('Error!', [$e->getMessage()], $e->getCode());
        }
    }

    function toArray($data) {
        if (is_object($data)) $data = get_object_vars($data);
        return is_array($data) ? array_map(__FUNCTION__, $data) : $data;
    }

    public function syncOneS()
    {

    }

    public function importRolesWB()
    {

        $result = [];

    }

    public function setUsersRoles()
    {
    }
}
