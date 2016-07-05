<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model {

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
    protected $table = 'raw_materials';

    /**
     * Atributos que se pueden insertar en Mass-Assignment
     * @var array
     */
    protected $fillable = ['name', 'reference', 'description', 'type', 'unit_of_measure', 'enable'];
}
