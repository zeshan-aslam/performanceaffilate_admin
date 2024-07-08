<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerMerchant extends Model
{
    use HasFactory;
    protected $table ='partners_merchant';

    public function program()
    {
        return $this->hasOne(PartnerProgram::class,'program_merchantid');
    }
}
