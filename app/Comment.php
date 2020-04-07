<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

/**
 * Class Comment
 *
 * @package App
 * @property string $document
 * @property string $user
 * @property string $comment
 * @property tinyInteger $submit
 * @property string $user_created
 * @property string $user_updated
*/
class Comment extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = ['comment', 'submit', 'document_id', 'user_id', 'user_created_id', 'user_updated_id'];
    protected $hidden = [];
    
    
    public static function boot()
    {
        parent::boot();

        Comment::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setDocumentIdAttribute($input)
    {
        $this->attributes['document_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setUserIdAttribute($input)
    {
        $this->attributes['user_id'] = $input ? $input : null;
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
    
    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id')->withTrashed();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
