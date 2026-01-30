<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact_number'
    ];

    /**
     * The "booted" method of the model.
     * it automates data synchronization with elasticsearch whenever changes occur in the databasee
     */
    protected static function booted()
    {
        // triggers on every (Create o Update)
        static::saved(function ($customer) {
            try {
                Http::put("http://searcher:9200/customers/_doc/{$customer->id}", [
                    'first_name' => $customer->first_name,
                    'last_name' => $customer->last_name,
                    'email' => $customer->email,
                    'contact_number' => $customer->contact_number,
                ]);
            } catch (\Exception $e) {
                // Ignore to prevent blocking the main databasetranscation
            }
        });

        // triggers on every delete
        static::deleted(function ($customer) {
            try {
                Http::delete("http://searcher:9200/customers/_doc/{$customer->id}");
            } catch (\Exception $e) {
                // Ignore errors
            }
        });
    }
}