
<div class="span2">
</div>

<div class="span8">
<div class="card p-2">
    <div class=""><br>
        <strong style="font-family:Cambria; font-size:26px; color:grey;">CHOOSE BILLING PERIOD</strong>
                    {{-- <span class="tools">
                    <a href="javascript:;" class="icon-chevron-down"></a>
                    <a href="javascript:;" class="icon-remove"></a>
                    </span> --}}
    </div>
    <div class="widget-body">

        <form action="#" method="GET" class="form-horizontal">
            <input name="_token" id="token" value="{{ csrf_token() }}" type="hidden">

        <div class="control-group">
           <label class="control-label">From Date</label>
           <div class="controls">
               <input type="date" name='invoiceFrom'  value="" placeholder="From" class="input-medium" />
               <span class="help-inline"></span>
           </div>
       </div>
       <div class="control-group">
           <label class="control-label">To Date</label>
           <div class="controls">
               <input type="date" name='invoiceTo'  value="" placeholder="To" class="input-medium" />
               <span class="help-inline"></span>
           </div>
       </div>
       <strong style="font-weight: bold; font-family:cambria; font-size:18px;"> <u> CHOOSE TYPE </u></strong>
       <div class="control-group"> 
           <div class="controls">
               <select name='status'class="input-medium" >
               <option value="All">All</option>
                <option value="paid">Only Paid</option>
                <option value="unpaid">Only Unpaid</option>
               </select>
           </div>
       </div>
       <div class="control-group">
           <label class="control-label"></label>
           <div class="controls">
            <a name="invoicefetch" id="Invoice" class="input-medium btn btn-primary blue"> Submit <i class="icon-circle-arrow-down"></i></a>


           </div>
       </div>

          </form>
    </div>
</div>
</div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

{{--  --}}

<fieldset>
    <legend>
        <strong style="font-family:Cambria; font-size:26px; color:grey;">Invoices History</strong>
    </legend>

 </fieldset>


            <div class='row-fluid'>

          <div class="span12">
                     <!-- BEGIN EXAMPLE TABLE widget-->

                         <div class="widget-body">
                             <div>
                                 <div class="clearfix">
                                    <input name="_token" id="token" value="{{ csrf_token() }}" type="hidden">
                                <table id="invoiceTable" class="table table-striped table-bordered">
                                   <thead>
                                        <th>Id #</th>
                                        <th>Month-Year</th>
                                        <th>Merchant</th>
                                        <th>Amount</th>
                                        <th>View Transactions</th>
                                        <th>Invoice Paid Status</th>

                                   </thead>
                                   <tbody>


                                   </tbody>
                                    <tfoot>
                                        <th>Id #</th>
                                        <th>Month-Year</th>
                                        <th>Merchant</th>
                                        <th>Amount</th>
                                        <th>View Transactions</th>
                                        <th>Invoice Paid Status</th>
                                    </tfoot>
                                </table>

                                 </div>

                             </div>
                         </div>
                     </div>

            </div>




