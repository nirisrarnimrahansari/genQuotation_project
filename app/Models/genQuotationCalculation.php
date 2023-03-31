<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class genQuotationCalculation extends Model
{
    use HasFactory;
    protected $fillable  =[
        'prospect_id',
        'work_name_id',
        'area',
        'deleted_date'
    ];
}
