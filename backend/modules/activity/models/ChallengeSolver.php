<?php

namespace app\modules\activity\models;

use Yii;
use app\modules\gameplay\models\Challenge;
use app\modules\frontend\models\Player;

/**
 * This is the model class for table "challenge_solver".
 *
 * @property int $challenge_id
 * @property int $player_id
 * @property int|null $timer
 * @property int|null $rating
 * @property string|null $created_at
 *
 * @property Challenge $challenge
 * @property Player $player
 */
class ChallengeSolver extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'challenge_solver';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['challenge_id', 'player_id'], 'required'],
            [['challenge_id', 'player_id', 'timer', 'rating'], 'integer'],
            [['created_at'], 'safe'],
            [['challenge_id', 'player_id'], 'unique', 'targetAttribute' => ['challenge_id', 'player_id']],
            [['challenge_id'], 'exist', 'skipOnError' => true, 'targetClass' => Challenge::className(), 'targetAttribute' => ['challenge_id' => 'id']],
            [['player_id'], 'exist', 'skipOnError' => true, 'targetClass' => Player::className(), 'targetAttribute' => ['player_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'challenge_id' => 'Challenge ID',
            'player_id' => 'Player ID',
            'timer' => 'Timer',
            'rating' => 'Rating',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Challenge]].
     *
     * @return \yii\db\ActiveQuery|ChallengeQuery
     */
    public function getChallenge()
    {
        return $this->hasOne(Challenge::className(), ['id' => 'challenge_id']);
    }

    /**
     * Gets query for [[Player]].
     *
     * @return \yii\db\ActiveQuery|PlayerQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Player::className(), ['id' => 'player_id']);
    }

    /**
     * {@inheritdoc}
     * @return ChallengeSolverQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChallengeSolverQuery(get_called_class());
    }
}
