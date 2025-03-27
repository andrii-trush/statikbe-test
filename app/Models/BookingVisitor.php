<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\AbonnementNumber;
use Illuminate\Database\Eloquent\Model;

class BookingVisitor extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'abonnement_number',
    ];

    public function casts(): array
    {
        return [
            'last_name' => 'encrypted',
            'abonnement_number' => AbonnementNumber::class,
        ];
    }
}
