<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['owner_id', 'title', 'code'];
    protected $casts = ['code' => 'hashed'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function title(): Attribute
    {
        return new Attribute(get: fn($value) => Str::title($value));
    }

    public function scopeReleased(Builder $builder): Builder
    {
        return $builder->where('released', '=', true);
    }
}
