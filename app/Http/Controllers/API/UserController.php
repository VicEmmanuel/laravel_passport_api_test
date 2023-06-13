<?php
namespace App\Http\Controllers\API;

// use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

     /**
     * Registration Req
     */
    // public function register(Request $request)
    // {
    //     $this->validate($request, [
    //         'name' => 'required|min:4',
    //         'email' => 'required|email',
    //         'password' => 'required|min:8',
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password)
    //     ]);

    //     $token = $user->createToken('Laravel8PassportAuth')->accessToken;

    //     return response()->json(['token' => $token], 200);
    // }

    // /**
    //  * Login Req
    //  */
    // public function login(Request $request)
    // {
    //     $data = [
    //         'email' => $request->email,
    //         'password' => $request->password
    //     ];

    //     if (auth()->attempt($data)) {
    //         $token = auth()->user()->createToken('Laravel8PassportAuth')->accessToken;
    //         return response()->json(['token' => $token], 200);
    //     } else {
    //         return response()->json(['error' => 'Unauthorised'], 401);
    //     }
    // }

    // public function userInfo()
    // {

    //  $user = auth()->user();

    //  return response()->json(['user' => $user], 200);

    // }
    public function register(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|min:8',
    ]);

    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);

    // Generate and assign a personal access token to the user
    $token = $user->createToken('authToken')->accessToken;

    return response()->json(['token' => $token], 201);
}


// public function userLogin(Request $request)
// {
//     $credentials = $request->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//     ]);

//     if (Auth::attempt($credentials)) {
//         $user = Auth::user();
//         $token = $user->createToken('authToken')->accessToken;

//         return response()->json(['token' => $token], 200);
//     } else {
//         return response()->json(['message' => 'Invalid credentials'], 401);
//     }
// }
    public function userLogin(Request $request)
    {
        $input = $request->all();
        $vallidation = Validator::make($input,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($vallidation->fails()){
            return response()->json(['error' => $vallidation->errors()],422);
        }


        if (Auth::attempt(['email' => $input['email'],'password' => $input['password']])) {
            $user  = Auth::user();
            // dd($user);

            $token = $user->createToken('authToken')->accessToken;

            return response()->json(['token' => $token]);
        }

    }



    public function userDetails()
    {
        $user = Auth::guard('api')->user();

        return response()->json(['data' => $user]);
    }
}
