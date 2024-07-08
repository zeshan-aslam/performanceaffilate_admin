<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadministrator']);
    }





    public function index()
    {
        $programs = DB::table('partners_program')
            ->get();



        return view('program.index', compact('programs'));
    }

    public function getAffiliates(Request $request)
    {
        $programId = $request->programId;
        $totalAffiliates = DB::table('partners_joinpgm', 'J')
            ->join('partners_program as P', function ($join) use ($programId) {
                $join->on('J.joinpgm_programid', '=', 'P.program_id')
                    ->where('J.joinpgm_programid', '=', $programId)
                    ->where('J.joinpgm_status', '<>', 'waiting');
            })
            ->join('partners_affiliate as A', 'J.joinpgm_affiliateid', '=', 'A.affiliate_id')
            ->join('partners_pgm_commission as C', function ($join) use ($programId) {
                $join->on('P.program_id', '=', 'C.commission_programid')
                    ->where('C.commission_programid', '=', $programId);
            })

            ->get();

        return response()->json($totalAffiliates);
    }

    public function getProgramDetails($id)
    {
        $advLinks = array();

        $allAffiliates = DB::table('partners_joinpgm', 'j')

            ->join('partners_affiliate as a', 'j.joinpgm_affiliateid', '=', 'a.affiliate_id')
            ->select('a.*', 'j.*')
            ->where('j.joinpgm_status', '<>', 'waiting')
            ->first();


        $allPrograms = DB::table('partners_program')
            ->get();

        $programs = DB::table('partners_program')
            ->where(['program_id' => $id])
            ->first();
        session(['Pid' => $id]);

        $products = DB::table('partners_product')
            ->where(['prd_programid' => $id])
            ->get();




        $merchants = DB::table('partners_merchant', 'M')
            ->join('partners_program as P', function ($join) {
                $join->on('M.merchant_id', '=', 'P.program_merchantid')
                    ->where('P.program_merchantid', '=', session('Pid'));
            })
            ->get();

        $pgm = DB::table('partners_joinpgm', 'J')
            ->join('partners_program as P', function ($join) {
                $join->on('J.joinpgm_programid', '=', 'P.program_id')
                    ->where('J.joinpgm_programid', '=', session('Pid'));
            })
            ->get();

        $comission = DB::table('partners_pgm_commission', 'C')
            ->join('partners_program as P', function ($join) {
                $join->on('C.commission_programid', '=', 'P.program_id')
                    ->where('C.commission_programid', '=', session('Pid'));
            })
            ->orderBy('commission_id')
            ->first();

        $totalAffiliates = DB::table('partners_joinpgm', 'J')
            ->join('partners_program as P', function ($join) {
                $join->on('J.joinpgm_programid', '=', 'P.program_id')
                    ->where('J.joinpgm_programid', '=', session('Pid'))
                    ->where('J.joinpgm_status', '<>', 'waiting');
            })

            ->count();

        $advLinks['banner'] = DB::table('partners_banner', 'B')
            ->join('partners_program as P', function ($join) {
                $join->on('B.banner_programid', '=', 'P.program_id')
                    ->where('B.banner_programid', '=', session('Pid'));
            })->count();

        $advLinks['popup'] = DB::table('partners_popup', 'Po')
            ->join('partners_program as P', function ($join) {
                $join->on('Po.popup_programid', '=', 'P.program_id')
                    ->where('Po.popup_programid', '=', session('Pid'));
            })
            ->count();

        $advLinks['flash'] = DB::table('partners_flash', 'F')
            ->join('partners_program as P', function ($join) {
                $join->on('F.flash_programid', '=', 'P.program_id')
                    ->where('F.flash_programid', '=', session('Pid'));
            })
            ->count();

        $advLinks['html'] = DB::table('partners_html', 'h')
            ->join('partners_program as P', function ($join) {
                $join->on('h.html_programid', '=', 'P.program_id')
                    ->where('h.html_programid', '=', session('Pid'));
            })
            ->count();

        $advLinks['text'] = DB::table('partners_text', 'T')
            ->join('partners_program as P', function ($join) {
                $join->on('T.text_programid', '=', 'P.program_id')
                    ->where('T.text_programid', '=', session('Pid'));
            })
            ->count();

        $advLinks['text_old'] = DB::table('partners_text_old', 'TO')
            ->join('partners_program as P', function ($join) {
                $join->on('TO.text_programid', '=', 'P.program_id')
                    ->where('TO.text_programid', '=', session('Pid'));
            })
            ->count();

        $Pid = $id;
        return view('program.program', compact('products', 'allAffiliates', 'Pid', 'allPrograms', 'programs', 'comission', 'pgm', 'totalAffiliates', 'merchants', 'advLinks'));


        //Function Ends

    }
    public function updateFee(Request $request, $id)
    {
        // $validatedData = $request->validate([
        //     'programValue' => 'required|max:15|string',
        //     'programPeriod' => 'required|max:15|string',
        //     'programFee' => 'required|max:15|string',


        // ]);

        try {
            $programValue = $request->programValue . " " . $request->programPeriod;

            $data = DB::table('partners_program')
                ->where(['program_id' => $id])
                ->limit(1)
                ->update(['program_fee' => $request->programFee, 'program_value' => $programValue, 'program_type' => $request->programType]);

            return $data;
        } catch (Exception $e) {


            return 'Error : ' . $e->getCode();
        }
    }
    public function changeProgramStatus($id)
    {

        $data = DB::table('partners_program')
            ->where(['program_status' => 'active', 'program_id' => $id])
            ->exists();
        if ($data) {
            DB::table('partners_program')
                ->where(['program_id' => $id])
                ->limit(1)
                ->update(array('program_status' => 'inactive'));
        } else {
            DB::table('partners_program')
                ->where(['program_id' => $id])
                ->limit(1)
                ->update(array('program_status' => 'active'));
        }
        return redirect()->route('Program.getProgramDetails', $id);
    }

    public function updateAdminPayments(Request $request, $id)
    {
        //     $validatedData = $request->validate([
        //         'programAdminImpression' => 'required|max:15|string',
        //         'programAdminClick' => 'required|max:15|string',
        //         'programAdminClickType' => 'required|max:15',
        //         'programAdminLead' => 'required|max:15|string',
        //         'programAdminLeadType' => 'required|max:15',
        //         'programAdminSale' => 'required|max:15|string',
        //         'programAdminSaleType' => 'required|max:15',

        //     ]);

        try {
            $data = DB::table('partners_program')
                ->where(['program_id' => $id])
                ->limit(1)
                ->update([
                    'program_admin_impr' => $request->programAdminImpression,
                    'program_admin_click' => $request->programAdminClick,
                    'program_admin_clicktype' => $request->programAdminClickType,
                    'program_admin_lead' => $request->programAdminLead,
                    'program_admin_leadtype' => $request->programAdminLeadType,
                    'program_admin_sale' => $request->programAdminSale,
                    'program_admin_saletype' => $request->programAdminSaleType,
                    'program_admin_default' => '0',
                ]);



            return $data;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateComission(Request $request, $id)
    {
        if ($request->mode == "set") {
            $data = DB::table('partners_joinpgm')
                ->where([
                    'joinpgm_affiliateid' => $request->comissionAffiliateId,
                    'joinpgm_programid' => $request->comissionProgramId,
                ])
                ->limit(1)
                ->update([
                    'joinpgm_commissionid' => $request->commissionComissionId,

                ]);
        }
        if ($request->mode == "remove") {
            $data = DB::table('partners_joinpgm')
                ->where([
                    'joinpgm_affiliateid' => $request->comissionAffiliateId,
                    'joinpgm_programid' => $request->comissionProgramId,
                ])
                ->limit(1)
                ->update([
                    'joinpgm_commissionid' => 0,

                ]);
        }

        if ($data == 1) {
            return redirect()->route('Program.getProgramDetails', $id)->with('success', 'Comission Updated Successfully');
        } elseif ($data == 0) {
            return redirect()->route('Program.getProgramDetails', $id)->with('success', 'Already Assigned Default');
        } else {

            return redirect()->route('Program.getProgramDetails', $id)->with('danger', 'Error in Updating Comission');
        }
    }
    public function text($id, $status)
    {
        return view('program.text', compact('id', 'status'));
    }
    public function tamplateText($id, $status)
    {
        return view('program.tamplateText', compact('id', 'status'));
    }
    public function html($id, $status)
    {
        return view('program.html', compact('id', 'status'));
    }
    public function popup($id, $status)
    {
        return view('program.popup', compact('id', 'status'));
    }
    public function banner($id, $status)
    {
        return view('program.banner', compact('id', 'status'));
    }
    public function flash($id, $status)
    {
        return view('program.flash', compact('id', 'status'));
    }
    public function product($id, $status)
    {
        return view('program.product', compact('id', 'status'));
    }
    public function getTextLinks($id, $status)
    {
        if ($status == 'active') {
            $data = DB::table('partners_text_old')
                ->where('text_programid', '=', $id)
                ->where('text_status', '=', 'active')
                ->get();
        } elseif ($status == 'inactive') {
            $data = DB::table('partners_text_old')
                ->where('text_programid', '=', $id)
                ->where('text_status', '=', 'inactive')
                ->get();
        } else {
            $data = DB::table('partners_text_old')
                ->where('text_programid', '=', $id)
                ->get();
        }

        return response()->json(['data' => $data]);
    }
    public function GetTempTextLinks($id, $status)
    {
        if ($status == 'active') {
            $data = DB::table('partners_text')
                ->where('text_programid', '=', $id)
                ->where('text_status', '=', 'active')
                ->get();
        } else if ($status == 'inactive') {
            $data = DB::table('partners_text')
                ->where('text_programid', '=', $id)
                ->where('text_status', '=', 'inactive')
                ->get();
        } else {
            $data = DB::table('partners_text')
                ->where('text_programid', '=', $id)
                ->get();
        }


        return response()->json(['data' => $data]);
    }
    public function getHTMLLinks($id, $status)
    {
        if ($status == 'active') {
            $data = DB::table('partners_html')
                ->where('html_programid', '=', $id)
                ->where('html_status', '=', 'active')
                ->get();
        } elseif ($status == 'inactive') {
            $data = DB::table('partners_html')
                ->where('html_programid', '=', $id)
                ->where('html_status', '=', 'inactive')
                ->get();
        } else {
            $data = DB::table('partners_html')
                ->where('html_programid', '=', $id)
                ->get();
        }

        return response()->json(['data' => $data]);
    }
    public function getPopupLinks($id, $status)
    {
        if ($status == 'active') {
            $data = DB::table('partners_popup')
                ->where('popup_programid', '=', $id)
                ->where('popup_status', '=', 'active')
                ->get();
        } elseif ($status == 'inactive') {
            $data = DB::table('partners_popup')
                ->where('popup_programid', '=', $id)
                ->where('popup_status', '=', 'inactive')
                ->get();
        } else {
            $data = DB::table('partners_popup')
                ->where('popup_programid', '=', $id)
                ->get();
        }

        return response()->json(['data' => $data]);
    }
    public function getBannerLinks($id, $status)
    {
        if ($status == 'active') {
            $data = DB::table('partners_banner')
                ->where('banner_programid', '=', $id)
                ->where('banner_status', '=', 'active')
                ->get();
        } elseif ($status == 'inactive') {
            $data = DB::table('partners_banner')
                ->where('banner_programid', '=', $id)
                ->where('banner_status', '=', 'inactive')
                ->get();
        } else {
            $data = DB::table('partners_banner')
                ->where('banner_programid', '=', $id)
                ->get();
        }

        return response()->json(['data' => $data]);
    }
    public function getFlashLinks($id, $status)
    {
        if ($status == 'active') {
            $data = DB::table('partners_flash')
                ->where('flash_programid', '=', $id)
                ->where('flash_status', '=', 'active')
                ->get();
        } elseif ($status == 'inactive') {
            $data = DB::table('partners_flash')
                ->where('flash_programid', '=', $id)
                ->where('flash_status', '=', 'inactive')
                ->get();
        } else {
            $data = DB::table('partners_flash')
                ->where('flash_programid', '=', $id)
                ->get();
        }


        return response()->json(['data' => $data]);
    }
    public function getProductLinks($id, $status)
    {
        if ($status == 'active') {
            $data = DB::table('partners_product')
                ->where('prd_programid', '=', $id)
                ->where('prd_status', '=', 'active')
                ->get();
        } elseif ($status == 'inactive') {
            $data = DB::table('partners_product')
                ->where('prd_programid', '=', $id)
                ->where('prd_status', '=', 'inactive')
                ->get();
        } else {
            $data = DB::table('partners_product')
                ->where('prd_programid', '=', $id)
                ->get();
        }

        return response()->json(['data' => $data]);
    }
    public function approveLink(Request $request)
    {


        $table = $request->Table;
        if ($table == 'partners_text_old') {
            $data = DB::table('partners_text_old')
                ->where('text_id', '=', $request->id)
                ->update([
                    'text_status' => 'active',
                ]);
        } elseif ($table == 'partners_text') {
            $data = DB::table('partners_text')
                ->where('text_id', '=', $request->id)
                ->update([
                    'text_status' => 'active',
                ]);
        } elseif ($table == 'partners_popup') {
            $data = DB::table('partners_popup')
                ->where('popup_id', '=', $request->id)
                ->update([
                    'popup_status' => 'active',
                ]);
        } elseif ($table == 'partners_flash') {
            $data = DB::table('partners_flash')
                ->where('flash_id', '=', $request->id)
                ->update([
                    'flash_status' => 'active',
                ]);
        } elseif ($table == 'partners_html') {
            $data = DB::table('partners_html')
                ->where('html_id', '=', $request->id)
                ->update([
                    'html_status' => 'active',
                ]);
        } elseif ($table == 'partners_banner') {
            $data = DB::table('partners_banner')
                ->where('banner_id', '=', $request->id)
                ->update([
                    'banner_status' => 'active',
                ]);
        } elseif ($table == 'partners_product') {
            $data = DB::table('partners_product')
                ->where('prd_id', '=', $request->id)
                ->update([
                    'prd_status' => 'active',
                ]);
        }

        return response()->json($data);
    }
    public function rejectLink(Request $request)
    {
        $table = $request->Table;
        if ($table == 'partners_text_old') {
            $data = DB::table('partners_text_old')
                ->where('text_id', '=', $request->id)
                ->update([
                    'text_status' => 'inactive',
                ]);
        } elseif ($table == 'partners_text') {
            $data = DB::table('partners_text')
                ->where('text_id', '=', $request->id)
                ->update([
                    'text_status' => 'inactive',
                ]);
        } elseif ($table == 'partners_popup') {
            $data = DB::table('partners_popup')
                ->where('popup_id', '=', $request->id)
                ->update([
                    'popup_status' => 'inactive',
                ]);
        } elseif ($table == 'partners_flash') {
            $data = DB::table('partners_flash')
                ->where('flash_id', '=', $request->id)
                ->update([
                    'flash_status' => 'inactive',
                ]);
        } elseif ($table == 'partners_html') {
            $data = DB::table('partners_html')
                ->where('html_id', '=', $request->id)
                ->update([
                    'html_status' => 'inactive',
                ]);
        } elseif ($table == 'partners_banner') {
            $data = DB::table('partners_banner')
                ->where('banner_id', '=', $request->id)
                ->update([
                    'banner_status' => 'inactive',
                ]);
        } elseif ($table == 'partners_product') {
            $data = DB::table('partners_product')
                ->where('prd_id', '=', $request->id)
                ->update([
                    'prd_status' => 'inactive',
                ]);
        }
        return response()->json($data);
    }
}
