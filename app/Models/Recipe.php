<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    /**
     * @var string
     */
    protected $table = 'Recipe';
	    /**
     * @var array
     */

protected $fillable = [
    'name', 'serving_size', 'portion', 'symbol', 'allergen', 'refrence',
    'description', 'notes', 'energy', 'protein', 'carb', 'fat', 'ingredients','created_by','isActive','deactivatedOn','final_Weight','Weight_change'
];

protected $casts = [
    'ingredients' => 'array', // for auto JSON casting
];

public function items()
    {
        return $this->hasMany(RecipeItem::class);
    }

}
