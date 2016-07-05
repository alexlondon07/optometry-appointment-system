<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
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
    protected $table = 'machines';

    /**
     * Atributos que se pueden insertar en Mass-Assignment
     * @var array
     */
    protected $fillable = ['name', 'reference', 'description',  'use_common', 'variables', 'maintenance_intervals', 'location', 'maximun_capacity', 'general_manintenance', 'manufacturer', 'name_provider', 'contact_provider', 'billing_provider', 'catalog_provider', 'data_sheet_provider', 'enable'];
}
