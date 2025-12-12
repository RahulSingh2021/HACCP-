<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeItem extends Model
{
    /**
     * @var string
     */
    protected $table = 'recipe_items';
	    /**
     * @var array
     */


protected $fillable = [
    'recipe_id', 'Ingredients_id', 'Quantity'
    
];

public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

}
