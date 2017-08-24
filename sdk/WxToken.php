<?php

namespace kaikaige\wxgz\sdk;

use Yii;

/**
 * This is the model class for table "wx_token".
 *
 * @property string $name
 * @property string $token
 * @property int $expires_time
 * @property int $access_count
 */
class WxToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['expires_time', 'access_count'], 'integer'],
            [['name', 'token'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'token' => 'Token',
            'expires_time' => 'Expires Time',
            'access_count' => 'Access Count',
        ];
    }
}
