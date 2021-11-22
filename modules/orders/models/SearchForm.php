<?php

declare(strict_types=1);

namespace app\modules\orders\models;

use yii\base\Model;

class SearchForm extends Model
{
    public $text;
    public $field;

    public const ORDER_FIELD_ID = 1;
    public const LINK_FIELD_ID = 2;
    public const USER_FIELD_ID = 3;

    public function rules()
    {
        return [
            [['text', 'field'], 'required']
        ];
    }

    public function isAttributesSetted(): bool
    {
        return isset($this->text, $this->field);
    }
}