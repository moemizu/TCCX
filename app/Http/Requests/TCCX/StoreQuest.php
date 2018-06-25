<?php

namespace App\Http\Requests\TCCX;

use App\TCCX\Quest\QuestLocation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Fluent;
use Illuminate\Validation\Rule;

class StoreQuest extends FormRequest
{
    private const REGEX_GEO_CORD = 'regex:(\-?\d+(\.\d+)?)';

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
            // general
            'name' => 'required|string',
            'order' => 'required|integer|',
            'type' => 'required|integer|exists:quest_types,id',
            'zone' => 'required|integer|exists:quest_zones,id',
            'difficulty' => ['required', Rule::in('Easy', 'Normal', 'Hard')],
            // details
            'story' => 'present|string|nullable',
            'how-to' => 'required|string',
            'criteria' => 'required|string',
            'editorial' => 'present|string|nullable'
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
        // location id validation
        // required if other location related field is not present
        // for edit mode, this is required
        $validator->sometimes('location-id', 'required|exists:quest_locations,id', function (Fluent $input) {
            if ($input->get('edit', 0)) {
                return true;
            }
            return empty($input->get('location-name')) && empty($input->get('location-type')) &&
                empty($input->get('location-lat')) && empty($input->get('location-lng'));
        });
        // location rules
        // every field is required unless location id field is present
        // not required for edit mode
        $locRules = [
            ['required|string', ['location-name', 'location-type']],
            [['required', self::REGEX_GEO_CORD], ['location-lat', 'location-lng']]
        ];
        foreach ($locRules as $ruleMap) {
            $validator->sometimes($ruleMap[1], $ruleMap[0], function (Fluent $input) {
                // if edit mode then ignore
                if ($input->get('edit', 0)) {
                    return false;
                } else {
                    return empty($input->get('location-id'));
                }
            });
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'location-id.required' => 'Please select a location'
        ];
    }
}
