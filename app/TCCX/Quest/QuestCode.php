<?php

namespace App\TCCX\Quest;


class QuestCode
{
    /**
     * Generate a quest code
     * TODO: Write a test for generate() method
     * @param Quest $quest
     * @return string
     */
    public function generate(Quest $quest)
    {
        $type = optional($quest->quest_type)->code ?? '';
        $zone = optional($quest->quest_zone)->code ?? '';
        $number = sprintf('%02d', $quest->order);
        return strtoupper($type . $zone . $number);
    }

    /**
     * Parse quest code
     * TODO: Write a test
     * @param string $code
     * @return array
     */
    public function parse(string $code)
    {
        // convert to lower case
        $code = strtolower($code);
        // retrieve type and zone data
        $types = resolve('App\TCCX\Quest\QuestType')->all(['id', 'code']);
        $zones = resolve('App\TCCX\Quest\QuestZone')->all(['id', 'code']);
        $parsedType = null;
        $parsedZone = null;
        $parsedOrder = 0;
        // parse first section
        foreach ($types as $type) {
            $typeCode = strtolower($type->code);
            if (starts_with($code, $typeCode)) {
                $parsedType = $type;
                // replace parsed code
                $code = str_replace_first($typeCode, '', $code);
                break;
            }
        }
        // second
        foreach ($zones as $zone) {
            $zoneCode = strtolower($zone->code);
            if (starts_with($code, $zoneCode)) {
                $parsedZone = $zone;
                $parsedOrder = (int)(str_replace_first($zoneCode, '', $code));
                break;
            }
        }
        return [
            'type' => $parsedType,
            'zone' => $parsedZone,
            'order' => $parsedOrder
        ];
    }
}