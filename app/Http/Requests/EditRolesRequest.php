<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Routing\Route;

class EditRolesRequest extends Request
{


  	public function __construct(Route $route){
  		$this->route=$route;
  	}

    /**
     * Determine if the roles is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      return [
          'rol'  => 'required|max:100|unique:roles,rol,' .$this->route->getParameter('roles'),
          'enable'=>'in:si,no'
  		];
    }
}
