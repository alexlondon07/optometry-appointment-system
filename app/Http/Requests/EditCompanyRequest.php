<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Routing\Route;

class EditCompanyRequest extends Request
{


  	public function __construct(Route $route){
  		$this->route=$route;
  	}

    /**
     * Determine if the company is authorized to make this request.
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
          'name'  => 'required|max:100|unique:company,name,' .$this->route->getParameter('company'),
          'enable'=>'in:si,no'
  		];
    }
}
