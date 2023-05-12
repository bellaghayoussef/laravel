<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class RolesController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::all();



        return response()->json(['roles' => $roles], 200);
    }

    /**
     * Store a new role in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->getValidator($request);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all());
            }

            $data = $this->getData($request);

            $role = Role::create($data);

            return $this->successResponse(
			    'Role was successfully added.',
			    $this->transform($role)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Display the specified role.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        return $this->successResponse(
		    'Role was successfully retrieved.',
		    $this->transform($role)
		);
    }

    /**
     * Update the specified role in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        try {
            $validator = $this->getValidator($request);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all());
            }

            $data = $this->getData($request);

            $role = Role::findOrFail($id);
            $role->update($data);

            return $this->successResponse(
			    'Role was successfully updated.',
			    $this->transform($role)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified role from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return $this->successResponse(
			    'Role was successfully deleted.',
			    $this->transform($role)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Gets a new validator instance with the defined rules.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Support\Facades\Validator
     */
    protected function getValidator(Request $request)
    {
        $rules = [
            'guard_name' => 'required|string|min:1|max:255',
            'name' => 'required|string|min:1|max:255',
        ];

        return Validator::make($request->all(), $rules);
    }


    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
                'guard_name' => 'required|string|min:1|max:255',
            'name' => 'required|string|min:1|max:255',
        ];


        $data = $request->validate($rules);




        return $data;
    }

    /**
     * Transform the giving role to public friendly array
     *
     * @param App\Models\role $role
     *
     * @return array
     */
    protected function transform(role $role)
    {
        return [
            'guard_name' => $role->guard_name,
            'id' => $role->id,
            'name' => $role->name,
        ];
    }


}
