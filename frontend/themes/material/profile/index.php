<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use app\widgets\stream\StreamWidget as Stream;
use app\widgets\target\TargetWidget;
use yii\widgets\Pjax;
use app\widgets\leaderboard\Leaderboard;
use app\modules\target\models\PlayerTargetHelp as PTH;
use app\modules\target\models\Writeup;
use yii\data\ActiveDataProvider;
$query = Writeup::find()->where(['player_id'=>$profile->player_id]);
$provider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 10,
    ],
]);
$game=Yii::$app->getModule('game');
$this->_fluid="-fluid";
$this->title=Yii::$app->sys->event_name.' Profile of: '.Html::encode($profile->owner->username);
$this->_description=Html::encode($profile->bio);
$this->_url=\yii\helpers\Url::to(['index', 'id'=>$profile->id], 'https');
$profile->scenario='validator';
?>
<div class="profile-index">
  <div class="body-content">
<?php if(!$profile->isMine):?>
    <div class="row d-flex justify-content-center">
      <div class="col-xl-9 d-flex justify-content-center">
        <?=Html::img(['profile/badge','id'=>$profile->id], ['class'=>'img-fluid'])?>
      </div>
    </div>
    <div class="row d-flex justify-content-center">
      <div class="col-lg-9 d-flex justify-content-center">
        <p class="h1">
        <?php if(trim($profile->twitter) && $profile->validate('twitter')):?><?=Html::a('<i class="fab fa-twitter text-twitter"></i>', "https://twitter.com/".Html::encode($profile->twitter), ['target'=>'_blank','title'=>"Twitter profile",'rel'=>'noopener noreferrer nofollow'])?><?php endif;?>
        <?php if(trim($profile->github) && $profile->validate('github')):?><?=Html::a('<i class="fab fa-github"></i>', "https://github.com/".Html::encode($profile->github), ['target'=>'_blank','style'=>'color: #808080;','title'=>"Github profile",'rel'=>'noopener noreferrer nofollow'])?><?php endif;?>
        <?php if(trim($profile->htb) && $profile->validate('htb')):?><?=Html::a('<i class="fab fa-codepen text-primary"></i>', "https://www.hackthebox.eu/profile/".Html::encode($profile->htb), ['target'=>'_blank','title'=>"HTB profile",'rel'=>'noopener noreferrer nofolloww'])?><?php endif;?>
        <?php if(trim($profile->twitch) && $profile->validate('twitch')):?><?=Html::a('<i class="fab fa-twitch text-twitch"></i>', "https://twitch.tv/".Html::encode($profile->twitch), ['target'=>'_blank','title'=>"TwitchTV Channel",'rel'=>'nofollow'])?><?php endif;?>
        <?php if(trim($profile->youtube) && $profile->validate('youtube')):?><?=Html::a('<i class="fab fa-youtube text-youtube"></i>', "https://youtube.com/channel/".Html::encode($profile->youtube), ['target'=>'_blank','title'=>"Youtube channel",'rel'=>'noopener noreferrer nofollow'])?><?php endif;?>
        </p>
      </div>
    </div>
<?php endif;?>
    <div class="row d-flex justify-content-center">
      <div class="col-lg-9">
        <?php \yii\widgets\Pjax::begin(['id'=>'target-listing', 'enablePushState'=>false, 'linkSelector'=>'#target-pager a', 'formSelector'=>false]);?>
        <?php echo TargetWidget::widget(['dataProvider' => null, 'player_id'=>$profile->player_id, 'profile'=>$profile, 'title'=>'Progress', 'category'=>'Pending progress of '.Html::encode($profile->owner->username).' on platform targets.', 'personal'=>true,'hidden_attributes'=>['id']]);?>
        <?php \yii\widgets\Pjax::end()?>
      </div>
<?php if($profile->isMine):?>
      <div class="col-xl-3">
      <?=$this->render('_card', ['profile'=>$profile]);?>
      </div><!-- // end profile card col-md-4 -->
<?php endif;?>
    </div>
    <?php if(count($profile->owner->challengeSolvers)>0):?>
    <?=$this->render('_challenge_solves',['profile'=>$profile]);?>
    <?php endif;?>

    <?php if($profile->headshotsCount>0):?>
    <?=$this->render('_headshots',['profile'=>$profile]);?>
    <?php endif;?>

    <?php if($game->badges !== null && $game->badges->received_by($profile->player_id)->count() > 0):?><h3>Badges</h3>
    <div class="row game-badges">
    <?=$this->render('_badges',['game'=>$game,'profile'=>$profile]);?>
    </div>
    <?php endif;?>

    <div class="row">
      <div class="col">
        <?php
        Pjax::begin(['id'=>'global-leaderboard-listing', 'enablePushState'=>false, 'linkSelector'=>'#leaderboard-pager a', 'formSelector'=>false]);
        echo Leaderboard::widget(['divID'=>"Leaderboard", 'player_id'=>$profile->player_id, 'pageSize'=>8, 'title'=>'Global Leaderboard', 'category'=>'Listing current player page on a global scale. <small>Updated every 10 minutes</small>']);
        Pjax::end();
        ?>
      </div>
      <div class="col">
        <?php
        Pjax::begin(['id'=>'country-leaderboard-listing', 'enablePushState'=>false, 'linkSelector'=>'#country-leaderboard-pager a', 'formSelector'=>false]);
        echo Leaderboard::widget(['divID'=>"CountryLeaderboard", 'country'=>$profile->country,'player_id'=>$profile->player_id, 'pageSize'=>8, 'title'=>'Leaderboard for '.$profile->fullCountry->name, 'category'=>'Listing current player page for '.$profile->fullCountry->name.'. <small>Updated every 10 minutes</small>','pagerID'=>'country-leaderboard-pager']);
        Pjax::end();
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col"><?php
      \yii\widgets\Pjax::begin(['id'=>'stream-listing', 'enablePushState'=>false, 'linkSelector'=>'#stream-pager a', 'formSelector'=>false]);
      echo Stream::widget(['divID'=>'stream', 'dataProvider' => null, 'player_id'=>$profile->player_id, 'pagerID'=>'stream-pager','title'=>'User History','category'=>'User history on the platform']);
      \yii\widgets\Pjax::end();
      ?></div>
    </div><!--/row-->

  </div><!--//body-content-->
</div><!--//profile-index-->
