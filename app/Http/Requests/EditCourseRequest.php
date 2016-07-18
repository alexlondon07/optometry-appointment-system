<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Routing\Route;

class EditCourseRequest extends Request
{


  	public function __construct(Route $route){
  		$this->route=$route;
  	}

    /**
     * Determine if the course is authorized to make this request.
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
          'name'  => 'required|max:100|unique:courses,name,' .$this->route->getParameter('course'),
          'enable'=>'in:si,no'
  		];
    }
}
