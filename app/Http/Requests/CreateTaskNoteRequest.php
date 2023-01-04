<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskNoteRequest extends FormRequest
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
            'task_id' => 'integer|required|exists:tasks,id',
            'subject' => 'string|required',
            'note' => 'string|required'
        ];
    }

    public function messages()
    {
        return [
            'task_id.required' => 'Task Id is required!',
            'subject.required' => 'Subject is required!',
            'note.required' => 'Start Date is required!'
        ];
    }
}
