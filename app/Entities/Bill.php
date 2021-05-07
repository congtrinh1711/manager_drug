<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Bill.
 *
 * @package namespace App\Entities;
 */
class Bill extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class)->withPivot('price','amount', 'total_price','unit_name');
    }

}
