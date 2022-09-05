<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Camp extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'price',
    ];

    public function benefits()
    {
        return $this->hasMany(CampBenefit::class, 'camp_id', 'id');
    }

    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }

    public function title(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value)
        );
    }

    public function getCamps()
    {
        return $this->with('benefits')->get();
    }
}
