@extends('layouts.masterClone')

@section('title', 'Affiliate')

@section('content')
          <div class='row-fluid'> 
          <div class="span12">
                     <!-- BEGIN EXAMPLE TABLE widget-->
                     <div class="widget red">
                         <div class="widget-title">
                             <h4><i class="icon-reorder"></i> Affiliate</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                         </div>
                         <div class="widget-body">
                             <div>
                                 <div class="clearfix">
                                     <div class="btn-group">
                                         <button id="editable-sample_new" class="btn green">
                                             Add New <i class="icon-plus"></i>
                                         </button>
                                     </div>
                                     <div class="btn-group pull-right">
                                         <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
                                         </button>
                                         <ul class="dropdown-menu pull-right">
                                             <li><a href="#">Print</a></li>
                                             <li><a href="#">Save as PDF</a></li>
                                             <li><a href="#">Export to Excel</a></li>
                                         </ul>
                                     </div>
                                 </div>
                                 <div class="space15"></div>
                                 <h3 style="color:red; font-size:bold; font-famil:Cambria; text-align:center;">View Profile</h3>
                                 <a href="{{route('Affiliate.index')}}" class="btn btn-primary btn-sm">Back </a>
                                 <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                   
                                     <tbody>
                                     <tr class=""> 
                                         <td><b>ID </b></td>
                                         <td> {{$affiliate->id}}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Name </b></td>
                                         <td> {{$affiliate->affiliate_firstname }} {{$affiliate->affiliate_lastname }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Company </b></td>
                                         <td> {{$affiliate->affiliate_company }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Address </b></td>
                                         <td> {{$affiliate->affiliate_address }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>City </b></td>
                                         <td> {{$affiliate->affiliate_city }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Country </b></td>
                                         <td> {{$affiliate->affiliate_country }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Phone </b></td>
                                         <td> {{$affiliate->affiliate_phone }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Catagory </b></td>
                                         <td> {{$affiliate->affiliate_category }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Status </b></td>
                                         <td> {{$affiliate->affiliate_status }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Fax </b></td>
                                         <td> {{$affiliate->affiliate_fax }}</td>
                                         
                                     </tr>
                                     <!-- <tr class=""> 
                                         <td><b>Type </b></td>
                                         <td> {{$affiliate->affiliate_type }}</td>
                                         
                                     </tr> -->
                                     <tr class=""> 
                                         <td><b>Currency </b></td>
                                         <td> {{$affiliate->affiliate_currency }}</td>
                                         
                                     </tr>
                                     
                                     <tr class=""> 
                                         <td><b>State </b></td>
                                         <td> {{$affiliate->affiliate_state }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Zip Code  </b></td>
                                         <td> {{$affiliate->affiliate_zipcode }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Tax Id </b></td>
                                         <td> {{$affiliate->affiliate_taxId }}</td>
                                         
                                     </tr>
                                    
                                 
                                     
                                     </tbody>
                                    
                                 </table>
                             </div>
                         </div>
                     </div>
</div>
            </div>
 
@endsection


<!-- @extends('layouts.masterClone')

@section('title', 'Affiliate')

@section('content')
<style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete Record</h2>
                    
                        <div class="alert alert-danger">
                           
                            <p>Are you sure you want to Remove this Affiliate record?</p>
                            <p>
                                
                            <a href="{{route('Affiliate.removeAffiliate',$id)}}" class="btn btn-danger ml-2">Yes</a>
                                <a href="{{route('Affiliate.index',$id)}}" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                   
                </div>
            </div>        
        </div>
    </div>

 
@endsection -->