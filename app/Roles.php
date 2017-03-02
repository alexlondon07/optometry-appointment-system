<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model {

	/**
     * Enable soft deletes for a model
     * @var string
     */
    protected $dates = ['deleted_at'];


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Atributos que se pueden insertar en Mass-Assignment
     * @var array
     */
    protected $fillable = ['rol', 'enable'];

    
		/**
		 * Metodo para buscar
		 * [scopeSearch description]
		 * @param  [type] $query [description]
		 * @param  [type] $rol  [description]
		 * @return [type]        [description]
		 */
		public function scopeSearch($query, $rol){
			return $query->where('rol', 'LIKE', "%$rol%");
		}

}
