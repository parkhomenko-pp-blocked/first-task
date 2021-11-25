<?php

declare(strict_types=1);

namespace app\modules\orders\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\base\Model;
use yii\data\Pagination;
use yii\db\Query;

/**
 *
 * @property-read ServiceDTO[] $services
 * @property-read Query $ordersQuery
 * @property-write array $params
 */
class OrderSearch extends Model
{
    public ?int $status = null;

    private SearchForm $searchModel;

    public ?int $service = null;
    public ?int $mode = null;

    public function setParams(array $arParams): void
    {
        $this->status = !isset($arParams['status']) ? null : (int)$arParams['status'];

        $this->searchModel = new SearchForm();
        if (Yii::$app->request->isPost) {
            $this->searchModel->load(Yii::$app->request->post());
        } elseif (isset($arParams['search'], $arParams['searchFieldId'])) {
            $this->searchModel->load(['text' => $arParams['search'], 'field' => (int)$arParams['searchFieldId']]);
        }

        $this->service = !isset($arParams['service']) ? null : (int)$arParams['service'];
        $this->mode = !isset($arParams['mode']) ? null : (int)$arParams['mode'];
    }

    #[ArrayShape([
        'orders'                   => "\app\modules\orders\models\OrderWithUserDataDTO[]",
        'pagination'               => Pagination::class,
        'services'                 => "\app\modules\orders\models\ServiceDTO[]",
        'serviceId'                => "int|null",
        'mode'                     => "int|null",
        'status'                   => "int|null",
        'totalCountWithoutFilters' => "mixed",
        'searchModel'              => SearchForm::class
    ])]
    public function search(): array
    {
        $services = $this->getServices();
        $ordersQuery = $this->getOrdersQuery();

        $pagination = new Pagination(
            [
                'pageSize' => 100,
                'totalCount' => $ordersQuery->count()
            ]
        );

        $arOrders = $ordersQuery
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->all();
        $ordersFactory = new OrderWithUserDTOFactory($services);
        $orders = $ordersFactory->fromArrayToArray($arOrders);

        return [
            'orders' => $orders,
            'pagination' => $pagination,
            'services' => $services,
            'serviceId' => $this->service,
            'mode' => $this->mode,
            'status' => $this->status,
            'totalCountWithoutFilters' => Order::find()->count(),
            'searchModel' => $this->searchModel
        ];
    }

    /**
     * @return string - path to file
     */
    public function download(): string
    {
        $ordersQuery = $this->getOrdersQuery();
        $arOrders = $ordersQuery
            ->all();
        $ordersFactory = new OrderWithUserDTOFactory($this->getServices());
        $orders = $ordersFactory->fromArrayToArray($arOrders);

        $seeder = new OrderWithUserDTOSeeder();
        return $seeder->toCSVFile($orders, Yii::getAlias('@webroot') . '/csv/');
    }

    /**
     * @return Query
     */
    private function getOrdersQuery(): Query
    {
        $searchDataFilter = [];
        if ($this->searchModel->validate()) {
            switch ($this->searchModel->field) {
                case SearchForm::ORDER_FIELD_ID:
                    $searchDataFilter = ['in', 'orders.id', $this->searchModel->text];
                    break;
                case SearchForm::LINK_FIELD_ID:
                    $searchDataFilter = ['like', 'orders.link', $this->searchModel->text];
                    break;
                case SearchForm::USER_FIELD_ID:
                    $searchDataFilter = ['like', 'CONCAT(users.first_name, \' \', users.last_name)', $this->searchModel->text];
                    break;
            }
        }

        return (new Query())
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
            ->filterWhere([
                              'orders.status' => $this->status,
                              'orders.service_id' => $this->service,
                              'orders.mode' => $this->mode
                          ])
            ->andFilterWhere($searchDataFilter)
            ->innerJoin('users', 'users.id = orders.user_id')
            ->orderBy(['orders.id' => SORT_DESC]);
    }

    /**
     * @return ServiceDTO[]
     */
    private function getServices(): array
    {
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
        return $serviceFactory->fromDBArrayToArray($arServices);
    }
}
