<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

/**
 * Class Document
 *
 * @package App
 * @property string $letter_code
 * @property string $code_in
 * @property string $document_code
 * @property string $oranization
 * @property text $description
 * @property tinyInteger $submit
 * @property string $user_created
 * @property string $user_updated
*/
class Document extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = ['letter_code', 'code_in', 'document_code', 'oranization', 'description', 'submit', 'user_created_id', 'user_updated_id'];
    protected $hidden = [];
    
    
    public static function boot()
    {
        parent::boot();

        Document::observe(new \App\Observers\UserActionsObserver);
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

    public function user(){
        return $this->belongsToMany('App\User');
    }

    public function comments(){
        return $this->hasMany('App\Comment','document_id');
    }

    public function users_comment()
    {
        return $this->belongsToMany('App\User', 'comments', 'document_id', 'user_id');
    }

    public function user_create(){
        return $this->hasOne('App\User','id','user_created_id');
    }

    
}
