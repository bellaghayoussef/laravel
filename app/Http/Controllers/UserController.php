<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->getValidator($request);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all());
            }

            $data = $this->getData($request);

            $user = User::create($data);

            return response()->json(['user' => $user], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 401);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
                $user = User::findOrFail($id);
                return response()->json(['user' => $user], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try {
            $validator = $this->getValidator($request);


            if ($validator->fails()) {
                return response()->json(['error' => $validator->getMessageBag()], 401);
            }

            $data = $this->getData($request);

            $user = User::findOrFail($id);

            $user->update($data);

            return response()->json(['user' => $user], 200);
        } catch (Exception $exception) {
            return response()->json(['error' =>  $exception->getMessage()], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response("", 204);
    }
    protected function getValidator(Request $request)
    {
        $rules = [
            'email' => 'required|string|min:1|max:255',
            'email_verified_at' => 'nullable|date_format:j/n/Y g:i A',
            'first_name' => 'required|string|min:1|max:255',
            'last_name' => 'required|string|min:1|max:255',
            'password' => 'required|string|min:1|max:255',
            'remember_token' => 'nullable|string|min:0|max:100',
        ];

        return Validator::make($request->all(), $rules);
    }
    protected function getData(Request $request)
    {
        $rules = [
                'email' => 'required|string|min:1|max:255',
            'email_verified_at' => 'nullable|date_format:j/n/Y g:i A',
            'first_name' => 'required|string|min:1|max:255',
            'last_name' => 'required|string|min:1|max:255',
            'password' => 'required|string|min:1|max:255',
            'remember_token' => 'nullable|string|min:0|max:100',
        ];


        $data = $request->validate($rules);




        return $data;
    }

    /**
     * Transform the giving user to public friendly array
     *
     * @param App\Models\User $user
     *
     * @return array
     */
    protected function transform(User $user)
    {
        return [
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'first_name' => $user->first_name,
            'id' => $user->id,
            'last_name' => $user->last_name,
            'password' => $user->password,
            'remember_token' => $user->remember_token,
        ];
    }
}
