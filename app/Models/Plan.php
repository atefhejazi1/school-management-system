<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'max_students',
        'price',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'max_students' => 'integer',
            'price'        => 'decimal:2',
            'is_active'    => 'boolean',
        ];
    }

    /**
     * كل المدارس (المستأجرين) المرتبطة حالياً بهذه الباقة.
     */
    public function schools(): HasMany
    {
        return $this->hasMany(School::class);
    }
}
