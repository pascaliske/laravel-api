<?php

namespace App\Api\Controllers;

use App\Api\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class UserController extends Controller
{
    use Helpers;

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchAll()
    {
        return User::all();
    }

    /**
     * Create a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        User::create([
            'email' => $request->email,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
            'activated' => $request->activated ? true : false,
            'confirmed' => $request->confirmed ? true : false,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->updateModel(User::findOrFail($id), [
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => $request->password,
            'activated' => $request->activated,
            'confirmed' => $request->confirmed,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        User::findOrFail($id)->delete();
    }
}
