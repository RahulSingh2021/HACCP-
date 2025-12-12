<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServingArea extends Model
{
    /**
     * @var string
     */
    protected $table = 'servingarea';
	    /**
     * @var array
     */
    protected $fillable = [
         'name', 'created_by'
    ];

}
