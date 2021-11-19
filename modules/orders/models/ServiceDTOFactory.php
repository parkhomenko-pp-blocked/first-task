<?php

namespace app\modules\orders\models;

use Throwable;

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
            try {
                $services[$arService['service_id']] = new ServiceDTO(
                    $arService['service_count'],
                    $arService['service_name'],
                );
            } catch (Throwable) {

            }
        }

        return $services;
    }
}