<?php

namespace app\modules\orders\controllers;

use app\modules\orders\models\Order;
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

        $orders = $query
            ->orderBy(['id'=>SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $services = (new \yii\db\Query())
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

        return $this->render('index', [
            'orders' => $orders,
            'pagination' => $pagination,
            'services' => $services
        ]);
    }
}
