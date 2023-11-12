<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterConfessionCategory extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory, SoftDeletes, Sluggable;


    // ---------------------------------
    // PROPERTIES
    protected $table = "mst_confession_categories";
    protected $primaryKey = "id_confession_category";
    protected $guarded = [
        'id_confession_category',
    ];


    // ---------------------------------
    // RELATIONSHIPS
    public function confessions()
    {
        return $this->hasMany(RecConfession::class, "id_confession_category", "id_confession_category");
    }


    // ---------------------------------
    // HELPERS
    public function scopeActive($query)
    {
        return $query->where("flag_active", "Y");
    }

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function scopeFilter($query, array $filters)
    {
        /* SEARCH: CATEGORY */
        $query->when(
            $filters["search"] ?? false,
            fn ($query, $search) =>
            $query->where(
                fn ($query) =>
                $query->Where("category_name", "like", "%" . $search . "%")
            )
        );
    }


    // ---------------------------------
    // UTILITIES
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'category_name'
            ]
        ];
    }
}
