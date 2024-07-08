<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerTextOld extends Model
{
    // use HasFactory;
    protected $table ="partners_text_old";

    public function text()
    {
        return $this->belongsTo(PartnerTextOld::class,'text_programid','program_id');
    }
}
