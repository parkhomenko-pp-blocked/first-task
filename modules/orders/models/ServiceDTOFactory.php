<?php

declare(strict_types=1);

namespace app\modules\orders\models;

class ServiceDTOFactory
{
    /**
     * @param array $arServices
     * @return ServiceDTO[]
     */
    public function fromDBArrayToArray(array $arServices): array
    {
        $services = [];

        foreach ($arServices as $arService) {
            $services[$arService['service_id']] = new ServiceDTO(
                (int)$arService['service_id'],
                (int)$arService['service_count'],
                $arService['service_name'],
            );
        }

        return $services;
    }
}