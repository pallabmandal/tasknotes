<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
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
            'subject' => 'string|required',
            'start_date' => 'string|required'
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => 'Subject is required!',
            'start_date.required' => 'Start Date is required!'
        ];
    }
}
