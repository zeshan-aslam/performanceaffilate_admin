

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style type="text/css">
        .panel-title {
        display: inline;
        font-weight: bold;
        }
        .display-table {
            display: table;
        }
        .display-tr {
            display: table-row;
        }
        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 61%;
        }
    </style>
<div class="container">

  <h1 style="text-align:center; color:red">Autherize.Net Payment Gateway Integration</h1><br>

  <div class="row">
      <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-default credit-card-box">
              <div class="panel-heading display-table" >
                  <div class="row display-tr" >
                      <h3 class="panel-title display-td" >Payment Details</h3>
                      <div class="display-td" >

                      </div>
                  </div>
              </div>
              <div class="panel-body">

                  @if (Session::has('success'))
                      <div class="alert alert-success text-center">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                          <p>{{ Session::get('success') }}</p>
                      </div>
                  @endif

                 <form action="{{ url('charge') }}" method="post">
                    {{ csrf_field() }}
                    <p><input type="text" name="amount" placeholder="Enter Amount" class='form-control' /></p>
                    <p><input type="text" name="cc_number" placeholder="Card Number" class='form-control' /></p>
                    <p><input type="text" name="expiry_month" placeholder="Month" class='form-control' /></p>
                    <p><input type="text" name="expiry_year" placeholder="Year" class='form-control' /></p>
                    <p><input type="text" name="cvv" placeholder="CVV" class='form-control'/></p>
                    <input type="submit" class="btn btn-primary btn-lg btn-block" onclick="sendPaymentDataToAnet()" name="submit" value="Submit" />
                </form>
              </div>
          </div>
      </div>
  </div>

</div>

