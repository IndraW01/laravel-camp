<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checkout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'camp_id',
        'discount_id',
        'payment_status',
        'midtrans_url',
        'midtrans_booking_code',
        'discount_percentage',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('d F Y', strtotime($value))
        );
    }

    public function PaymentStatus(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::upper($value)
        );
    }

    public function cekCheckout($campId): bool
    {
        return $this->whereUserId(Auth::id())->whereCampId($campId)->exists();
    }

    public function checkoutCreate($campId, $userId, $discount)
    {
        return $this->create([
            'user_id' => $userId,
            'camp_id' => $campId,
            'discount_id' => $discount['discount_id'],
            'discount_percentage' => $discount['discount_percentage'],
        ]);
    }

    public function getCheckouts()
    {
        return $this->with(['user', 'camp'])->oldest()->get();
    }

    // Tidak dipake, Checkout versi 1
    public function setToPaid()
    {
        return $this->update([
            'is_paid' => true
        ]);
    }
}
