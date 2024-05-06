<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\frontend\models\PlayerMetadata $model */

$this->title = Yii::t('app', 'Update Player Metadata: {name}', [
    'name' => $model->player_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Player Metadatas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->player_id, 'url' => ['view', 'player_id' => $model->player_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
yii\bootstrap5\Modal::begin([
  'title' => '<h2><i class="bi bi-info-circle-fill"></i> '.Html::encode($this->title).' Help</h2>',
  'toggleButton' => ['label' => '<i class="bi bi-info-circle-fill"></i> Help', 'class' => 'btn btn-info'],
'options'=>['class'=>'modal-lg']
]);
echo yii\helpers\Markdown::process($this->render('help/'.$this->context->action->id), 'gfm');
yii\bootstrap5\Modal::end();

?>
<div class="player-metadata-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
