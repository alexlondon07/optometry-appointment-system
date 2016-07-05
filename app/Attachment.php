<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model {

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
    protected $table = 'attachment';

    /**
     * Atributos que se pueden insertar en Mass-Assignment
     * @var array
     */
    protected $fillable = array('name');
    /**
     * Validacion de campos
     * @var array
     */
    public static $RULES_CREATE = array(
          'file' => 'required|mimes:jpg,jpeg,bmp,png',
//        'size' => 'max:1024',
    );

    /**
     * Relacion, un archivo pertenece a un usuario
     * @return Relation
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

}
