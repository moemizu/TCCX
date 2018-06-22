<?php

namespace App\Http\Requests\TCCX;

use Illuminate\Foundation\Http\FormRequest;

class SubmitScore extends FormRequest
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
            'score' => 'required|integer',
            'team' => 'required|integer'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            /** @var \Illuminate\Validation\Validator $validator */
            if ($validator->invalid()) {
                $this->session()->flash('scroll-to', 'form-score-change');
            }
        });
    }
}
