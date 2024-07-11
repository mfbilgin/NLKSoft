<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unitPrice', 'unitsInStock', 'description', 'category_id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function get_avg_rating()
    {
        return $this->reviews()->approved()->avg('rating') ?? 0;
    }

    public function get_reviews_count()
    {
        return $this->reviews()->approved()->count();
    }

    public function get_reviews_count_by_rating($rating)
    {
        return $this->reviews()->approved()->where('rating', $rating)->count();
    }

    public function decrease_stock($amount)
    {
        $this->unitsInStock -= $amount;
        $this->save();
    }
}
