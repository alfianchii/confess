<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Collection, Model};
use Cviebrock\EloquentSluggable\Sluggable;

class MasterGuide extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory, Sluggable;


    // ---------------------------------
    // PROPERTIES
    protected $table = "mst_guides";
    protected $primaryKey = "id_guide";
    protected $guarded = [
        'id_guide',
    ];
    protected $with = ["parent"];


    // ---------------------------------
    // RELATIONSHIPS
    public function parent()
    {
        return $this->belongsTo(MasterGuide::class, "id_guide_parent", "id_guide");
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by", "id_user");
    }


    // ---------------------------------
    // HELPERS
    public static function getChilds(int $idGuide)
    {
        $childs = MasterGuide::where("id_guide_parent", $idGuide)
            ->where("flag_active", "Y")
            ->get()
            ->each(function ($guide) {
                $guide->childs = MasterGuide::where("id_guide_parent", $guide->id_guide)->get();
            });

        foreach ($childs as $child) {
            if ($child->childs->count()) $child->childs = self::getChilds($child->id_guide);
            else $child->childs = new Collection();
        }

        return $childs;
    }

    public static function scopeChilds($query, bool $sidebar = false)
    {
        $parentGuides = $query
            ->orderBy("id_guide_parent")
            ->where("flag_active", "Y")
            ->get()
            ->each(function ($parentGuide) {
                $parentGuide->childs = self::getChilds($parentGuide->id_guide);
            });

        if ($sidebar) return $parentGuides->filter(fn ($value) => $value->id_guide_parent === 0);

        return $parentGuides;
    }


    // ---------------------------------
    // UTILITIES
    public function getRouteKeyName()
    {
        return "slug";
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
