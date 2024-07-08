@foreach ($affiliates as $affModelprofile)
<!-- Modal -->
<div id="affModelprofile{{$affModelprofile->affiliate_id}}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel3" style="color:red; text-align:center; font-family:Cambria;"><u>View Profile</u></h3>
         <!-- Do you wants to perform this action for {{$affModelprofile->affiliate_firstname}} ?  -->
    </div>
    <form method="POST" action="{{url('Viewprofile')}}" >
    <div class="modal-body">
        <table class="table table-striped table-hover table-bordered" id="editable-sample1">
                                   
                                     <tbody>
                                     <tr class=""> 
                                         <td><b>ID </b></td>
                                         <td> {{$affModelprofile->affiliate_id}}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Name </b></td>
                                         <td> {{$affModelprofile->affiliate_firstname }} {{$affModelprofile->affiliate_lastname }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Company </b></td>
                                         <td> {{$affModelprofile->affiliate_company }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Address </b></td>
                                         <td> {{$affModelprofile->affiliate_address }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>City </b></td>
                                         <td> {{$affModelprofile->affiliate_city }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Country </b></td>
                                         <td> {{$affModelprofile->affiliate_country }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Phone </b></td>
                                         <td> {{$affModelprofile->affiliate_phone }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Catagory </b></td>
                                         <td> {{$affModelprofile->affiliate_category }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Status </b></td>
                                         <td> {{$affModelprofile->affiliate_status }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Fax </b></td>
                                         <td> {{$affModelprofile->affiliate_fax }}</td>
                                         
                                     </tr>
                                   
                                     <tr class=""> 
                                         <td><b>Currency </b></td>
                                         <td> {{$affModelprofile->affiliate_currency }}</td>
                                         
                                     </tr>
                                     
                                     <tr class=""> 
                                         <td><b>State </b></td>
                                         <td> {{$affModelprofile->affiliate_state }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Zip Code  </b></td>
                                         <td> {{$affModelprofile->affiliate_zipcode }}</td>
                                         
                                     </tr>
                                     <tr class=""> 
                                         <td><b>Tax Id </b></td>
                                         <td> {{$affModelprofile->affiliate_taxId }}</td>
                                         
                                     </tr>
                                    
                                 
                                     
                                     </tbody>
                                    
                                 </table>
    
    </div>
    </form>
    <div class="modal-footer">
    <!-- <button type="submit" class="btn btn-primary">Set dtsdtfgy</button> -->
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        
    </div>
   
</div>
@endforeach
<!--End Modal  -->