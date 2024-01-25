<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Obuchmann\OdooJsonRpc\Odoo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class UserImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function method_1(Odoo $odoo)
    {
        $erpUsers = $odoo->model('res.users')->fields(['id', 'name', 'email', 'phone'])->get();
        $currentUsers = User::pluck('external_user_id')->all();
        $newUserList = [];

        foreach ($erpUsers as $user) {
            if (!in_array($user->id, $currentUsers) && !collect($newUserList)->contains('external_user_id', $user->id)) {
                $newUserList[] = [
                    'external_user_id' => $user->id,
                    'role_id' => 4,
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => 'default123', // Use bcrypt for password hashing
                    'no_hp' => $user->phone,
                ];
            }
        }

        if (!empty($newUserList)) {
            DB::table('users')->insert($newUserList);
            $allDataQty = count($erpUsers);
            Log::info("Updated: $allDataQty Data");
        }
    }

    public function method_2(Odoo $odoo)
    {
        log::info('User Import Job Running');
        $erpUsers = $odoo->model('res.users')->fields(['id', 'name', 'email', 'phone'])->get();
        log::info('user data retrieved from erp');
        log::info('looping through user data');
        foreach ($erpUsers as $user) {
            $currentUserList = User::select('external_user_id', 'email', 'no_hp')->get();
            if (!$currentUserList->contains('external_user_id', $user->id) && !$currentUserList->contains('email', $user->email) && !$currentUserList->contains('no_hp', $user->phone)) {
                $newUser = new User();
                $newUser->external_user_id = $user->id;
                $newUser->role_id = 4;
                $newUser->name = $user->name;
                $newUser->email = $user->email;
                $newUser->password = 'default123';
                $newUser->no_hp = $user->phone;
                $newUser->save();
            }
        }
        $allDataQty = count($erpUsers);
        Log::info("Updated: $allDataQty Data");
    }

    public function method_3(Odoo $odoo)
    {
        log::info('User Import Job Running');
        $erpUsers = $odoo->model('res.users')->fields(['id', 'name', 'email', 'phone'])->get();
        $newUserList = [];
        log::info('user data retrieved from erp');
        log::info('looping through user data');
        foreach ($erpUsers as $user) {
            $existingUser = User::where('external_user_id', $user->id)->select('id')->first();
            if (!$existingUser) {
                $newUserList[] = [
                    'external_user_id' => $user->id,
                    'role_id' => 4,
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => Hash::make('default123'),
                    'no_hp' => $user->phone,
                ];
            }
        }

        if (!empty($newUserList)) {
            DB::table('users')->insert($newUserList);
            $allDataQty = count($erpUsers);
            Log::info("Updated: $allDataQty Data");
        }

        $allDataQty = count($erpUsers);
        Log::info("Updated: $allDataQty Data");
    }

    public function importManagerSales(Odoo $odoo)
    {
        /*
        Log::info('User Manager Sales Import Job Running');

        $erpUsers = $odoo->model('res.users')
            ->fields(['id', 'name', 'login', 'email', 'phone', 'company_id'])
            ->where('login', 'ilike', '%ms_%')
            ->where('login', 'not ilike', '%yard%')
            ->get();
        $newUserList = [];

        Log::info('user data retrieved from erp');
        Log::info('looping through user data');

        foreach ($erpUsers as $user) {
            if ($user->phone == '0') {
                $user->phone = '(none)';
            }

            $newUserList[] = [
                'id' => $user->id,
                'role_id' => 4,
                'name' => $user->name,
                'email' => $user->login . '@gmail.com',
                'password' => bcrypt('default123'), // Use bcrypt for password hashing
                'no_hp' => $user->phone,
                'company_id' => $user->company_id[0],
            ];
        }

        if (!empty($newUserList)) {
            DB::table('users')->insert($newUserList);
            Log::info("Updated: " . count($erpUsers) . " Data");
        }
        Log::info('User Manager Sales Import Job Finished');
        */

        Log::info('User Manager Sales Import Job Running');
        $erpUsers = $odoo->model('res.users')
            ->fields(['id', 'name', 'login', 'email', 'phone', 'company_id'])
            ->where('login', 'ilike', '%ms_%')
            ->where('login', 'not ilike', '%yard%')
            ->get();
        Log::info('user data retrieved from erp');
        Log::info('looping through user data');
        foreach ($erpUsers as $user) {
            if ($user->phone == '0') {
                $user->phone = '(none)';
            }
            DB::table('users')->updateOrInsert(['id' => $user->id], [
                'id' => $user->id,
                'role_id' => 4,
                'company_id' => $user->company_id[0],
                'name' => $user->name,
                'email' => $user->login . '@gmail.com',
                'password' => bcrypt('default123'),
                'no_hp' => $user->phone,
            ]);
        }
    }

    /**
     * Execute the job.
     */
    public function handle(Odoo $odoo): void
    {
        $this->importManagerSales($odoo);
    }
}
