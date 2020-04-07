<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Notifications\ResetPassword;
use Carbon\Carbon;
use Hash;

/**
 * Class User
 *
 * @package App
 * @property string $title
 * @property string $name
 * @property string $name_kh
 * @property string $email
 * @property string $password
 * @property string $gender
 * @property string $dob
 * @property string $phone
 * @property string $staff_code
 * @property string $position
 * @property string $department
 * @property string $role
 * @property string $remember_token
 * @property string $photo
*/
class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['name', 'name_kh', 'email', 'password', 'gender', 'dob', 'phone', 'staff_code', 'remember_token', 'photo', 'title_id', 'position_id', 'department_id', 'role_id'];
    protected $hidden = ['password', 'remember_token'];
    
    
    public static function boot()
    {
        parent::boot();

        User::observe(new \App\Observers\UserActionsObserver);
    }
    
    

    /**
     * Set to null if empty
     * @param $input
     */
    public function setTitleIdAttribute($input)
    {
        $this->attributes['title_id'] = $input ? $input : null;
    }/**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setDobAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['dob'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['dob'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getDobAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setPositionIdAttribute($input)
    {
        $this->attributes['position_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setDepartmentIdAttribute($input)
    {
        $this->attributes['department_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setRoleIdAttribute($input)
    {
        $this->attributes['role_id'] = $input ? $input : null;
    }
    
    public function title()
    {
        return $this->belongsTo(Title::class, 'title_id')->withTrashed();
    }
    
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id')->withTrashed();
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id')->withTrashed();
    }
    
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function document(){
        return $this->belongsToMany('App\Document');
    }

    public function comment(){
        return $this->hasMany('App\Comment', 'user_id');
    }

    public function documents_comment()
    {
        return $this->belongsToMany('App\Document', 'comments', 'user_id', 'document_id');
    }
    
    

    public function sendPasswordResetNotification($token)
    {
       $this->notify(new ResetPassword($token));
    }
}
