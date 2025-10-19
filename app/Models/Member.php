<?php

namespace App\Models;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    protected static function booted()
    {
        static::creating(function ($member) {
            // generate UUID unik
            $member->uuid = Str::uuid();

            // generate kode unik untuk QR
            $member->qr_code = strtoupper(Str::random(10)); // contoh: AB3X8KP9D2
        });
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('user');
    }

}
