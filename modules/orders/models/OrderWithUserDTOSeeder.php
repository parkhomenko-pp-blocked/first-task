<?php

declare(strict_types=1);

namespace app\modules\orders\models;

class OrderWithUserDTOSeeder
{
    /**
     * @param OrderWithUserDataDTO[] $orders
     * @return string - path to file
     */
    public function toCSVFile(array $orders, string $folder): string
    {
        if (!mkdir($folder) && !is_dir($folder)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $folder));
        }

        $path = sprintf('%sorders-%s.csv', $folder, gmdate("Y-m-d-H-i-s"));

        file_put_contents($path, 'id;user;link;quantity;service;order;crated_at' . PHP_EOL);

        array_map(static function ($order) use ($path) {
            $service = $order->getService();

            file_put_contents($path,
                sprintf('%d;%s;%s;%d;(%d) %s;%s;%s',
                        $order->getId(),
                        $order->getUser(),
                        $order->getLink(),
                        $order->getQuantity(),
                        $service->getCount(), //
                        $service->getName(),  //
                        $order->getMode(),
                        gmdate("Y-m-d H:i:s", $order->getCreated())
                ) . PHP_EOL,
                FILE_APPEND
            );
        }, $orders);

        return $path;
    }
}