<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\UserDevice;
use Auth;
use Illuminate\Http\Request;
use Validator;

class UserTokenController extends Controller
{

    /**
     * @var
     */

    public function __construct()
    {
    }

    public function userToken(Request $request)
    {
        $users = Auth::user();
        try {

            $hash = $users->email . $users->phone . $users->roles_id . date('H');

            $validator = Validator::make($request->all(), [
                'token'     => 'required',
                'device'    => 'required',
                'code'      => 'required',
            ]);

            if($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 404);
            }
            // if(password_verify($hash, $request->code)) {
            //     return response()->json(['status' => false, 'message' => 'code is not valid'], 404);
            // } 

            $device = UserDevice::where('token', $request->token)->count();
            if($device < 1){
                $device = UserDevice::create(['user_id' => $users->id,
                                              'token' => $request->input('token'),
                                              'device' => $request->input('device')]);
            }

            return response()->json([
                'message' => 'Device success creaeted',
                'data' => $device
            ], 200);

        } catch (ValidatorException $e) {
            return response()->json($e);
        }

    }

}
