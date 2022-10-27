<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:120',
            'description' => 'sometimes|required|string|max:600',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
        ];
    }
    public function messages()
    {
        return[
            'title.required' => ' Event title can not be null',
            'description.required' => 'Description for event can not be empty',
            'start_date.required' => 'please provide an event start date',
            'end_date.required' => 'please provide an event end date',
            'start_date.date' => 'please provide a valid date',
            'end_date.date' => 'please provide a valid date',
            'end_date.after_or_equal' => 'Event end date should not be less than event start date',
            
        ];
    }
}
