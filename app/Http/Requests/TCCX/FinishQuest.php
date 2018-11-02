<?php

namespace App\Http\Requests\TCCX;

use Illuminate\Foundation\Http\FormRequest;

class FinishQuest extends FormRequest
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
            'quest-id' => 'exists:quests,id',
            'note' => 'nullable'
        ];
    }
}
