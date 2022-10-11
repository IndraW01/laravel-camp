<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Checkout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'camp_id',
        'payment_status',
        'midtrans_url',
        'midtrans_booking_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('d F Y', strtotime($value))
        );
    }

    // Tidak dipake, digunakan sebagai bahan pelajaran
    public function expired(): Attribute
    {
        $now = Carbon::now();

        return Attribute::make(
            get: fn ($value) => $now->diffInDays(Carbon::create($value))
        );
    }

    public function cekCheckout($campId): bool
    {
        return $this->whereUserId(Auth::id())->whereCampId($campId)->exists();
    }

    public function checkoutCreate($campId, $userId, $validateData)
    {
        return $this->create([
            'user_id' => $userId,
            'camp_id' => $campId,
            'card_number' => $validateData['card_number'],
            'expired' => date('Y-m-t', strtotime($validateData['expired'])),
            'cvc' => $validateData['cvc'],
        ]);
    }

    public function getCheckouts()
    {
        return $this->with(['user', 'camp'])->oldest()->get();
    }

    public function setToPaid()
    {
        return $this->update([
            'is_paid' => true
        ]);
    }
}
