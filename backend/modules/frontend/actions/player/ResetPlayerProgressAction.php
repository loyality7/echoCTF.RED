<?php
namespace app\modules\frontend\actions\player;

use Yii;

use app\modules\frontend\models\Player;
use app\modules\frontend\models\Team;
use app\modules\frontend\models\TeamPlayer;
use app\modules\frontend\models\PlayerSsl;
use app\modules\frontend\models\PlayerSearch;
use app\modules\settings\models\Sysconfig;

class ResetPlayerProgressAction extends \yii\base\Action
{
  public function run()
  {
    try
    {
      \Yii::$app->db->createCommand("CALL reset_player_progress()")->execute();
      Yii::$app->session->setFlash('success', 'Successfully reseted all player progress');
    }
    catch(\Exception $e)
    {
      Yii::$app->session->setFlash('error', 'Failed to reset player progress');
    }
    return $this->controller->redirect(['index']);

  }
}
