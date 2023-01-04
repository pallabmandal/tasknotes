<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteTaskNoteRequest extends FormRequest
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
            'task_note_id' => 'integer|required|exists:task_notes,id'
        ];
    }

    public function messages()
    {
        return [
            'task_note_id.required' => 'Task Id is required!'
        ];
    }
}
