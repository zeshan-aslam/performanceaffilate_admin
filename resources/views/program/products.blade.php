
@foreach($products as $data)

<div data-id="{{$data->prd_programid}}" id="products{{$data->prd_programid}}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               <h3 id="myModalLabel3"><strong>Products </strong></h3>
           </div>
           <div class="modal-body">
           <table class="table table-striped table-bordered table-hover table-advance" id="sample_1">
                            <thead>
                            <tr>
                              
                                <th class="hidden-phone">Name</th>
                                <th class="hidden-phone">Price</th>
                                <th class="hidden-phone">Number</th>
                                <th class="hidden-phone">URL</th>
                                
                               
                                
                            </tr>
                            </thead>
                            <tbody>
                               
                               <tr class="odd gradeX">
                                   <td>{{$data->prd_product}}</td>
                                   <td>{{$data->prd_price}}</td>
                                   <td>{{$data->prd_number}}</td>
                                   <td>{{$data->prd_url}}</td>
                                   
                               </tr>
                           </tbody>
            </table>
         
                           
          </div>
           <div class="modal-footer">
          
              
               <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
           
           </div>
   </div>
@endforeach
