<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Jobs\UserImportJob;
use App\Jobs\CustomerImportJob;
use App\Jobs\PartnerImportJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Obuchmann\OdooJsonRpc\Odoo;
use Illuminate\Support\Stringable;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function importManagerSalesUsers(Odoo $odoo)
    {
        try {
            // UserImportJob::dispatch()->onQueue('imports');
            dispatch(new UserImportJob($odoo));
            Log::info('Manager Sales Import Job Dispatched Successfully');
            return 'manager sales Job dispatched successfully';
        } catch (Exception $e) {
            Log::error('Failed to dispatch User Import Job: ' . $e->getMessage());
            return 'Failed to dispatch User Import Job';
        }
    }

    public function importCustomerUsers(Odoo $odoo)
    {
        try {
            dispatch(new CustomerImportJob($odoo));
            Log::info('Customer Import Job Dispatched Successfully');
            return 'customer Job dispatched successfully';
        } catch (Exception $e) {
            Log::error('Failed to dispatch User Import Job: ' . $e->getMessage());
            return 'Failed to dispatch User Import Job';
        }
    }

    public function importPartnerUsers(Odoo $odoo)
    {
        try {
            dispatch(new PartnerImportJob($odoo));
            Log::info('Partner Import Job Dispatched Successfully');
            return 'partner Job dispatched successfully';
        } catch (Exception $e) {
            Log::error('Failed to dispatch User Import Job: ' . $e->getMessage());
            return 'Failed to dispatch User Import Job';
        }
    }

    public function oldImportFromErp(Odoo $odoo)
    {
        // $erpUsers = $odoo->model('res.users')->fields(['id', 'name', 'email', 'phone'])->get();
        //foreach ($erpUsers as $user) {
        // if (!in_array($user->id, $normalUser)) {
        //     echo $user->id . 'not exist in our database';
        //     echo "\n";
        //     echo 'creating new user...';
        //     $newUser = new User();
        //     $newUser->external_user_id = $user->id;
        //     $newUser->role_id = 4;
        //     $newUser->name = $user->name;
        //     $newUser->email = $user->email;
        //     $newUser->password = bcrypt('admin123');
        //     $newUser->no_hp = $user->phone;
        //     $newUser->save();
        //     echo "\n";
        //     echo 'new user created';
        // }
        // if (!User::where('external_user_id', $user->id)->exists() && !User::where('email', $user->email)->exists() && !User::where('no_hp', $user->phone)->exists()) {
        //     echo $user->id . 'not exist in our database';
        //     echo "\n";
        //     echo 'creating new user...';
        //     $newUser = new User();
        //     $newUser->external_user_id = $user->id;
        //     $newUser->role_id = 4;
        //     $newUser->name = $user->name;
        //     $newUser->email = $user->email;
        //     $newUser->password = bcrypt('admin123');
        //     $newUser->no_hp = $user->phone;
        //     $newUser->save();
        //     echo "\n";
        //     echo 'new user created';
        // }
        //}

        // $erpUsers = $odoo->model('res.users')->fields(['id', 'name', 'email', 'phone'])->get();
        // $currentUsers = User::all();
        // $newUserList = [];
        // // Loop through chunks of 1000 users
        // foreach (array_chunk($erpUsers, 1000) as $chunk) {
        //     foreach ($chunk as $user) {
        //         echo $user->id . 'filtering...';
        //         if (!$currentUsers->contains('external_user_id', $user->id) && !collect($newUserList)->contains('external_user_id', $user->id)) {
        //             array_push(
        //                 $newUserList,
        //                 [
        //                     'external_user_id' => $user->id,
        //                     'role_id' => 4,
        //                     'name' => $user->name,
        //                     'email' => $user->email,
        //                     'password' => Hash::make('admin123'),
        //                     'no_hp' => $user->phone,
        //                 ]
        //             );
        //         }
        //     }
        // }

        // if (!empty($newUserList)) {
        //     DB::table('users')->insert($newUserList);
        //     $allDataQty = count($erpUsers);
        //     echo "updated: $allDataQty Data ";
        //     return 'success';
        // }
    }
}
