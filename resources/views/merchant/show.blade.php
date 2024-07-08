@foreach ($merchants as $merchant)
    <div id="showMerchant{{ $merchant->merchant_id }}" class="modal hide fade" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-header red">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel3"> {{ $merchant->merchant_firstname }} {{ $merchant->merchant_lastname }}</h3>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">

                <tbody>

                    <tr class="">
                        <td><b>Name </b></td>
                        <td> {{ $merchant->merchant_firstname }} {{ $merchant->merchant_lastname }}</td>
                        <td><b>Company </b></td>
                        <td> {{ $merchant->merchant_company }}</td>
                        <td><b>Address </b></td>
                        <td> {{ $merchant->merchant_address }}</td>


                    <tr class="">
                        <td><b>City </b></td>
                        <td> {{ $merchant->merchant_city }}</td>
                        <td><b>Country </b></td>
                        <td> {{ $merchant->merchant_country }}</td>
                        <td><b>Phone </b></td>
                        <td> {{ $merchant->merchant_phone }}</td>

                    </tr>

                    <tr class="">
                        <td><b>Catagory </b></td>
                        <td colspan="2"> {{ $merchant->merchant_category }}</td>
                        <td><b>Status </b></td>
                        <td colspan="2"> {{ $merchant->merchant_status }}</td>
                       


                    <tr class="">
                        <td><b>Type </b></td>
                        <td> {{ $merchant->merchant_type }}</td>
                        <td><b>Currency </b></td>
                        <td> {{ $merchant->merchant_currency }}</td>
                        <td><b>PGM Approvel </b></td>
                        <td> {{ $merchant->merchant_pgmapproval }}</td>

                    </tr>

                    <tr class="">
                        <td><b>State </b></td>
                        <td> {{ $merchant->merchant_state }}</td>
                        <td><b>Zip </b></td>
                        <td> {{ $merchant->merchant_zip }}</td>
                        <td><b>Tax Id </b></td>
                        <td> {{ $merchant->merchant_taxId }}</td>

                    </tr>

                    <tr class="">
                        <td><b>Order Id </b></td>
                        <td> {{ $merchant->merchant_orderId }}</td>
                        <td><b>Sale Amount </b></td>
                        <td> {{ $merchant->merchant_saleAmt }}</td>
                        <td><b>Invoice Status </b></td>
                        <td> {{ $merchant->merchant_invoiceStatus }}</td>

                    </tr>




                </tbody>

            </table>
        </div>
        <div class="modal-footer">


            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

            </form>
        </div>
    </div>
@endforeach
