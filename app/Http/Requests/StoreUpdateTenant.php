<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateTenant extends FormRequest
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
        $id = $this->segment(3);
        
        $rules = [
            'name' => ['required','string', 'min:3','max:255', "unique:tenants,name,{$id},id"],
            'email' => ['required','string', "unique:tenants,email,{$id},id"],
            'cnpj' => ['required', 'string', 'digits:14'],
            'logo' => ['required', 'image']
        ];

        if($this->_method == 'PUT'){
            $rules['logo'] = ['nullable', 'image'];
        }
        
        return $rules;
    }
}
