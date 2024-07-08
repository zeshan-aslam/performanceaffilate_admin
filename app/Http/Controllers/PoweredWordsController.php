<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Activity;
use App\Models\PartnersKeyword;
use App\Utilities\SiteHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PoweredWordsController extends Controller
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
        $categories = DB::table('partners_category')->get();

        return view('admin.home', compact('categories'));
    }

 

    public function words()
    {
        $categories = DB::table('partners_category')->get();
        return view('poweredwords.words.index', compact('categories'));
    }
    
    public function getKeywords()
    {
        $data = DB::table('partners_keywords', 'K')
        ->leftJoin('partners_category as C', 'K.categoryid', '=', 'C.cat_id')
            ->select('K.*', 'C.cat_name as categoryname')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function showUser(Request $request)
    {
        session(['id', $request->user_id]);
        $data = DB::table('partners_keywords')
            ->join('role_user as RU', function ($join) {
                $join->on('users.id', '=', 'RU.user_id')
                    ->where('RU.user_id', '=', session('id'));
            })
            ->join('roles as R', 'RU.role_id', '=', 'R.id')
            ->select('U.*', 'R.*')
            ->get();


        return response()->json($data);
    }
    public function addKeyword(Request $request)
    {
        $check = DB::table('partners_keywords')
            ->where('keyword', '=', $request->keyword)
            ->where('categoryid', '=', $request->category)
            ->exists();
        if (Auth::check() &&  !$check) {
            $id = DB::table('partners_keywords')
                ->insertGetId([
                    'keyword' => $request->keyword,   
                    'categoryid' => $request->category,
                    'status' => 1,                
                    'updatedate' => date("Y-m-d h:i:s", time()),
                ]);

            $activity = new Activity();
            $activity->url = url()->current();
            $activity->ip = SiteHelper::getIp();
            $activity->user_id = Auth::id();
            $activity->type = "Admin";
            $activity->country = '';
            $activity->description = 'Keyword Added';
            $activity->save();
            return response()->json($id);
        } else {
            $res = 'exists';
            return response()->json($res);
        }
    }

    public function updateKeyword(Request $request)
    {

        $checkKeyword = DB::table('partners_keywords')
            ->where('keyword', '=', $request->keyword)
            ->where('categoryid', '=', $request->category)
            ->where('id', '!=', $request->id)
            ->exists();
            
        if (Auth::check() &&  $checkKeyword) {
            $res = 'keyword';
            return response()->json($res);
        } elseif (Auth::check() &&  !$checkKeyword) {
            $res = array();
            $res[] = DB::table('partners_keywords')
                ->where('id', $request->id)
                ->limit(1)
                ->update([
                    'keyword' => $request->keyword,
                    'categoryid' => $request->category,
                    'updatedate' => date("Y-m-d h:i:s", time()),
                ]);

            if (in_array(1, $res)) {
                $ret = 1;
                $activity = new Activity();
                $activity->url = url()->current();
                $activity->ip = SiteHelper::getIp();
                $activity->user_id = Auth::id();
                $activity->type = "Admin";
                $activity->country = '';
                $activity->description = $request->keyword . ' Updated';
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
    public function deleteKeyword(Request $request)
    {
        $user = array();

        $itemData = PartnersKeyword::find($request->id);
        $activity = new Activity();
        $activity->url = url()->current();
        $activity->ip = SiteHelper::getIp();
        $activity->user_id = Auth::id();
        $activity->type = "Admin";
        $activity->country = '';
        $activity->description = $itemData->keyword . ' Deleted';
        $activity->save();
        
        $data[] = DB::table('partners_keywords')
            ->where('id', $request->id)
            ->delete();

        return response()->json($data);
    }
}
