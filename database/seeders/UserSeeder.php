<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::where('email', 'admin@testemail.com')->first();

        if(empty($user)){
            $user = new \App\Models\User();
            $user->name = 'Super Admin';
            $user->email = 'admin@testemail.com';
            $user->password = 'test@123';
            $user->email_verified_at = \Carbon\Carbon::now();
        } else {
            $user->password = 'test@123';
        }

        $user->save();
    }

    public function register(UserSignupRequest $request)
    {
        $inputs = $request->all();

        \DB::beginTransaction();
    
        $user = $this->model->createUser($inputs);

        \DB::commit();
        return response()->json($user);
    }
}
