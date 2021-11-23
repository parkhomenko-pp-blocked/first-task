<?php

namespace app\modules\orders\models;

use Throwable;

class OrderWithUserDTOFactory
{
    private const STATUES = [
        0 => 'Pending',
        1 => 'In progress',
        2 => 'Completed',
        3 => 'Canceled',
        4 => 'Fail'
    ];

    private const MODES = [
        0 => 'Manual',
        1 => 'Auto'
    ];
    /**
     * @var ServiceDTO[]
     */
    private array $services;

    /**
     * @param ServiceDTO[] $services
     */
    public function __construct(array $services)
    {
        $this->services = $services;
    }

    /**
     * @param array $arOrders
     * @return OrderWithUserDataDTO[]
     */
    public function fromArrayToArray(array $arOrders): array
    {
        $orders = [];

        foreach ($arOrders as $arOrder) {
            $orders[] = new OrderWithUserDataDTO(
                $arOrder['order_id'],
                $arOrder['user'],
                $arOrder['order_link'],
                $arOrder['order_quantity'],
                $this->services[$arOrder['order_service_id']],
                self::STATUES[$arOrder['order_status']],
                self::MODES[$arOrder['order_mode']],
                $arOrder['order_created_at'],
            );
        }

        return $orders;
    }
}