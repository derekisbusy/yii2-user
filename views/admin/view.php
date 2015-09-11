<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use comyii\user\Module;
use comyii\user\models\User;
use comyii\user\widgets\AdminMenu;

/**
 * @var yii\web\View $this
 * @var comyii\user\models\User $model
 */

$m = $this->context->module;
$url = [$m->actionSettings[Module::ACTION_ADMIN_INDEX]];
$this->title =  Yii::t('user', 'Manage User') . ' (' . $model->username . ')';
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Manage Users'), 'url' => $url];
$this->params['breadcrumbs'][] = $model->username;
$list = Html::a($m->icon('list'), $url, ['class'=>'kv-action-btn', 'data-toggle'=>'tooltip', 'title' => Yii::t('user', 'View users listing')]);
$editSettings = $m->getEditSettingsAdmin($model);
$getKey = function($key) use ($model) {
    $settings = [
        'attribute' => $key, 
        'displayOnly' => true, 
        'format' => 'raw', 
        'value' => $model->$key ? '<samp>' . $model->$key . '</samp>' : null
    ];
    return $settings;
};
$attribs1 = [
    [
        'group'=>true,
        'label'=> $m->icon('tag') . ' ' . Yii::t('user', 'Account Details'),
        'rowOptions'=>['class'=>'info']
    ],
    'id',
    'username',
    'email:email',
    [
        'attribute'=> 'status', 
        'format' => 'raw',
        'value' => empty($model->status_sec) ? $model->statusHtml : $model->statusHtml . ' ' . $model->statusSecHtml
    ],
    [
        'attribute'=> 'created_on', 
        'format'=>['datetime', $m->datetimeFormat], 
        'labelColOptions' => ['style'=>'width:40%;text-align:right'] 
    ],
];
$attribs2 = [
    [
        'group'=>true,
        'label'=> $m->icon('time') . ' ' . Yii::t('user', 'User Log Information'),
        'rowOptions'=>['class'=>'info'],
    ],
    [
        'attribute'=> 'updated_on', 
        'format'=>['datetime', $m->datetimeFormat], 
    ],
    [
        'attribute' => 'last_login_ip', 
        'format' => 'raw',
        'value' => $model->last_login_ip ? '<samp>' . $model->last_login_ip . '</samp>' : null,
    ],
    [
        'attribute'=> 'last_login_on', 
        'value' => strtotime($model->last_login_on) ? $model->last_login_on : null,
        'format'=>['datetime', $m->datetimeFormat], 
        'labelColOptions' => ['style'=>'width:40%;text-align:right'] 
    ],
    [
        'attribute'=> 'password_reset_on', 
        'value' => strtotime($model->last_login_on) ? $model->last_login_on : null,
        'format'=>['datetime', $m->datetimeFormat], 
    ],
    'password_fail_attempts'
];
$attribs3 = null;
if ($m->checkSettings($editSettings, 'showHiddenInfo')) {
    $attribs3 = [
        [
            'group'=>true,
            'label'=> $m->icon('lock') . ' ' . Yii::t('user', 'Hidden Information'),
            'rowOptions'=>['class'=>'info']
        ],
        $getKey('password_hash'),
        $getKey('auth_key'),
        $getKey('email_change_key'),
        $getKey('reset_key'),
        $getKey('activation_key'),
    ];
}
?>
<div class="page-header">
    <div class="pull-right"><?= AdminMenu::widget(['ui' => 'manage', 'user' => $model]) ?></div>
    <h1><?= $this->title ?></h1>
</div>
<div class="row">
    <div class="col-md-6">
        <?= DetailView::widget([
            'model' => $model,
            'striped' => false,
            'hover' => true, 
            'enableEditMode' => false,
            'attributes' => $attribs1 
        ]) ?>   
    </div>
    <div class="col-md-6">
        <?= DetailView::widget([
            'model' => $model,
            'striped' => false,
            'hover' => true, 
            'enableEditMode' => false,
            'attributes' => $attribs2 
        ]) ?>
    </div>
</div>    
<?php 
    if ($attribs3 !== null) {
        echo DetailView::widget([
            'model' => $model,
            'striped' => false,
            'hover' => true, 
            'enableEditMode' => false,
            'attributes' => $attribs3 
        ]);
    }
?>