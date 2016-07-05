<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

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
  protected $table = 'activities';

  /**
  * Atributos que se pueden insertar en Mass-Assignment
  * @var array
  */
  protected $fillable = ['name', 'reference', 'description', 'tolerance', 'acceptance_requirements', 'enable'];

  /**
  * Relacion uno a muchos
  * Una Actividad tiene muchas maquinas asignadas
  * @return Relation
  */
  public function machines() {
    return $this->belongsToMany('App\Machine', 'activities_x_machines')
                    ->withPivot('activity_id', 'machine_id')
                    ->withTimestamps()
                    ->whereNull('activities_x_machines.deleted_at');

  }

}
