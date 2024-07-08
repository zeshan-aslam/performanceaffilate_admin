@include("payment.MerReqDelete")
@include("payment.RejectMer")
@include("payment.Mer_adjustmoney")
@include("payment.confirmMerpay")

<fieldset>
    <legend>
        <center><strong style="font-family:Cambria; font-size:26px; color:grey;">Merchant Request</strong></center>
    </legend>

</fieldset>

    <div class='row-fluid'>

        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->

            <div class="widget-body">
                <div>
                    <div class="clearfix">
                        <input name="_token" id="token" value="{{ csrf_token() }}" type="hidden">
                        <table id="MerReqpay" class='table table-hover table-striped'>

                                <thead>
                                    <th>Date</th>
                                    <th>Merchant</th>
                                    <th>Amount </th>
                                    <th>Purpose</th>
                                    <th>Payment Methods</th>
                                    <th>Do Payment</th>



                                </thead>
                                <tbody>


                            </tbody>


                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>



