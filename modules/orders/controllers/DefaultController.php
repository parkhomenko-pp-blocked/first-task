<?php

declare(strict_types=1);

namespace app\modules\orders\controllers;

use app\modules\orders\models\Order;
use app\modules\orders\models\OrderSearch;
use app\modules\orders\models\OrderWithUserDTOFactory;
use app\modules\orders\models\OrderWithUserDTOSeeder;
use app\modules\orders\models\SearchForm;
use app\modules\orders\models\ServiceDTO;
use app\modules\orders\models\ServiceDTOFactory;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\Controller;
use yii\web\Response as WebResponse;
use yii\console\Response as ConsoleResponse;

/**
 * Default controller for the `orders` module
 *
 * @property-read ServiceDTO[] $services
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex(): string
    {
        $model = new OrderSearch();
        $model->setParams(Yii::$app->request->get());

        return $this->render('index', $model->search());
    }

    /**
     * @return WebResponse|ConsoleResponse
     */
    public function actionDownload(): WebResponse|ConsoleResponse
    {
        $model = new OrderSearch();
        $model->setParams(Yii::$app->request->get());

        return Yii::$app->response->sendFile($model->download());
    }
}
