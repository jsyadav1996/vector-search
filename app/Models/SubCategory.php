<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubCategory extends Model
{
    protected $table = 'sub_categories';
    protected $fillable = ['category_id', 'name', 'embeddings'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
