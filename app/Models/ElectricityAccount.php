<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElectricityAccount extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cost_id', 'name', 'kwh_number', 'address'
    ];

    /**
     * Get the electricty_account associated with the electricty_usage.
     */
    public function cost(): BelongsTo
    {
        return $this->belongsTo(Cost::class);
    }
}
