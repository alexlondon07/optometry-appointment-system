<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Cviebrock\EloquentSluggable\Sluggable;

class User extends Model implements AuthenticatableContract,
AuthorizableContract,
CanResetPasswordContract
{
  use Authenticatable, Authorizable, CanResetPassword;

  use Sluggable;

  /**
  * Return the sluggable configuration array for this model.
  *
  * @return array
  */
  public function sluggable()
  {
    return [
      'slug' => [
        'source' => 'name'
      ]
    ];
  }

  /**
  * The database table used by the model.
  *
  * @var string
  */
  protected $table = 'users';

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = ['name', 'email', 'document', 'position', 'password', 'enable', 'profile'];

  /**
  * The attributes excluded from the model's JSON form.
  *
  * @var array
  */
  protected $hidden = ['password', 'remember_token'];

  public function setPasswordAttribute($value){
    if(!empty($value)){
      $this->attributes['password']= bcrypt($value);
      //$this->attributes['password'] = Hash::make($pass);
    }
  }

    /**
    * Relacion con archivo adjunto
    * Relacion uno a muchos
    * [attachment description]
    * @return [type] [description]
    */
    public function attachment() {
      return $this->hasMany('App\Attachment');
    }

}
