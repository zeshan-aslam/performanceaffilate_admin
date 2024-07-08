


<div id="comsiionStructure{{$Pid}}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               <h3 id="myModalLabel3"><strong>Comission Structure</strong></h3>
           </div>
           <div class="modal-body">
           <table class="table table-striped table-bordered table-hover table-advance" id="sample_1">
                            <thead>
                            <tr>

                                <th class="hidden-phone">Type</th>
                                <th class="hidden-phone">From</th>
                                <th class="hidden-phone">To</th>
                                <th class="hidden-phone">Comissins</th>
                                <th class="hidden-phone">Approvel</th>
                                <th class="hidden-phone">Email Setting</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr class="odd gradeX">

                                <td>Lead</td>
                                <td class="hidden-phone">{{$comission  ->commission_lead_from}}</td>
                                <td class="hidden-phone">{{$comission  ->commission_lead_to}}</td>

                                <td class="hidden-phone">{{$comission  ->commission_leadrate}}</td>

                                <td class="hidden-phone">
                                @if($comission  ->commission_leadapproval=='manual')
                                    <span class="label label-warning">{{$comission  ->commission_leadapproval}}</span>
                                    @else
                                    <span class="label label-info">{{$comission  ->commission_leadapproval}}</span>
                                    @endif
                                </td>


                                <td class="hidden-phone">
                                @if($comission  ->commission_leadmail=='manual')
                                    <span class="label label-warning">{{$comission  ->commission_leadmail}}</span>
                                  @else
                                  <span class="label label-info">{{$comission  ->commission_leadmail}}</span>
                               @endif
                                </td>
                            </tr>

                            <tr class="odd gradeX">

                             <td>Sale</td>
                             <td class="hidden-phone">{{$comission  ->commission_sale_from}}</td>
                             <td class="hidden-phone">{{$comission  ->commission_sale_to}}</td>

                             <td class="hidden-phone">{{$comission  ->commission_salerate}}</td>

                             <td class="hidden-phone">
                             @if($comission  ->commission_saleapproval=='manual')
                                 <span class="label label-warning">{{$comission  ->commission_saleapproval}}</span>
                                 @else
                                 <span class="label label-info">{{$comission  ->commission_saleapproval}}</span>
                                 @endif
                             </td>


                             <td class="hidden-phone">
                             @if($comission  ->commission_salemail=='manual')
                                 <span class="label label-warning">{{$comission->commission_salemail}}</span>
                               @else
                               <span class="label label-info">{{$comission->commission_salemail}}</span>
                            @endif
                             </td>
                         </tr>

                            </tbody>
                        </table>


          </div>
           <div class="modal-footer">
           <form  method="POST" action="{{route('Program.updateComission' ,   $Pid)}}" >
                 @csrf
               <input id='comissionAffiliateId' type="hidden" name="comissionAffiliateId" value="" />
               <input type="hidden" name="comissionProgramId" value="{{  $Pid}}" />
                <input type="hidden" name="commissionComissionId" value="{{$comission  ->commission_id}}"  />

               <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
              
               <input id='' type="hidden" name="mode" value="set" />
               <button class="btn btn-success" type="submit">Set this Default Comission for Affiliate</button>

             
           </form>

           </div>
   </div>







