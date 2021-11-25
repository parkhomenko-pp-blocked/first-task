<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * Redirect to orders
     *
     * @return Response
     */
    public function actionIndex(): Response
    {
        return $this->redirect(Url::to(['/orders/default/index']));
    }
}
