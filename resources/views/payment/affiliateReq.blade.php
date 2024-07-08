<fieldset>
    <legend>
        <center><strong style="font-family:Cambria; font-size:26px; color:grey;">Affiliate Request</strong></center>
    </legend>

</fieldset>


<div class='row-fluid'>

    <div class="span12">
        <div class="widget-body">
            <div>
                <div class="clearfix">
                    <table id="affReqpay" class='table table-hover table-striped'>

                        <thead>
                            <th>
							{{-- <input type="checkbox" name="checkAll"
                                    onclick="javascript:$('.checkbox').prop('checked',$('input[name=checkAll]').is(':checked'));"> --}}
                            </th>
                            <th>Affiliate</th>
                            <th>Withdraw Amount</th>
                            <th>Current Balance </th>
                            <th>Gateway</th>
                            <th>Date</th>
                            <th>Delete</th>
                            <th>Manual Pay</th>
                        </thead>
                        <tbody>



                        </tbody>
                    </table>
                    <p>
                        <i class='icon-long-arrow-up fa-2x'></i>
                        <a href="javascript:;" class="btn btn-danger btn-sm" onclick="javascript:DeleteaffReq();">Delete</a>
                    </p>
                    {{-- <strong>Note:</strong>
                    <p> Export MassPay File & Make Mass Payment Are Applicable only for Paypal Accounts</p> --}}
                </div>

            </div>
        </div>
    </div>
</div>
