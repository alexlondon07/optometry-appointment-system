<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Routing\Route;

class EditStudentRequest extends Request
{


    public function __construct(Route $route){
      $this->route=$route;
    }

    /**
     * Determine if the user is authorized to make this request.
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
              'name' => 'required|max:100',
              'first_surname' => 'required|max:100',
              'document_of_identity'  => 'required|unique:students,document_of_identity,' .$this->route->getParameter('student'),
              'email'  => 'required|email|unique:students,email,' .$this->route->getParameter('student'),
              'enable'=>'in:CC,CE,TI,NIT',
              'enable'=>'in:si,no'
      ];
    }
}
