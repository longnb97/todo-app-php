<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use App\Helpers\ResponseService;
use App\Account as AccountModel;
// use App\Helpers;

class AccountController extends Controller
{
    public function createAccount(Request $request)
    {
        $user =  [
            'email' => $request->email, 
            'password' => bcrypt($request->password),
            'token' => null,
            'name' => $request->name,
            'job' => $request->job,
            'company' => $request->company,
        ];
        // //$token = JWTAuth::($user);
        // //$user['token'] = $token;

        try {
            $data = AccountModel::createAccount($user);
            return ResponseService::response(1, 'account created', 201, $data);
        } catch (QueryException $ex) {
            return ResponseService::response(0, 'error', 500, null, $ex);
        }
    }

    public function getAllAccounts(Request $request)
    {
        try {
            $data = AccountModel::getAll();
            if ($data->isEmpty()) {
                return ResponseService::response(0, 'accounts not found', 404, $data);
            } else {
                return ResponseService::response(1, 'accounts found', 200, $data);
            }
        } catch (QueryException $ex) {
            return ResponseService::response(0, 'error', 500, null, $ex);
        }
    }

    public function getAccountById(Request $request, $id)
    {
        try {
            $data = AccountModel::getById($id);
            if ($data->isEmpty()) {
                return ResponseService::response(0, 'account not found', 404, $data);
            } else {
                return ResponseService::response(1, 'account found', 200, $data);
            }
        } catch (QueryException $ex) {
            return ResponseService::response(0, 'error', 500, [], $ex);
        }
    }

    public function deleteAccountById(Request $request, $id)
    {
        try {
            $data = AccountModel::getById($id);
            if ($data->isEmpty()) {
                 return ResponseService::response(0, 'account not found', 404, $data);
            } else {
                $deleteQuery = AccountModel::deleteAccount($id);
                return ResponseService::response(1, 'deleted', 200);
            }
        } catch (QueryException $ex) {
            return ResponseService::response(0, 'error', 500, [], $ex);
        }
    }

    public function changePassword(Request $request, $id)
    { }
}
