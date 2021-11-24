<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap4\Html;
use yii\helpers\Url;

Yii::$app->language = 'ru';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $this->registerCssFile('@web/css/bootstrap.min.css') ?>
    <?php $this->registerCssFile('@web/css/custom.css') ?>
    <style>
        .label-default{
            border: 1px solid #ddd;
            background: none;
            color: #333;
            min-width: 30px;
            display: inline-block;
        }
    </style>
    <?php $this->registerJsFile('@web/js/jquery.min.js') ?>
    <?php $this->registerJsFile('@web/js/bootstrap.min.js') ?>
</head>
<body class="">
<?php $this->beginBody() ?>

<nav class="navbar navbar-fixed-top navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
            <ul class="nav navbar-nav">
                <li <?php if(Yii::$app->controller->id === 'default') :?>class="active" <?php endif ?>><a href="<?= Url::to(['/orders/default/index']) ?>"><?= Yii::t('app', 'Orders') ?></a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
