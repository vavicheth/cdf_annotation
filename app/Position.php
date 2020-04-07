<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Position
 *
 * @package App
 * @property string $name
 * @property string $name_kh
 * @property string $description
*/
class Position extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'name_kh', 'description'];
    protected $hidden = [];
    
    
    public static function boot()
    {
        parent::boot();

        Position::observe(new \App\Observers\UserActionsObserver);
    }
    
}
