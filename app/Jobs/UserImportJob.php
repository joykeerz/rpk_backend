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

    /**
     * Execute the job.
     */
    public function handle(Odoo $odoo): void
    {
        //method 1
        /*
        $erpUsers = $odoo->model('res.users')->fields(['id', 'name', 'email', 'phone'])->get();
        $currentUsers = User::pluck('external_user_id')->all();
        $newUserList = [];

        foreach ($erpUsers as $user) {
            // if (!in_array($user->id, $currentUsers) && !collect($newUserList)->contains('external_user_id', $user->id)) {
                $newUserList[] = [
                    'external_user_id' => $user->id,
                    'role_id' => 4,
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => 'default123', // Use bcrypt for password hashing
                    'no_hp' => $user->phone,
                ];
            // }
        }

        if (!empty($newUserList)) {
            DB::table('users')->insert($newUserList);
            $allDataQty = count($erpUsers);
            Log::info("Updated: $allDataQty Data");
        }
        */

        //method 2
        log::info('User Import Job Running');
        $erpUsers = $odoo->model('res.users')->fields(['id', 'name', 'email', 'phone'])->get();
        log::info('user data retrieved from erp');
        log::info('looping through user data');
        foreach ($erpUsers as $user) {
            $currentUserList = User::select('external_user_id','email','no_hp')->get();
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
}
