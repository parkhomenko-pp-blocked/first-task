<?php

declare(strict_types=1);

namespace app\modules\orders\models;

class OrderWithUserDataDTO
{
    private int $id;
    private string $user;
    private string $link;
    private int $quantity;
    private string $status;
    private string $mode;
    private string $created;
    private ServiceDTO $service;

    public function __construct(
        int $id,
        string $user,
        string $link,
        int $quantity,
        ServiceDTO $service,
        string $status,
        string $mode,
        string $created,
    ) {
        $this->id = $id;
        $this->user = $user;
        $this->link = $link;
        $this->quantity = $quantity;
        $this->service = $service;
        $this->status = $status;
        $this->mode = $mode;
        $this->created = $created;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function getService(): ServiceDTO
    {
        return $this->service;
    }
}