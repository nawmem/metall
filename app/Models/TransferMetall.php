<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferMetall extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_categories_id',
        'in_categories_id',
        'massa'
    ];

    public function fromCatrgorieId(){
        return $this->belongsTo(MetallCategories::class, 'from_categories_id');
    }

    public function inCatrgorieId(){
        return $this->belongsTo(MetallCategories::class, 'in_categories_id');
    }
}
