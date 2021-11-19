<?php

declare(strict_types=1);
/**
 * @var \app\modules\orders\models\OrderWithUserDataDTO[] $orders
 * @var \yii\data\Pagination $pagination
 * @var \app\modules\orders\models\ServiceDTO[] $services
 *
 * @var int|null $status
 * @var int|null $serviceId
 * @var int|null $mode
 * @var int|null $totalCountWithoutFilters
 */

use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<ul class="nav nav-tabs p-b">
    <li <?php if ($status === null): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index'])?>">All orders</a></li>
    <li <?php if ($status === 0): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'status' => 0])?>">Pending</a></li>
    <li <?php if ($status === 1): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'status' => 1])?>">In progress</a></li>
    <li <?php if ($status === 2): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'status' => 2])?>">Completed</a></li>
    <li <?php if ($status === 3): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'status' => 3])?>">Canceled</a></li>
    <li <?php if ($status === 4): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'status' => 4])?>">Error</a></li>
    <li class="pull-right custom-search">
        <form class="form-inline" action="/admin/orders" method="get">
            <div class="input-group">
                <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
                <span class="input-group-btn search-select-wrap">
                    <select class="form-control search-select" name="search-type">
                      <option value="1" selected="">Order ID</option>
                      <option value="2">Link</option>
                      <option value="3">Username</option>
                    </select>
                    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                </span>
            </div>
        </form>
    </li>
</ul>

<table class="table order-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Link</th>
        <th>Quantity</th>
        <th class="dropdown-th">
            <div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Service
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li <?php if ($serviceId === null): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'service' => null, 'mode' => $mode])?>">All (<?= $totalCountWithoutFilters ?>)</a></li>
                    <?php foreach($services as $service): ?>
                        <li <?php if ($service->getId() === $serviceId): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'service' => $service->getId(), 'mode' => $mode])?>"><span class="label-id"><?= $service->getCount() ?></span> <?= $service->getName() ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </th>
        <th>Status</th>
        <th class="dropdown-th">
            <div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Mode
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li <?php if ($mode === null): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'mode' => null, 'service' => $serviceId])?>">All</a></li>
                    <li <?php if ($mode === 0): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'mode' => 0, 'service' => $serviceId])?>">Manual</a></li>
                    <li <?php if ($mode === 1): ?>class="active"<?php endif;?>><a href="<?= Url::to(['default/index', 'mode' => 1, 'service' => $serviceId])?>">Auto</a></li>
                </ul>
            </div>
        </th>
        <th>Created</th>
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
