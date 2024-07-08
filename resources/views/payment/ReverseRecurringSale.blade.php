 <fieldset>
    <legend>
        <center><strong style="font-family:Cambria; font-size:26px; color:grey;">Reverse Recuring Sale</strong></center>
    </legend>

</fieldset>
<div class='row-fluid'>

        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->

            <div class="widget-body">
                <div>
                    <div class="clearfix">

                        <input name="_token" id="token" value="{{ csrf_token() }}" type="hidden">
                        <input type="hidden" name="id">
                        <input type="hidden" name="aid">
                        <input type="hidden" name="mid">
                        <input type="hidden" name="tid">
                        <input type="hidden" name="rid">
                        <input type="hidden" name="amount">

                        <table id="paymentdata" class='table table-hover table-striped'>
                                <thead>
                                    <th>Affiliate</th>
                                    <th>Merchant</th>
                                    <th>Transaction </th>
                                    <th>Amount</th>
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
