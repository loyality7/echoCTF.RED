<?php

namespace app\modules\game\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use app\models\Player;
use app\modules\target\models\Target;
use yii\behaviors\AttributeTypecastBehavior;

/**
 * This is the model class for table "headshot".
 *
 * @property int $player_id
 * @property int $target_id
 * @property string|null $created_at
 *
 * @property Player $player
 * @property Target $target
 */
class Headshot extends \yii\db\ActiveRecord
{
  public $average=0;
  public function behaviors()
  {
      return [
          'typecast' => [
              'class' => AttributeTypecastBehavior::className(),
              'attributeTypes' => [
                  'target_id' => AttributeTypecastBehavior::TYPE_INTEGER,
                  'player_id' => AttributeTypecastBehavior::TYPE_INTEGER,
                  'timer' =>  AttributeTypecastBehavior::TYPE_INTEGER,
              ],
              'typecastAfterValidate' => true,
              'typecastBeforeSave' => true,
              'typecastAfterFind' => true,
        ],
        [
              'class' => TimestampBehavior::className(),
              'createdAtAttribute' => 'created_at',
              'value' => new Expression('NOW()'),
        ],
      ];
  }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'headshot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['player_id', 'target_id'], 'required'],
            [['player_id', 'target_id','timer'], 'integer'],
            [['created_at','timer'], 'safe'],
            [['player_id', 'target_id'], 'unique', 'targetAttribute' => ['player_id', 'target_id']],
            [['player_id'], 'exist', 'skipOnError' => true, 'targetClass' => Player::className(), 'targetAttribute' => ['player_id' => 'id']],
            [['target_id'], 'exist', 'skipOnError' => true, 'targetClass' => Target::className(), 'targetAttribute' => ['target_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'player_id' => Yii::t('app', 'Player ID'),
            'target_id' => Yii::t('app', 'Target ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'timer' => Yii::t('app', 'Timer'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Player::className(), ['id' => 'player_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarget()
    {
        return $this->hasOne(Target::className(), ['id' => 'target_id']);
    }

    /**
     * {@inheritdoc}
     * @return HeadshotQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HeadshotQuery(get_called_class());
    }
}
