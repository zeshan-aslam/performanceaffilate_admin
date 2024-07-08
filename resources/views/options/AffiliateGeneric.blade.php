

@php
$filenameAff=  public_path('files/terms.htm');
 $fp = fopen($filenameAff,'r');
 if($fp){
    $contentsAff  = fread ($fp, filesize($filenameAff));
 }
 else {
    $contentsAff  = 'Nothing Found in File';
 }

  fclose($fp);
@endphp
<div class="card">
    <div class="card-header text-dark ">
        Change Affiliate Terms And Conditions

    </div>
    <div class="card-body">
        <div class="row">
   <div class="col-6">
    <h4 class="text-dark">Set Terms & Conditions</h4>
   </div>
   <div class="col-4">
    <button class="btn  btn-md" type="button" onclick="javascript:updateAffiliateTerms();">Change</button>
      
   </div>

        </div>
        
     
          
              <div class="row ">
                  <div class="col-11 mx-auto">
                    <textarea class="input-xxlarge" rows="100" cols="200" name='affiliateTerms'>
                        {{$contentsAff}}
                    </textarea>
                  </div>
             
              </div>
                
    
    </div>
   
</div>
