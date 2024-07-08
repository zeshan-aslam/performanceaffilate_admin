@php
$filenameMer=  public_path('files/mer_terms.htm');
 $fp = fopen($filenameMer,'r');
 if($fp){
 $contentsMer  = fread ($fp, filesize($filenameMer));
 }
 else{
    $contentsMer  = 'Nothing Found in File';
 }
  fclose($fp);
@endphp
<div class="card">
    <div class="card-header text-dark">
        Change Merchant Terms And Conditions

    </div>
    <div class="card-body">
        <div class="row">
   <div class="col-6">
    <h4 class="text-dark">Set Terms & Conditions</h4>
   </div>
   <div class="col-4">
    <button class="btn btn-md" type="button" onclick="javascript:updateMerchantTerms();">Change</button>
      
   </div>

        </div>
        
     
          
              <div class="row ">
                  <div class="col-11 mx-auto">
                    <textarea class="input-xxlarge" rows="100" cols="200" name='merchantTerms'>
                        {{$contentsMer}}
                    </textarea>
                  </div>
             
              </div>
                
    
    </div>
   
</div>
