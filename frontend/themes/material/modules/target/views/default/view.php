<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use app\widgets\stream\StreamWidget as Stream;
$this->title=Yii::$app->sys->event_name.' Target: '.$target->name. ' / '.long2ip($target->ip);
$this->_description=$target->purpose;
$this->_image=\yii\helpers\Url::to($target->fullLogo, 'https');
$this->_url=\yii\helpers\Url::to(['view', 'id'=>$target->id], 'https');
$this->_fluid='-fluid';
Url::remember();
?>

<div class="target-index">
  <div class="body-content">
<?php if(!Yii::$app->user->isGuest):?>
  <?php if(Yii::$app->user->identity->instance !== NULL && Yii::$app->user->identity->instance->target_id===$target->id):?>
    <div>
      <?php if(Yii::$app->user->identity->instance->reboot===0 && Yii::$app->user->identity->instance->ip===null):?>
        <p class="text-warning">Your private instance is being powered up.</p>
      <?php elseif(Yii::$app->user->identity->instance->reboot===2):?>
        <p class="text-danger">Your private instance is scheduled to be powered off.</p>
      <?php else:?>
        <p class="text-info">Your private instance is up and running.</p>
      <?php endif;?>
    </div>
  <?php elseif($target->ondemand && $target->ondemand->state<0):?>
    <div><p class="text-info">This target is currently powered off. <em>Connect to the VPN to be allowed to power the system up.</em></p></div>
  <?php elseif($target->ondemand && $target->ondemand->state>0):?>
    <div><p class="text-danger">The target will shutdown in <code id="countdown" data="<?=$target->ondemand->expired?>"></code></p></div>
  <?php endif;?>
<?php endif;?>
<?php if($target->status !== 'online'):?>
    <div><p class="text-warning"><code class="text-warning">Target <?php if ($target->scheduled_at!==null):?>scheduled for<?php endif;?> <b><?=$target->status?></b> <?php if ($target->scheduled_at!==null):?> <abbr title="<?=\Yii::$app->formatter->asDatetime($target->scheduled_at,'long')?>"><?=\Yii::$app->formatter->asRelativeTime($target->scheduled_at)?></abbr><?php endif;?></code></p></div>
<?php endif;?>
<?php if($target->network):?>
    <div><p class="text-info">Target from: <b><?=Html::a($target->network->name,['/network/default/view','id'=>$target->network->id])?></b></p></div>
<?php endif;?>

<div class="watermarked img-fluid">
<img src="<?=$target->logo?>" width="100px"/>
</div>

<?php
if(Yii::$app->user->isGuest)
  echo $this->render('_guest', ['target'=>$target, 'playerPoints'=>$playerPoints,'streamProvider'=>$streamProvider->getTotalCount()]);
else
{
  echo $this->render('_versus', ['target'=>$target, 'playerPoints'=>$playerPoints, 'identity'=>Yii::$app->user->identity->profile]);

  \yii\widgets\Pjax::begin(['id'=>'stream-listing', 'enablePushState'=>false, 'linkSelector'=>'#stream-pager a', 'formSelector'=>false]);
  echo Stream::widget(['divID'=>'target-activity', 'dataProvider' => $streamProvider, 'pagerID'=>'stream-pager', 'title'=>'Target activity', 'category'=>'Latest activity on the target']);
  \yii\widgets\Pjax::end();
}
?>

  </div>
</div>
<?php
if($target->ondemand && $target->ondemand->state>0 && !Yii::$app->user->isGuest) $this->registerJs(
    'var distance = $("#countdown").attr("data");
    var countdown = setInterval(function() {
      var minutes = Math.floor((distance % (60 * 60)) / ( 60));
      var seconds = Math.floor((distance % (60)));
      if (distance < 0) {
        clearInterval(countdown);
        document.getElementById("countdown").innerHTML = "system will shutdown soon!";
      }
      else {
        document.getElementById("countdown").innerHTML = minutes + "m " + seconds + "s ";
        $("#countdown").attr("data",distance--);
      }
    }, 1000);',
    4
);
