<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Company extends Model {

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
    protected $table = 'company';

    /**
     * Atributos que se pueden insertar en Mass-Assignment
     * @var array
     */
    protected $fillable = ['name', 'description', 'slug', 'enable'];

	/**
	* Metodo para buscar
	* [scopeSearch description]
	* @param  [type] $query [description]
	* @param  [type] $name  [description]
	* @return [type]        [description]
	*/
	public function scopeSearch($query, $name){
			return $query->where('name', 'LIKE', "%$name%");
	}


	/**
	* Relacion uno a muchos
	* Una Empresa tiene muchos roles y responsabilidades asignadas
	* @return Relation
	*/
	public function roles() {
		return $this->belongsToMany('App\Roles', 'roles_has_company')
			->withPivot('company_id', 'roles_id', 'responsability')
			->withTimestamps()
			->whereNull('roles_has_company.deleted_at');
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
