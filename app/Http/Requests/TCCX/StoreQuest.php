<?php

namespace App\Http\Requests\TCCX;

use App\TCCX\Quest\QuestLocation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuest extends FormRequest
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
        $geoCordRegex = 'regex:(\-?\d+(\.\d+)?)';
        $requiredLocation = 'nullable'; // HACK: Workaround for required_without
        $locIdValidator = function ($attr, $value, $fail) {
            if (!empty($value) && !QuestLocation::whereId($value)->exists()) {
                return $fail($attr . ' is invalid.');
            }
        };
        return [
            // general
            'name' => 'required|string',
            'order' => 'required|integer|',
            'type' => 'required|integer|exists:quest_types,id',
            'zone' => 'required|integer|exists:quest_zones,id',
            'difficulty' => ['required', Rule::in('Easy', 'Normal', 'Hard')],
            // location
            'location-id' => ['present', $locIdValidator],
            'location-name' => $requiredLocation,
            'location-type' => $requiredLocation,
            'location-lat' => [$requiredLocation, $geoCordRegex],
            'location-lng' => [$requiredLocation, $geoCordRegex],
            // details
            'story' => 'present|string|nullable',
            'how-to' => 'required|string',
            'criteria' => 'required|string',
            'editorial' => 'present|string|nullable'
        ];
    }
}
