<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Merchant;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
         for($i=0; $i<=10 ; $i++){
          
        $array = ['approved', 'waiting','suspend','empty','NP'];
        $IsInv = ['Yes', 'No',];
        $pgm = ['manual', 'automatic',];
        $stat=['active', 'inactive'];

        $random = Arr::random($array);
        $merchant= new Merchant;
        $merchant->merchant_firstname='John';
        $merchant->merchant_lastname='Wick';
        $merchant->merchant_profileimage='john.jpg';
        $merchant->merchant_company='Drag';
        $merchant->merchant_address='sdfsdf';
        $merchant->merchant_city='ulceby';
        $merchant->merchant_country='United Kingdom';
        $merchant->merchant_phone='07590124488';
        $merchant->merchant_url='honeyluvnuts.co.uk';
        $merchant->merchant_catagory='Finance & Legal';
        $merchant->merchant_status= Arr::random($array);
        $merchant->merchant_date='2020-03-28';
        $merchant->merchant_fax='adr';
        $merchant->merchant_type='advance';
        $merchant->merchant_randNo='M_14pR5gG0rM4rR';
        $merchant->merchant_pgmapproval=Arr::random($pgm);
        $merchant->merchant_currency='Euro';
        $merchant->merchant_state='adr';
        $merchant->merchant_zip='dn39 6uq';
        $merchant->merchant_taxId='12321321';
        $merchant->merchant_orderId='{orderid}';
        $merchant->merchant_saleAmt='{amount}';
        $merchant->merchant_isInvoice=Arr::random($IsInv);
        $merchant->merchant_invoiceStatus=Arr::random($stat);
        $merchant->merchant_headercode='NULL';
        $merchant->merchant_footercode='NULL';
        $merchant->save();
         }
    }
}
