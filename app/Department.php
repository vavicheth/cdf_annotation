<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Department
 *
 * @package App
 * @property string $name
 * @property string $name_kh
 * @property string $description
 * @property string $user_created
 * @property string $user_updated
*/
class Department extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'name_kh', 'description', 'user_created_id', 'user_updated_id'];
    protected $hidden = [];
    
    
    public static function boot()
    {
        parent::boot();

        Department::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setUserCreatedIdAttribute($input)
    {
        $this->attributes['user_created_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setUserUpdatedIdAttribute($input)
    {
        $this->attributes['user_updated_id'] = $input ? $input : null;
    }
    
    public function user_created()
    {
        return $this->belongsTo(User::class, 'user_created_id');
    }
    
    public function user_updated()
    {
        return $this->belongsTo(User::class, 'user_updated_id');
    }
    
}
