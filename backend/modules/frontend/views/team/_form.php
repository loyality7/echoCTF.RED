<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\frontend\models\Player;
use app\widgets\sleifer\autocompleteAjax\AutocompleteAjax;

/* @var $this yii\web\View */
/* @var $model app\modules\frontend\models\Team */
/* @var $form yii\widgets\ActiveForm */

if (Yii::$app->sys->academic_grouping !== false) {
  for ($i = 0; $i < intval(Yii::$app->sys->academic_grouping); $i++) {
    $filter[] = Yii::$app->sys->{"academic_" . $i . "short"};
  }
} else {
  $filter = [];
}

?>

<div class="team-form">

  <?php $form = ActiveForm::begin(); ?>
  <div class="row">
    <div class="col-md-4"><?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint('The name of the team (will be shown on scoreboards, streams and other public locations)') ?></div>
    <div class="col-md-4"><?= $form->field($model, 'owner_id')->widget(AutocompleteAjax::class, [
                            'multiple' => false,
                            'url' => ['/frontend/player/ajax-search'],
                            'options' => ['placeholder' => 'Find player by email, username, id or profile.']
                          ])->Label('Owner')->hint('Choose the player who will be the owner of the team') ?>
    </div>
    <div class="col-md-4"><?= $form->field($model, 'token')->textInput(['maxlength' => true])->hint('A token to be given to other players so they may join the team (automatically generated by the applicaion)') ?></div>
  </div>
  <div class="row">
    <?php if (\Yii::$app->sys->academic_grouping !== false): ?>
      <div class="col-md-6"><?= $form->field($model, 'academic')->dropDownList($filter)->hint('Whether the player is gov, edu or org') ?></div>
    <?php else: ?>
      <div class="col-md-6"><?= $form->field($model, 'academic')->textInput()->hint('Whether the player is gov, edu or org') ?></div>
    <?php endif; ?>
    <div class="col-md-3"><?= $form->field($model, 'inviteonly')->checkbox()->hint('Whether the team is inviteonly on listings') ?></div>
    <div class="col-md-3"><?= $form->field($model, 'locked')->checkbox()->hint('Whether the team is locked (eg no new members can join)') ?></div>
  </div>
  <div class="row">
    <div class="col-md-6"><?= $form->field($model, 'recruitment')->textArea()->hint('Recruitment text for new members') ?></div>
    <div class="col-md-6"><?= $form->field($model, 'description')->textArea()->hint('A description of the team') ?></div>
  </div>

  <div class="form-group text-center">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>