<?php

declare(strict_types=1);

namespace app\modules\orders\models;

class ServiceDTO
{
    private int $count;
    private string $name;

    public function __construct(int $count, string $name)
    {
        $this->count = $count;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}