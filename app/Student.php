<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Student extends Model
{
  /**
     * Enable soft deletes for a model
     * @var string
     */
    protected $dates = ['deleted_at'];


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
    protected $table = 'students';

    /**
     * Atributos que se pueden insertar en Mass-Assignment
     * @var array
     */
    protected $fillable = ['name','first_surname','second_surname','document_type','document_of_identity','date_of_birth','age','gender' ,'address','contact_name','one_contact_phone','two_contact_phone','email','password','enable','slug'];


    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = ['password', 'remember_token'];

    public function setPasswordAttribute($value){
      if(!empty($value)){
        $this->attributes['password']= bcrypt($value);
      }
    }

    /**
     * Metodo para buscar registro de estudiante
     * [scopeSearch description]
     * @param  [type] $query [description]
     * @param  [type] $searchTerm  [description]
     * @return [type]        [description]
     */
    public function scopeSearch($query, $searchTerm){
      return $query->where('name', 'LIKE', "%$searchTerm%")
              ->orwhere('email', 'LIKE', "%$searchTerm%")
              ->orwhere('first_surname', 'LIKE', "%$searchTerm%")
              ->orwhere('document_of_identity', 'LIKE', "%$searchTerm%")
              ->orwhere('enable', 'LIKE', "%$searchTerm%");
    }
}
