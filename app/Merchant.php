<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $maps =[
        'id' => 'id',
        'firstname' => 'merchant_firstname',
        'lastname' => 'merchant_lastname',
        'profileimage' => 'merchant_profileimage',
        'company' => 'merchant_company',
        'address' => 'merchant_address',
        'city' => 'merchant_city',
        'country' => 'merchant_country',
        'phone' => 'merchant_phone',
        'url' => 'merchant_url',
        'catagory' => 'merchant_catagory',
        'status' => 'merchant_status',
        'date' => 'merchant_date',
        'fax' => 'merchant_fax',
        'type' => 'merchant_type',
        'randNo' => 'merchant_randNo',
        'pgmapproval' => 'merchant_pgmapproval',
        'currency' => 'merchant_currency',
        'state' => 'merchant_state',
        'zip' => 'merchant_zip',
        'taxId' => 'merchant_taxId',
        'orderId' => 'merchant_orderId',
        'saleAmt' => 'merchant_saleAmt',
        'isInvoice' => 'merchant_isInvoice',
        'invoiceStatus' => 'merchant_invoiceStatus',
        'headercode' => 'merchant_headercode',
        'footercode' => 'merchant_footercode', 
      ];
}
