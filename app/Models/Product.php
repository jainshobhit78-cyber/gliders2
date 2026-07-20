<?php

namespace App\Models;

use App\Support\UnitFormatter;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'display_order',
        'description',
        'wallpaper',
        'profile_pic',
        'delivery_tag',
        'specs_subtext',
        'specs_image',
        'technical_specs',
        'caps_image',
        'main_capabilities',
        'specification_pdf'
    ];

    protected $casts = [
        'technical_specs' => 'array',
        'main_capabilities' => 'array'
    ];

    /*
     | Units are normalised on read (kg, m, s, m/s, kmph, gsm, m², ft) so the site
     | shows internationally accepted symbols no matter how they were typed in the
     | admin panel. Note: these accessors take precedence over the array casts
     | above, so the JSON fields are decoded here explicitly.
     */

    public function getDescriptionAttribute($value)
    {
        return UnitFormatter::normalize($value);
    }

    public function getSpecsSubtextAttribute($value)
    {
        return UnitFormatter::normalize($value);
    }

    public function getTechnicalSpecsAttribute($value)
    {
        return UnitFormatter::normalize($this->decodeJsonAttribute($value));
    }

    public function getMainCapabilitiesAttribute($value)
    {
        return UnitFormatter::normalize($this->decodeJsonAttribute($value));
    }

    protected function decodeJsonAttribute($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        return json_decode((string) $value, true) ?: [];
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
