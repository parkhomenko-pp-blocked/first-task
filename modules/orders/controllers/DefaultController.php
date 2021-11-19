<?php

declare(strict_types=1);

namespace app\modules\orders\controllers;

use app\modules\orders\models\Order;
use app\modules\orders\models\OrderWithUserDTOFactory;
use app\modules\orders\models\ServiceDTOFactory;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\Controller;

/**
 * Default controller for the `orders` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $query = Order::find();

        $pagination = new Pagination(
            [
                'pageSize' => 100,
                'totalCount'      => $query->count()
            ]
        );

        $arServices = (new Query())
            ->select([
                         'services.id as service_id',
                         'services.name as service_name',
                         'COUNT(orders.id) AS service_count'
                     ])
            ->from('orders')
            ->innerJoin('services', 'orders.service_id = services.id')
            ->groupBy('service_id')
            ->orderBy('service_count DESC')
            ->all();
        $serviceFactory = new ServiceDTOFactory();
        $services = $serviceFactory->fromDBArrayToArray($arServices);

        $arOrders = (new Query())
            ->select([
                         'orders.id as order_id',
                         'CONCAT(users.first_name, \' \', users.last_name) AS user',
                         'orders.link as order_link',
                         'orders.quantity as order_quantity',
                         'orders.service_id as order_service_id',
                         'orders.status as order_status',
                         'orders.mode as order_mode',
                         'orders.created_at as order_created_at'
                     ])
            ->from('orders')
            ->innerJoin('users', 'users.id = orders.user_id')
            ->orderBy(['orders.id' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $ordersFactory = new OrderWithUserDTOFactory($services);
        $orders = $ordersFactory->fromArrayToArray($arOrders);

        return $this->render('index', [
            'orders' => $orders,
            'pagination' => $pagination,
            'services' => $services
        ]);
    }
}
