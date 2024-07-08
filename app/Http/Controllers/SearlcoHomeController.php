<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class SearlcoHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadministrator']);
    }

    /*..................Views Functions......................*/
    public function Title()
    {
        return view('searlcohome.title');
    }
    public function index()
    {
        return view('searlcohome.index');
    }
    public function slides()
    {
        return view('searlcohome.slides');
    }
    public function services()
    {
        return view('searlcohome.services');
    }
    public function ServicesCard()
    {
        return view('searlcohome.servicesCard');
    }
    public function SearlcoNetworkCard()
    {
        return view('searlcohome.searlcoCard');
    }
    public function FeaturesCard()
    {
        return view('searlcohome.featuresCard');
    }
    public function StandardCard()
    {
        return view('searlcohome.standardCard');
    }
    public function TrustedBrandsCard()
    {
        return view('searlcohome.trustedBrandsCard');
    }
    public function Navbar()
    {
        return view('searlcohome.Navbar');
    }
    public function searlcoNetwork()
    {
        return view('searlcohome.searlcoNetwork');
    }
    public function features()
    {
        return view('searlcohome.features');
    }
    public function standard()
    {
        return view('searlcohome.standard');
    }
    public function trustedBrands()
    {
        return view('searlcohome.trustedBrands');
    }
    public function header()
    {
        return view('searlcohome.header');
    }
    public function footer()
    {
        return view('searlcohome.footer');
    }
    public function contact()
    {
        return view('searlcohome.contact');
    }
    /*.................End Views.....................*/

    /*...............Store Functions..................*/
    public function titleStore(Request $request)
    {
      $request->validate([
          'title'=> 'required',
      ]);
      $title =DB::table('site_title')->insert(['title'=>$request->title,'status'=>'suspend']);
      return redirect()->route('searlco.titleView')->with('msg', 'Title is Successfully Added.');
    }
    public function NavbarStore(Request $request)
    {
        $request->validate([
            'img' => 'required',
            'login'  => 'required',
            'signup'  => 'required',
        ]);
        
        $fileNameExt = $request->file('img')->getClientOriginalName();
        $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
        $fileExt =  $request->file('img')->getClientOriginalExtension();
        $fileNameToStore = $fileName . '_' . time() . '.' . $fileExt;
        $uploaded_path =public_path('testimg/');
        $folder1 = $request->file('img')->move($uploaded_path, $fileNameToStore);
        $navbar = DB::table('header_content')->insertGetId([
            "logo" => $fileNameToStore,
            "login" => $request->login,
            "signup" => $request->signup,
            "haeder_status" => 'suspend',
        ]);
        return redirect()->route('searlco.headerView')->with('msg', 'Header Data is Successfully Added.');
    }
    public function MenuStore(Request $request)
    {
        $request->validate([
            'menu' => 'required',
            'Link'  => 'required',
        ]);
        $navbar = DB::table('navbar_content')->insertGetId([
            "menu_name" => $request->menu,
            "href" => $request->Link,
        ]);
        return redirect()->route('searlco.headerView')->with('msg', 'Menu Data is Successfully Added.');
    }
    public function sliderStore(Request $request)
    {
        $request->validate([
            'heading' => 'required',
            'description' => 'required',
            'button1'  => 'required',
            'href1'  => 'required',
            'button2'  => 'required',
            'href2'  => 'required',
        ]);

        $user = DB::table('slider_content')->insertGetId([
            'heading' => $request->heading,
            'description' => $request->description,
            "button1" => $request->button1,	
            "href1" => $request->href1,
            "button2" => $request->button2,
            "href2" => $request->href2,
        ]);
        return redirect()->route('searlco.sliderView')->with('msg', 'Slider Content is Successfully Added.');
    }
    public function servicesStore(Request $request)
    {

        $request->validate([
            'heading' => 'required',
            'des' => 'required',
        ]);
        $services = DB::table('services_content')->insertGetId([
            'heading' => $request->heading,
            'description' => $request->des,
            'services_status' => 'suspend',
        ]);
        return redirect()->route('searlco.servicesView')->with('msg', 'Services Data is Successfully Added.');
    }
    public function servicesCardStore(Request $request)
    {

        $request->validate([
            'img' => 'required',
            'card_heading'  => 'required',
            'card_paragraph'  => 'required',
        ]);
        $fileNameExt = $request->file('img')->getClientOriginalName();
        $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
        $fileExt =  $request->file('img')->getClientOriginalExtension();
        $fileNameToStore = $fileName . '_' . time() . '.' . $fileExt;
        $uploaded_path =public_path('testimg/');
        $folder1 = $request->file('img')->move($uploaded_path, $fileNameToStore);
        $services = DB::table('services_card')->insertGetId([
            "card_icon" => $fileNameToStore,
            "card_heading" => $request->card_heading,
            "card_paragraph" => $request->card_paragraph,
        ]);
        return redirect()->route('searlco.servicesView')->with('msg', 'Services Data is Successfully Added.');
    }
    public function searlcoNetworkStore(Request $request)
    {
        $request->validate([
            'heading' => 'required',
            'description' => 'required',
            'highlight_heading' => 'required',
            'remaining_heading' => 'required',
        ]);

        $network = DB::table('searlco_network_content')->insertGetId([
            'heading' => $request->heading,
            'description' => $request->description,
            'highlight_text' => $request->highlight_heading,
            'remaining_heading' => $request->remaining_heading,
            'network_status' => 'suspend',

        ]);
        return redirect()->route('searlco.searlcoNetworkView')->with('msg', 'Searlco Network Data is Successfully Add.');
    }

    public function searlcoNetworkCardStore(Request $request)
    {
        $request->validate([
            //'img' => 'required',
            'card_heading'  => 'required',
            'card_paragraph'  => 'required',
        ]);

   
        $network = DB::table('searlco_network_card')->insertGetId([
            'heading' => $request->card_heading,
            'description' => $request->card_paragraph,
           // "card_icon" => $fileNameToStore,

        ]);
        return redirect()->route('searlco.searlcoNetworkView')->with('msg', 'Searlco Network Data is Successfully Added.');
    }
    public function featuresStore(Request $request)
    {
        $request->validate([
            'heading' => 'required',
            'Highlight_Heading' => 'required',
            'desc' => 'required',

        ]);
        $features = DB::table('features_content')->insertGetId([
            'heading' => $request->heading,
            'highlight_heading' => $request->Highlight_Heading,
            'description' => $request->desc,
            'features_status' => 'suspend',

        ]);
        return redirect()->route('searlco.featuresView')->with('msg', 'Features Data is Successfully Added.');
    }
    public function featuresCardStore(Request $request)
    {
        $request->validate([
            'card_heading'  => 'required',
            'card_paragraph'  => 'required',
        ]);
        $features = DB::table('features_card')->insertGetId([
            "heading" => $request->card_heading,
            "description" => $request->card_paragraph,
        ]);
        return redirect()->route('searlco.featuresView')->with('msg', 'Features Data is Successfully Added.');
    }

    public function standardStore(Request $request)
    {
        $request->validate([
            'heading1' => 'required',
            'heading2' => 'required',
            'desc' => 'required',
        ]);
        $benefits = DB::table('benefits_content')->insertGetId([
            'highlight_heading' => $request->heading1,
            'remaining_heading' => $request->heading2,
            'description' => $request->desc,
            'benefits_status' => 'suspend',


        ]);
        return redirect()->route('searlco.standardView')->with('msg', 'Standard Contet Data is Successfully Added.');
    }

    public function standardCardStore(Request $request)
    {
        $request->validate([
            'card_heading'  => 'required',
            'card_paragraph'  => 'required',
        ]);
        $benefits = DB::table('benefits_card')->insertGetId([

            "heading" => $request->card_heading,
            "description" => $request->card_paragraph,
        ]);
        return redirect()->route('searlco.standardView')->with('msg', 'Standard Contet Data is Successfully Added.');
    }
    public function trustedStore(Request $request)
    {
        $request->validate([
            'heading' => 'required',
            'desc' => 'required',
        ]);

        $trustedBrands = DB::table('trusted_brands_content')->insertGetId([
            'heading' => $request->heading,
            'description' => $request->desc,
            'trusted_status'=>'suspend',
        ]);
        return redirect()->route('searlco.trustedBrandsView')->with('msg', 'TrustedBrands Content Data is Successfully Added.');
    }
    public function trustedBrandsStore(Request $request)
    {
        $request->validate([
            'img' => 'required',
        ]);
       
        $fileNameExt = $request->file('img')->getClientOriginalName();
        $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
        $fileExt =  $request->file('img')->getClientOriginalExtension();
        $fileNameToStore = $fileName . '_' . time() . '.' . $fileExt;
        $uploaded_path =public_path('testimg/');
        $folder1 = $request->file('img')->move($uploaded_path, $fileNameToStore);
        $trustedBrands = DB::table('trusted_brands_card')->insertGetId([
            "card_icon" => $fileNameToStore,
        ]);
        return redirect()->route('searlco.trustedBrandsView')->with('msg', 'TrustedBrands Content Data is Successfully Added.');
    }
    public function contactStore(Request $request)
    {

        $request->validate([
            'heading' => 'required',
            'description' => 'required',
            'address_heading' => 'required',
            'address'  => 'required',
            'call_heading'  => 'required',
            'call_number'  => 'required',
            'email_heading'  => 'required',
            'email_address'  => 'required',

        ]);
        $benefits = DB::table('contact_us_content')->insertGetId([
            'heading' => $request->heading,
            'description' => $request->description,
            'address_heading' => $request->address_heading,
            "address_desc" => $request->address,
            "contact_status" => 'suspend',
            "call_heading" => $request->call_heading,
            "call_number" => $request->call_number,
            "email_heading" => $request->email_heading,
            "email_address" => $request->email_address,
        ]);
        return redirect()->route('searlco.contactView')->with('msg', 'Contact Content Data is Successfully Add.');
    }
    /*...............................End Store Functions................................*/
    /*...............................Start Crud Operations................................ */
    public function titleView()
    {
        return view('searlcohome.titleView');
    }
    public function getTitleData()
    {
        $title=DB::table('site_title')->get();
        return response()->json(
            [
            'data'=>$title
        ]
    );
    }
    public function deleteTitleData(Request $request)
    {
        $data = DB::table('site_title')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveTitleData(Request $request)
    {
        $data = DB::table('site_title')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditTitleData(Request $request)
    {
        $data = DB::table('site_title')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsTitleData(Request $request)
    {
        $update = DB::table('site_title')->where('id', $request->id)->update([
                'title' => $request->title
            ]);
        return response()->json($update);
    }
    public function sliderView()
    {
        return view('searlcohome.sliderView');
    }
    public function getSliderData()
    {
        $user = DB::table('slider_content')->get();
        return response()->json(
            [
                'data' => $user
            ]
        );
    }
    public function deleteSliderData(Request $request)
    {
        $data = DB::table('slider_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveSliderData(Request $request)
    {
        $data = DB::table('slider_content')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditSliderData(Request $request)
    {
        $data = DB::table('slider_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsSliderData(Request $request)
    {
        $update = DB::table('slider_content')->where('id', $request->id)->update([
                'heading' => $request->heading, 'description' => $request->description,
                'button1' => $request->button1, 'button2' => $request->button2,
                 'href1' => $request->href1, 'href2' => $request->href2
            ]);
        return response()->json($update);
    }
    public function servicesView(Request $request)
    {
        return view('searlcohome.servicesView');
    }
    public function getServicesData()
    {
        $user = DB::table('services_content')->get();
        return response()->json(
            [
                'data' => $user
            ]
        );
    }
    public function deleteServicesData(Request $request)
    {
        $data = DB::table('services_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveServicesData(Request $request)
    {
        $data = DB::table('services_content')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditServicesData(Request $request)
    {
        $data = DB::table('services_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsServicesData(Request $request)
    {
        $update = DB::table('services_content')->where('id', $request->id)->update(['heading' => $request->heading, 'description' => $request->desc]);
        return response()->json($update);
    }

    public function getCardData()
    {
        $user = DB::table('services_card')->get();
        return response()->json(
            [
                'data' => $user
            ]
        );
    }
    public function deleteCardData(Request $request)
    {
        $data = DB::table('services_card')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveCardData(Request $request)
    {
        $data = DB::table('services_card')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditCardData(Request $request)
    {
        $data = DB::table('services_card')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsCardData(Request $request)
    {

        if (!$request->hasFile('file')) {
            
            $update = DB::table('services_card')->where('id', $request->id)
            ->update(['card_heading' => $request->heading,
            'card_paragraph' => $request->card_para]);
            $msg=1;
            return response()->json($msg);
        }
        else
        {

            $fileNameExt = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
            $fileExt =  $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $fileExt;
            $uploaded_path =public_path('testimg/');
            $folder1 = $request->file('file')->move($uploaded_path, $fileNameToStore);
            $update = DB::table('services_card')->where('id', $request->id)
            ->update(['card_heading' => $request->heading,
             'card_paragraph' => $request->card_para, 'card_icon' => $fileNameToStore]);
             $msg=2;
            return response()->json($msg);
        }
    }


    public function searlcoNetworkView(Request $request)
    {
        return view('searlcohome.searlcoNetworkView');
    }
    public function getSearlcoNetworkData()
    {
        $user = DB::table('searlco_network_content')->get();
        return response()->json(
            [
                'data' => $user
            ]
        );
    }
    public function deleteSearlcoNetworkData(Request $request)
    {
        $data = DB::table('searlco_network_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveSearlcoNetworkData(Request $request)
    {
        $data = DB::table('searlco_network_content')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditSearlcoNetworkData(Request $request)
    {
        $data = DB::table('searlco_network_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsSearlcoNetworkData(Request $request)
    {
        $update = DB::table('searlco_network_content')->where('id', $request->id)->update(['heading' => $request->head, 'highlight_text' => $request->high, 'remaining_heading' => $request->remain, 'description' => $request->desc]);
        return response()->json($update);
    }

    public function getSearlcoNetworkCardData()
    {
        $user = DB::table('searlco_network_card')->get();
        return response()->json(
            [
                'data' => $user
            ]
        );
    }
    public function deleteSearlcoNetworkCardData(Request $request)
    {
        $data = DB::table('searlco_network_card')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveSearlcoNetworkCardData(Request $request)
    {
        $data = DB::table('searlco_network_card')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditSearlcoNetworkCardData(Request $request)
    {
        $data = DB::table('searlco_network_card')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsSearlcoNetworkCardData(Request $request)
    {

      //  if (!$request->hasFile('file')) {
            $update = DB::table('searlco_network_card')->where('id', $request->id)
       ->update(['heading' => $request->heading, 'description' => $request->card_para]);
       $msg=1;
       return response()->json($msg);
       // }
      /* else
       {
           $fileNameExt = $request->file('file')->getClientOriginalName();
           $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
           $fileExt =  $request->file('file')->getClientOriginalExtension();
           $fileNameToStore = $fileName . '_' . time() . '.' . $fileExt;
           $uploaded_path =public_path('testimg/');
           $folder1 = $request->file('file')->move($uploaded_path, $fileNameToStore);
           $update = DB::table('searlco_network_card')->where('id', $request->id)
       ->update(['heading' => $request->heading, 'description' => $request->card_para,'card_icon'=>$fileNameToStore]);
       $msg=2;
       return response()->json($msg);
       }
	   */
    }


    public function featuresView(Request $request)
    {
        return view('searlcohome.featuresView');
    }
    public function getFeaturesData()
    {
        $user = DB::table('features_content')->get();
        return response()->json(
            [
                'data' => $user
            ]
        );
    }
    public function deleteFeaturesData(Request $request)
    {
        $data = DB::table('features_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveFeaturesData(Request $request)
    {
        $data = DB::table('features_content')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditFeaturesData(Request $request)
    {
        $data = DB::table('features_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsFeaturesData(Request $request)
    {
        $update = DB::table('features_content')->where('id', $request->id)->update(['heading' => $request->heading, 'highlight_heading' => $request->highlight, 'description' => $request->desc]);
        return response()->json($update);
    }

    public function getFeaturesCardData()
    {
        $user = DB::table('features_card')->get();
        return response()->json(
            [
                'data' => $user
            ]
        );
    }
    public function deleteFeaturesCardData(Request $request)
    {
        $data = DB::table('features_card')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveFeaturesCardData(Request $request)
    {
        $data = DB::table('features_card')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditFeaturesCardData(Request $request)
    {
        $data = DB::table('features_card')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsFeaturesCardData(Request $request)
    {
        $update = DB::table('features_card')->where('id', $request->id)->update(['heading' => $request->heading, 'description' => $request->desc]);
        return response()->json($update);
    }
    public function standardView(Request $request)
    {
        return view('searlcohome.standardView');
    }
    // .................................................................
    public function getStandardData()
    {
        $user = DB::table('benefits_content')->get();
        return response()->json(
            [
                'data' => $user
            ]
        );
    }
    public function deleteStandardData(Request $request)
    {
        $data = DB::table('benefits_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveStandardData(Request $request)
    {
        $data = DB::table('benefits_content')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditStandardData(Request $request)
    {
        $data = DB::table('benefits_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsStandardData(Request $request)
    {
        $update = DB::table('benefits_content')->where('id', $request->id)->update(['highlight_heading' => $request->heading, 'remaining_heading' => $request->remain, 'description' => $request->desc]);
        return response()->json($update);
    }

    public function getStandardCardData()
    {
        $user = DB::table('benefits_card')->get();
        return response()->json(
            [
                'data' => $user
            ]
        );
    }
    public function deleteStandardCardData(Request $request)
    {
        $data = DB::table('benefits_card')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveStandardCardData(Request $request)
    {
        $data = DB::table('benefits_card')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditStandardCardData(Request $request)
    {
        $data = DB::table('benefits_card')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsStandardCardData(Request $request)
    {
        $update = DB::table('benefits_card')->where('id', $request->id)->update(['heading' => $request->heading, 'description' => $request->desc]);
        return response()->json($update);
    }

    // ...............................................................................

    public function trustedBrandsView(Request $request)
    {
        return view('searlcohome.trustedBrandsView');
    }
    public function getTrustedData()
    {
        $user = DB::table('trusted_brands_content')->get();
        return response()->json(
            [
                'data' => $user
            ]
        );
    }
    public function deleteTrustedData(Request $request)
    {
        $data = DB::table('trusted_brands_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveTrustedData(Request $request)
    {
        $data = DB::table('trusted_brands_content')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditTrustedData(Request $request)
    {
        $data = DB::table('trusted_brands_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsTrustedData(Request $request)
    {
        $update = DB::table('trusted_brands_content')->where('id', $request->id)->update(['heading' => $request->heading, 'description' => $request->desc]);
        return response()->json($update);
    }

    public function getTrustedCardData()
    {
        $user = DB::table('trusted_brands_card')->get();
        return response()->json(
            [
                'data' => $user
            ]
        );
    }
    public function deleteTrustedCardData(Request $request)
    {
        $data = DB::table('trusted_brands_card')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveTrustedCardData(Request $request)
    {
        $data = DB::table('trusted_brands_card')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditTrustedCardData(Request $request)
    {
        $data = DB::table('trusted_brands_card')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsTrustedCardData(Request $request)
    {
        $fileNameExt = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
            $fileExt =  $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $fileExt;
            $uploaded_path =public_path('testimg/');
            $folder1 = $request->file('file')->move($uploaded_path, $fileNameToStore);
            $update = DB::table('trusted_brands_card')->where('id', $request->id)
        ->update(['card_icon'=>$fileNameToStore]);
        return response()->json($update);
    }


    public function headerView(Request $request)
    {
        return view('searlcohome.headerView');
    }
    public function getheaderData()
    {
        $header = DB::table('header_content')->get();
        return response()->json(
            [
                'data' => $header
            ]
        );
    }
    public function deleteheaderData(Request $request)
    {
        $data = DB::table('header_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveheaderData(Request $request)
    {
        $data = DB::table('header_content')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditheaderData(Request $request)
    {
        $data = DB::table('header_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsheaderData(Request $request)
    {

        $file=$request->file('file');
        if ($file) {
            $fileNameExt = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
            $fileExt =  $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $fileExt;
            $uploaded_path =public_path('testimg/');
            $folder1 = $request->file('file')->move($uploaded_path, $fileNameToStore);
            $update = DB::table('header_content')->where('id', $request->id)->
            update(['login' => $request->login, 'signup' => $request->signup, 'logo' => $fileNameToStore]);
                $msg =2;
                return response()->json($msg);
           
        }
        else
        {
            $update = DB::table('header_content')->where('id', $request->id)
            ->update(['login' => $request->login, 'signup' => $request->signup]);
           
                $msg=1;
                return response()->json($msg);
        
            
        }
    }
    public function getMenuData()
    {
        $header = DB::table('navbar_content')->get();
        return response()->json(
            [
                'data' => $header
            ]
        );
    }
    public function deleteMenuData(Request $request)
    {
        $data = DB::table('navbar_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveMenuData(Request $request)
    {
        $data = DB::table('navbar_content')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditMenuData(Request $request)
    {
        $data = DB::table('navbar_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsMenuData(Request $request)
    {
        $update = DB::table('navbar_content')->where('id', $request->id)->update(['menu_name' => $request->menu_name, 'href' => $request->link]);
        return response()->json($update);
    }

    public function contactView()
    {
        return view('searlcohome.contactView');
    }
    public function getContactData()
    {
        $header = DB::table('contact_us_content')->get();
        return response()->json(
            [
                'data' => $header
            ]
        );
    }
    public function deleteContactData(Request $request)
    {
        $data = DB::table('contact_us_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function RemoveContactData(Request $request)
    {
        $data = DB::table('contact_us_content')->where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function EditContactData(Request $request)
    {
        $data = DB::table('contact_us_content')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function editsContactData(Request $request)
    {
        $update = DB::table('contact_us_content')->where('id', $request->id)->update([
                'heading' => $request->heading, 'description' => $request->description,
                'address_heading' => $request->address_heading, 'address_desc' => $request->address,
                'call_heading' => $request->call_h, 'call_number' => $request->call_n,
                'email_heading' => $request->email_h, 'email_address' => $request->email_a,
            ]);
        return response()->json($update);
    }
//..............................Status Change Controllers..........................................................
public function changeTitleStatus(Request $request)
{
    $update = DB::table('site_title')->where('id', $request->id)->first();
    return response()->json($update);
}
public function updateTitleStatus(Request $request)
{    
    $update = DB::table('site_title')->where('id', '!=', $request->id)->update(['status' => 'suspend']);
    $update = DB::table('site_title')->where('id', $request->id)->update(['status' => 'active']);
    return response()->json($update);
}
   public function changeHeaderStatus(Request $request)
    {
        $update = DB::table('header_content')->where('id', $request->id)->first();
        return response()->json($update);
    }
    public function updateHeaderStatus(Request $request)
    {
        $update = DB::table('header_content')->where('id', '!=', $request->id)->update(['haeder_status' => 'suspend']);
        $update = DB::table('header_content')->where('id', $request->id)->update(['haeder_status' => 'active']);
        return response()->json($update);
    }
    public function changeTrustedStatus(Request $request)
    {
        $update = DB::table('trusted_brands_content')->where('id', $request->id)->first();
        return response()->json($update);
    }
    public function updateTrustedStatus(Request $request)
    {
        $update = DB::table('trusted_brands_content')->where('id', '!=', $request->id)->update(['trusted_status' => 'suspend']);
        $update = DB::table('trusted_brands_content')->where('id', $request->id)->update(['trusted_status' => 'active']);
        return response()->json($update);
    }
    public function changeContactStatus(Request $request)
    {
        $update = DB::table('contact_us_content')->where('id', $request->id)->first();
        return response()->json($update);
    }
    public function updateContactStatus(Request $request)
    {
        $update = DB::table('contact_us_content')->where('id', '!=', $request->id)->update(['contact_status' => 'suspend']);
        $update = DB::table('contact_us_content')->where('id', $request->id)->update(['contact_status' => 'active']);
        return response()->json($update);
    }
    public function changeServicesStatus(Request $request)
    {
        $update = DB::table('services_content')->where('id', $request->id)->first();
        return response()->json($update);
    }
    public function updateServicesStatus(Request $request)
    {
        $update = DB::table('services_content')->where('id', '!=', $request->id)->update(['services_status' => 'suspend']);
        $update = DB::table('services_content')->where('id', $request->id)->update(['services_status' => 'active']);
        return response()->json($update);
    }
    public function changeNetworkStatus(Request $request)
    {
        $update = DB::table('searlco_network_content')->where('id', $request->id)->first();
        return response()->json($update);
    }
    public function updateNetworkStatus(Request $request)
    {
        $update = DB::table('searlco_network_content')->where('id', '!=', $request->id)->update(['network_status' => 'suspend']);
        $update = DB::table('searlco_network_content')->where('id', $request->id)->update(['network_status' => 'active']);
        return response()->json($update);
    }
    public function changeFeaturesStatus(Request $request)
    {
        $update = DB::table('features_content')->where('id', $request->id)->first();
        return response()->json($update);
    }
    public function updateFeaturesStatus(Request $request)
    {
        $update = DB::table('features_content')->where('id', '!=', $request->id)->update(['features_status' => 'suspend']);
        $update = DB::table('features_content')->where('id', $request->id)->update(['features_status' => 'active']);
        return response()->json($update);
    }
    public function changeStandardStatus(Request $request)
    {
        $update = DB::table('benefits_content')->where('id', $request->id)->first();
        return response()->json($update);
    }
    public function updateStandardStatus(Request $request)
    {
        $update = DB::table('benefits_content')->where('id', '!=', $request->id)->update(['benefits_status' => 'suspend']);
        $update = DB::table('benefits_content')->where('id', $request->id)->update(['benefits_status' => 'active']);
        return response()->json($update);
    }

    /*...............................End Crud Operations..................................... */
}
