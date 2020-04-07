<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Title
 *
 * @package App
 * @property string $name
 * @property string $name_kh
 * @property string $abr
 * @property string $description
*/
class Title extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'name_kh', 'abr', 'description'];
    protected $hidden = [];
    
    
    public static function boot()
    {
        parent::boot();

        Title::observe(new \App\Observers\UserActionsObserver);
    }
    
}
