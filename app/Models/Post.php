<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{


    use HasFactory;
    protected $table = "posts";
    protected $fillable = ["custom_id", "title", "name", "description", "is_active", "publish_date", "category_id"];

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id", "id");
    }

    public function getRouteKeyName()
    {
        return "custom_id";
    }
}
