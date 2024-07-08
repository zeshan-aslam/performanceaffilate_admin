<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Activity;
use App\Utilities\SiteHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:superadministrator');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $merchants = DB::table('partners_merchant')->select([
            'brands'
        ])->where(['merchant_status' => 'approved'])->get();

        $new = [];
        $unique_brands = [];
        foreach ($merchants as $merchant) {
            $low = strtoupper($merchant->brands);
            trim($low);
            $newArray = explode('|', $low);
            $new = array_merge($new, $newArray);
        }
        $unique_brands = array_unique($new, SORT_REGULAR);

        return view('admin.home', compact('unique_brands'));
    }

    public function totalkeywords()
    {
        return view('admin.totalkeywords');
    }
    
    function getTotalKeywords(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
    
            if($query !== '') {
    
                $data = DB::table('cons_mer_brands')->select([
                            'cons_mer_brands.cons_mer_id', 'cons_mer_brands.cons_brand_name', 'partners_merchant.merchant_company'
                        ])
                            ->join('partners_merchant', 'partners_merchant.merchant_id', '=', 'cons_mer_brands.cons_mer_id')
                            ->where(['partners_merchant.merchant_status' => 'approved'])
                            ->when($request->get('query'), function($query) use($request) { 
                                $query->Where('cons_mer_brands.cons_brand_name', 'like', '%' . $request->get('query') . '%');
                            })->get();
                    
            } else {
                $data = DB::table('cons_mer_brands')->select([
                            'cons_mer_brands.cons_mer_id', 'cons_mer_brands.cons_brand_name', 'partners_merchant.merchant_company'
                        ])
                            ->join('partners_merchant', 'partners_merchant.merchant_id', '=', 'cons_mer_brands.cons_mer_id')
                            ->where(['partners_merchant.merchant_status' => 'approved'])->get();
            }
    
            $total_row = $data->count();
            
            if($total_row > 0){
                foreach($data as $row)
                {
                    $output .= '
                    <tr>
                    <td><span class="font-weight-light text-primary">'.$row->cons_brand_name.'</span><b class="font-weight-light text-dark"> ( '.$row->merchant_company.' )</b></td>
                    </tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }
    


    // public function totalkeywords()
    // {
    //     $merchants = DB::table('partners_merchant')->select([
    //         'brands'
    //     ])->where(['merchant_status' => 'approved'])->get();

    //     $new_merchants = DB::table('cons_mer_brands')->select([
    //         'cons_mer_brands.cons_mer_id', 'cons_mer_brands.cons_brand_name', 'partners_merchant.merchant_company'
    //     ])
    //         ->join('partners_merchant', 'partners_merchant.merchant_id', '=', 'cons_mer_brands.cons_mer_id')
    //         ->where(['partners_merchant.merchant_status' => 'approved'])->orderBy('cons_mer_id')->get()->chunk(20);




    //     $new = [];
    //     $unique_brands = [];
    //     foreach ($merchants as $merchant) {
    //         $low = strtoupper($merchant->brands);
    //         trim($low);
    //         $newArray = explode('|', $low);
    //         $new = array_merge($new, $newArray);
    //     }
    //     $unique_brands = array_unique($new, SORT_REGULAR);
    //     return view('admin.totalkeywords', compact('merchants', 'unique_brands', 'new_merchants'));
    // }


    // public function getTotalKeywords()
    // {
    //     $merchants = DB::table('cons_mer_brands')->select([
    //         'cons_mer_brands.cons_mer_id', 'cons_mer_brands.cons_brand_name', 'partners_merchant.merchant_company'
    //     ])
    //         ->join('partners_merchant', 'partners_merchant.merchant_id', '=', 'cons_mer_brands.cons_mer_id')
    //         ->where(['partners_merchant.merchant_status' => 'approved'])->get();

    //     // dd($result);
    //     return response()->json([
    //         'message' => 'Data Found',
    //         'code' => '200',
    //         'data' => $merchants

    //     ]);
    // }
    public function users()
    {
        $roles = Role::all();
        return view('admin.user.index', compact('roles'));
    }
    public function getUsers()
    {
        $data = DB::table('users', 'U')
            ->join('role_user as RU', 'U.id', '=', 'RU.user_id')
            ->join('roles as R', 'RU.role_id', '=', 'R.id')
            ->select('U.*', 'R.name', 'R.id as RoleId')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function showUser(Request $request)
    {
        session(['id', $request->user_id]);
        $data = DB::table('users')
            ->join('role_user as RU', function ($join) {
                $join->on('users.id', '=', 'RU.user_id')
                    ->where('RU.user_id', '=', session('id'));
            })
            ->join('roles as R', 'RU.role_id', '=', 'R.id')
            ->select('U.*', 'R.*')
            ->get();


        return response()->json($data);
    }
    public function addUser(Request $request)
    {
        $check = DB::table('users')
            ->where('username', '=', $request->username)
            ->orWhere('email', '=', $request->email)
            ->exists();
        if (Auth::check() &&  !$check) {
            $id = DB::table('users')
                ->insertGetId([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'ip' => $request->ip(),
                    'lastlogin' => date("Y-m-d h:i:s", time()),
                    'created_at' => date("Y-m-d h:i:s", time()),
                    'mailheader' => 'Default Header',
                    'mailfooter' => 'Default Footer',

                ]);
            $res = DB::table('role_user')
                ->insert([
                    'user_id' => $id,
                    'role_id' => $request->role,
                    'user_type' => 'App\User'

                ]);
            $activity = new Activity();
            $activity->url = url()->current();
            $activity->ip = SiteHelper::getIp();
            $activity->user_id = Auth::id();
            $activity->type = "Admin";
            $activity->country = '';
            $activity->description = 'User Added';
            $activity->save();
            return response()->json($res);
        } else {
            $res = 'exists';
            return response()->json($res);
        }
    }

    public function updateUser(Request $request)
    {

        $checkUsername = DB::table('users')
            ->where('username', '=', $request->username)
            ->where('id', '!=', $request->id)
            ->exists();
        $checkEmail = DB::table('users')
            ->where(
                'email',
                '=',
                $request->email,

            )
            ->where(
                'id',
                '!=',
                $request->id
            )
            ->exists();
        if (Auth::check() &&  $checkUsername) {
            $res = 'username';
            return response()->json($res);
        } elseif (Auth::check() && $checkEmail) {
            $res = 'email';
            return response()->json($res);
        } elseif (Auth::check() &&  !$checkUsername && !$checkEmail) {
            $res = array();
            $res[] = DB::table('users')
                ->where('id', $request->id)
                ->limit(1)
                ->update([
                    'username' => $request->username,
                    'email' => $request->email,
                    'updated_at' => date("Y-m-d h:i:s", time()),
                ]);
            $res[] = DB::table('role_user')
                ->where('user_id', $request->id)
                ->limit(1)
                ->update([
                    'role_id' => $request->RoleId,
                ]);
            if (in_array(1, $res)) {
                $ret = 1;
                $activity = new Activity();
                $activity->url = url()->current();
                $activity->ip = SiteHelper::getIp();
                $activity->user_id = Auth::id();
                $activity->type = "Admin";
                $activity->country = '';
                $activity->description = $request->username . ' Updated';
                $activity->save();
                return response()->json($ret);
            } else {
                $ret = 0;
                return response()->json($ret);
            }
        } else {
            $res = 2;
            return response()->json($res);
        }
    }
    public function deleteUser(Request $request)
    {
        $user = array();

        $userData = User::find($request->id);
        $activity = new Activity();
        $activity->url = url()->current();
        $activity->ip = SiteHelper::getIp();
        $activity->user_id = Auth::id();
        $activity->type = "Admin";
        $activity->country = '';
        $activity->description = $userData->username . ' Deleted';
        $activity->save();
        $user[] = DB::table('users')
            ->where('id', $request->id)
            ->delete();
        $user[] = DB::table('role_user')
            ->where('user_id', $request->id)
            ->delete();
        return response()->json($user);
    }
}
