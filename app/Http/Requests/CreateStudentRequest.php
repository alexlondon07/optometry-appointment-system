<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateStudentRequest extends Request
{
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
              'document_of_identity'  => 'required|unique:students,document_of_identity',
              'email'  => 'required|email|unique:students,email',
              'password'  => 'required',
              'enable'=>'in:CC,CE,TI,NIT',
              'enable'=>'in:si,no'
      ];
    }
}
