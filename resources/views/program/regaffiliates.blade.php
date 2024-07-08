
@foreach($allAffiliates as $Data)

<div data-id="{{$Data->joinpgm_programid}}" id="regAffiliates{{$Pid}}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               <h3 id="myModalLabel3"><strong>Registered Affiliates</strong></h3>
           </div>
           <div class="modal-body">
           <table class="table table-striped table-bordered table-hover table-advance" id="sample_1">
                            <thead>
                            <tr>

                                <th class="hidden-phone">Affiliate</th>
                                <th class="hidden-phone">Action</th>


                            </tr>
                            </thead>
                            <tbody>

                               <tr class="odd gradeX">
                                   <td>{{$Data->affiliate_company}} by {{$Data->affiliate_firstname}} {{$Data->affiliate_lastname}}</td>
                                   <td><a data-id="{{$Data->affiliate_id }}" id='comissionBtn' href="#comsiionStructure{{$Pid}}"  role="button"data-toggle="modal">Change Comission</a></td>
                               </tr>
                           </tbody>
            </table>


          </div>
           <div class="modal-footer">


               <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

           </div>
   </div>
@endforeach

