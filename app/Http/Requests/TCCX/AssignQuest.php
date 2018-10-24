<?php

namespace App\Http\Requests\TCCX;

use Illuminate\Foundation\Http\FormRequest;

class AssignQuest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * TODO: Only admin can assign a quest!
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
            'quest-id' => 'exists:quests,id',
            'selected-team' => 'exists:teams,id'
        ];
    }
}
