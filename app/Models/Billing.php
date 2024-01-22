<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'electricity_usage_id', 'month', 'year', 'total_meter', 'status'
    ];

    /**
     * Get the electricty_usages associated with the billings.
     */
    public function electricityUsage(): BelongsTo
    {
        return $this->belongsTo(ElectricityUsage::class);
    }
}
