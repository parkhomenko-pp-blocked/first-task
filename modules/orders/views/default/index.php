<?php

declare(strict_types=1);

const ORDERS_STATUS_ALL = null;
const ORDERS_STATUS_PENDING = 0;
const ORDERS_STATUS_IN_PROGRESS = 1;
const ORDERS_STATUS_COMPLETED = 2;
const ORDERS_STATUS_CANCELED = 3;
const ORDERS_STATUS_ERROR = 4;

const MODE_STATUS_ALL = null;
const MODE_STATUS_MANUAL = 0;
const MODE_STATUS_AUTO = 1;
/**
 * @var \app\modules\orders\models\OrderWithUserDataDTO[] $orders
 * @var \yii\data\Pagination $pagination
 * @var \app\modules\orders\models\ServiceDTO[] $services
 * @var \app\modules\orders\models\SearchForm|null $searchModel
 *
 * @var int|null $status
 * @var int|null $serviceId
 * @var int|null $mode
 * @var int|null $totalCountWithoutFilters
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

?>
<ul class="nav nav-tabs p-b">
    <li <?php if ($status === ORDERS_STATUS_ALL): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index'])?>"><?= Yii::t('app', 'All orders') ?></a></li>
    <li <?php if ($status === ORDERS_STATUS_PENDING): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'status' => ORDERS_STATUS_PENDING])?>"><?= Yii::t('app', 'Pending') ?></a></li>
    <li <?php if ($status === ORDERS_STATUS_IN_PROGRESS): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'status' => ORDERS_STATUS_IN_PROGRESS])?>"><?= Yii::t('app', 'In progress') ?></a></li>
    <li <?php if ($status === ORDERS_STATUS_COMPLETED): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'status' => ORDERS_STATUS_COMPLETED])?>"><?= Yii::t('app', 'Completed') ?></a></li>
    <li <?php if ($status === ORDERS_STATUS_CANCELED): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'status' => ORDERS_STATUS_CANCELED])?>"><?= Yii::t('app', 'Canceled') ?></a></li>
    <li <?php if ($status === ORDERS_STATUS_ERROR): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'status' => ORDERS_STATUS_ERROR])?>"><?= Yii::t('app', 'Error') ?></a></li>
    <li class="pull-right custom-search">
        <?php $form = ActiveForm::begin(['class' => 'form-inline']) ?>
            <div class="input-group">
                <?= $form->field($searchModel, 'text')->label(false)->textInput(['placeholder' => Yii::t('app', 'Search Orders')]) ?>
                <span class="input-group-btn search-select-wrap">
                    <?= $form->field($searchModel, 'field')->label(false)
                        ->dropDownList([
                                           '1' => 'Order ID',
                                           '2' => 'Link',
                                           '3' => 'Username'
                                       ], ['class' => 'form-control search-select']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>', ['class' => 'btn btn-default', 'type' => 'submit']) ?>
                    </div>
                </span>
            </div>
        <?php ActiveForm::end() ?>
    </li>
</ul>

<table class="table order-table">
    <thead>
    <tr>
        <th><?= Yii::t('app', 'ID') ?></th>
        <th><?= Yii::t('app', 'User') ?></th>
        <th><?= Yii::t('app', 'Link') ?></th>
        <th><?= Yii::t('app', 'Quantiry') ?></th>
        <th class="dropdown-th">
            <div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?= Yii::t('app', 'Service') ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li <?php if ($serviceId === null): ?>class="active"<?php endif;?>>
                        <a href="<?= Url::to(['default/index', 'service' => null, 'mode' => $mode])?>">
                            <?= Yii::t('app', 'All') ?> (<?= $totalCountWithoutFilters ?>)
                        </a>
                    </li>
                    <?php foreach($services as $service): ?>
                        <li <?php if ($service->getId() === $serviceId): ?>class="active"<?php endif;?>>
                            <a href="<?= Url::to(['default/index', 'service' => $service->getId(), 'mode' => $mode, 'search' => $searchModel->text, 'searchFieldId' => $searchModel->field])?>">
                                <span class="label-id"><?= $service->getCount() ?></span> <?= $service->getName() ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </th>
        <th><?= Yii::t('app', 'Status') ?></th>
        <th class="dropdown-th">
            <div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?= Yii::t('app', 'Mode') ?>
                    <span class="caret"></span>
                </button>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li <?php if ($mode === MODE_STATUS_ALL): ?>class="active"<?php endif;?>>
                        <a href="<?= Url::to(['default/index', 'mode' => MODE_STATUS_ALL, 'service' => $serviceId, 'formSearch' => $searchModel])?>">
                            <?= Yii::t('app', 'All') ?>
                        </a>
                    </li>

                    <li <?php if ($mode === MODE_STATUS_MANUAL): ?>class="active"<?php endif;?>>
                        <a href="<?= Url::to(['default/index', 'mode' => MODE_STATUS_MANUAL, 'service' => $serviceId, 'formSearch' => $searchModel])?>">
                            <?= Yii::t('app', 'Manual') ?>
                        </a>
                    </li>

                    <li <?php if ($mode === MODE_STATUS_AUTO): ?>class="active"<?php endif;?>>
                        <a href="<?= Url::to(['default/index', 'mode' => MODE_STATUS_AUTO, 'service' => $serviceId, 'formSearch' => $searchModel])?>">
                            <?= Yii::t('app', 'Auto') ?>
                        </a>
                    </li>
                </ul>
            </div>
        </th>
        <th><?= Yii::t('app', 'Created') ?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order->getId() ?></td>
                <td><?= $order->getUser() ?></td>
                <td class="link"><?= $order->getLink() ?></td>
                <td><?= $order->getQuantity() ?></td>
                <td class="service">
                    <span class="label-id"><?= $order->getService()->getCount() ?></span> <?=$order->getService()->getName()?>
                </td>
                <td><?= $order->getStatus() ?></td>
                <td><?= $order->getMode() ?></td>
                <td><span class="nowrap"><?= $order->getCreated() ?></span></td>
<!--                <td><span class="nowrap">2016-01-27</span><span class="nowrap">15:13:52</span></td>-->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="row">
    <div class="col-sm-8">
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>

    <div class="col-sm-4 pagination-counters">
        <?= $pagination->totalCount ?>
    </div>
</div>
