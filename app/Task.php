<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Task.
 *
 * @package namespace App;
 */
class Task extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * Table name of this Model.
     *
     * @var string
     */

    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'priority', 'term', 'is_completed'
    ];

    /**
     * Always store the priority attribute with first character
     * of each word in value as uppercase.
     *
     * @param $value
     */
    public function setPriorityAttribute($value)
    {
        $this->attributes['priority'] = ucwords($value);
    }
}