<?php

declare(strict_types=1);

namespace app\modules\orders\models;

use yii\base\Model;

/**
 * Модель поисковой строки
 */
class SearchForm extends Model
{
    public ?string $text = null; // поле ввода
    public ?int $field = null;   // ID поля по которому ищем

    public const ORDER_FIELD_ID = 1; // Order ID
    public const LINK_FIELD_ID = 2;  // Link
    public const USER_FIELD_ID = 3;  // User

    public function rules(): array
    {
        return [
            [['text', 'field'], 'required']
        ];
    }
}
