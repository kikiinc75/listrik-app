<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElectricityUsage extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'electricity_account_id', 'month', 'year', 'meter_from', 'meter_to'
    ];

    /**
     * Get the electricty_account associated with the electricty_usage.
     */
    public function electricityAccount(): BelongsTo
    {
        return $this->belongsTo(ElectricityAccount::class);
    }

    /**
     * Get the billing associated with the electricty_usage.
     */
    public function billing(): HasOne
    {
        return $this->hasOne(Billing::class);
    }
}
