<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact_number'
    ];


protected static function booted()
    {
        static::saved(function ($customer) {
            \Illuminate\Support\Facades\Http::put("http://searcher:9200/customers/_doc/{$customer->id}", [
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'email' => $customer->email,
                'contact_number' => $customer->contact_number,
            ]);
        });

        static::deleted(function ($customer) {
            \Illuminate\Support\Facades\Http::delete("http://searcher:9200/customers/_doc/{$customer->id}");
        });
    }
}