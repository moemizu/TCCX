<?php

namespace App\Http\Requests\TCCX;


use App\BooleanChain;
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
            'time' => 'required|integer|in:0,1,2',
            'group' => 'required|integer',
            'type' => 'required|integer|exists:quest_types,id',
            'difficulty' => ['required'],
            // details
            'story' => 'present|string|nullable',
            'how-to' => 'required|string',
            'criteria' => 'required|string',
            'editorial' => 'present|string|nullable',
            'last-page' => 'present|integer|nullable'
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
                return !empty($input->get('location-id'));
            } // if location is null then don't validate
            else if (empty($input->get('location-id'))) {
                return false;
            }
            // everything must be empty
            // doesn't happen in most case
            else
                return $this->emptyInputChain($input, ['location-name', 'location-type'], true, false);
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
                    if (empty($input->get('location-id')))
                        return false;
                    else
                        return $this->emptyInputChain($input, ['location-name', 'location-type']);
                }
            });
        }
        // zone rules
        $validator->sometimes('zone', 'required|integer|exists:quest_zones,id', function (Fluent $input) {
            return !empty($input->get('zone'));
        });
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // location
            'location-id.required' => 'Please select a location',
            'location-id.exists' => 'Selected location must be valid',
            'location-lat.required' => 'Please enter a latitude',
            'location-lng.required' => 'Please enter a longitude',
            'location-lat.regex' => 'Invalid pattern for latitude',
            'location-lng.regex' => 'Invalid pattern for longitude',

        ];
    }

    private function emptyInputChain(Fluent $input, $keys = [], $start = false, $or = true)
    {
        return (new BooleanChain(function (Fluent $input, $key) {
            return empty($input->get($key));
        }, $input))->evaluate($keys, $start, $or);
    }
}
