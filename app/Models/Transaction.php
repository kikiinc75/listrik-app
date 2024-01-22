<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id', 'billing_id', 'paid_at', 'admin_fee', 'total_fee'
    ];

    /**
     * Get the electricty_usages associated with the billings.
     */
    public function electricityUsage(): BelongsTo
    {
        return $this->belongsTo(ElectricityUsage::class);
    }
}
