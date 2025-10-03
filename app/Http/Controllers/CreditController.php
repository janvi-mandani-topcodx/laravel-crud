<?php

namespace App\Http\Controllers;

use App\Models\CreditLog;
use App\Models\User;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $user = User::where('id' , $input['user_id'])->first();
        if($user->credits != null){
            $credit = CreditLog::create([
                'user_id' => $input['user_id'],
                'description' => $input['description'],
                'previews_balance' => $user->credits,
                'new_balance' => $input['credit_amount'],
            ]);
            $user->credits = $user->credits + $input['credit_amount'];
            $user->save();
        }
        else{
            $credit = CreditLog::create([
                'user_id' => $input['user_id'],
                'description' => $input['description'],
                'previews_balance' => 0,
                'new_balance' => $input['credit_amount'],
            ]);
            $userCredit = $credit->user;
            $userCredit->credits  = $input['credit_amount'];
            $userCredit->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
