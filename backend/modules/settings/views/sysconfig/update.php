<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\settings\models\Sysconfig */

$this->title='Update Sysconfig: '.$model->id;
$this->params['breadcrumbs'][]=ucfirst(Yii::$app->controller->module->id);
$this->params['breadcrumbs'][]=['label' => 'Sysconfigs', 'url' => ['index']];
$this->params['breadcrumbs'][]=['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][]='Update';
yii\bootstrap\Modal::begin([
    'header' => '<h2><span class="glyphicon glyphicon-question-sign"></span> '.$this->title.' Help</h2>',
    'toggleButton' => ['label' => '<span class="glyphicon glyphicon-question-sign"></span> Help','class'=>'btn btn-info'],
]);
echo $this->render('help/'.$this->context->action->id);
yii\bootstrap\Modal::end();
?>
<div class="sysconfig-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
