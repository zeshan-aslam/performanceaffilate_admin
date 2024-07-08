<?php

$joinId = [];
$j = 0;
foreach ($data as $row) {
    $j++;
    $joinId[$j] = $row->joinpgm_id;
    //   echo "Array = ".$joinId[$j]." ID = ".$row->joinpgm_id."</br>";
}

?>

<div class="row">
    <div class="col-11 ">

        <div class="row">
            <div class="col-5">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">From </label>
                        <div class="controls">
                            <input name="From" type="date" placeholder=".input-medium" class="input-medium" />
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">To</label>
                        <div class="controls">
                            <input name="To" type="date" placeholder=".input-medium" class="input-medium" />
                            <span class="help-inline"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Select Merchant</label>
                        <div class="controls">
                            <select name="Merchant" class="input-medium m-wrap" tabindex="1" name="merchant">
                                <option value="All">All</option>
                                @foreach ($merchants as $merchant)
                                    <option value="{{ $merchant->merchant_id }}">{{ $merchant->merchant_company }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Select Affiliate</label>
                        <div class="controls">
                            <select name="Affiliate" class="input-medium m-wrap" tabindex="1" name="affiliate">
                                <option value="All">All</option>
                                @foreach ($affiliates as $affiliate)
                                    <option value="{{ $affiliate->affiliate_id }}">{{ $affiliate->affiliate_company }}
                                    </option>
                                @endforeach


                            </select>
                        </div>
                    </div>



                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-11">
                <center>

                    <div class="control-group">
                        <!-- <label class="control-label">Type </label> -->
                        <div class="controls">
                            <label class="checkbox">
                                <input name="Impression" type="checkbox" value="impression" />Impression
                            </label>
                            <label class="checkbox">
                                <input name="Sale" type="checkbox" value="sale" /> Sale
                            </label>
                            <label class="checkbox">
                                <input name="Lead" type="checkbox" value="lead" /> Lead
                            </label>
                            <label class="checkbox">
                                <input name="Click" type="checkbox" value="click" /> Click
                            </label>
                        </div>
                    </div>
                </center>
                <br><br>
                <center>
                    <div class="control-group">
                        <a name="getData" class="input-sm btn  btn-success"
                            onclick="getTransaction(event.target)"> View <i class="icon-circle-arrow-down"></i></a>

                    </div>
                </center>
            </div>
        </div>
        <hr>
        <table id='transTable' class="table table-striped table-bordered table-hover">
            <thead class="text-dark">
                <tr>
                    <th class="hidden-phone"> Transaction Id </th>
                    <th class="hidden-phone"> Type </th>
                    <th class="hidden-phone"> Merchant </th>
                    <th class="hidden-phone"> Affiliate</th>
                    <th class="hidden-phone"> Commission </th>
                    <th class="hidden-phone"> Date </th>
                    <th class="hidden-phone"> Referer </th>
                    <th class="hidden-phone"> Status </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>



    </div>
</div>
