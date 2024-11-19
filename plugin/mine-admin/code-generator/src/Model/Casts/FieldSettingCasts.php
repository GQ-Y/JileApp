<?php

namespace Plugin\MineAdmin\CodeGenerator\Model\Casts;

use Hyperf\Contract\CastsAttributes;
use Plugin\MineAdmin\CodeGenerator\Model\FieldSetting;

class FieldSettingCasts implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        $result = [];
        if ($value === null) {
            return $result;
        }
        if (is_string($value)) {
            $attr =  json_decode($value, true);
            foreach ($attr as $item){
                $result[] = new FieldSetting($item);
            }
        }
        return $result;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        $result = [];
        if ($value === null) {
            return $result;
        }
        if (is_string($value)) {
            $attr =  json_decode($value, true);
            foreach ($attr as $item){
                $result[] = new FieldSetting($item);
            }
        }
        if (is_array($value)) {
            foreach ($value as $item) {
                $result[] = new FieldSetting($item);
            }
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

}