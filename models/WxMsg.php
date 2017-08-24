<?php

namespace app\components\wx;

use Yii;

/**
 * This is the model class for table "wx_msg".
 *
 * @property integer $id
 * @property string $appid
 * @property integer $status
 * @property integer $template_id
 * @property string $content
 * @property integer $errcode
 * @property string $errmsg
 * @property integer $msgid
 * @property string $create_time
 * @property string $send_time
 * @property string $touser
 */
class WxMsg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_msg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appid', 'status', 'template_id', 'errcode', 'errmsg', 'create_time'], 'required'],
            [['status', 'template_id', 'errcode', 'msgid'], 'integer'],
            [['create_time', 'send_time'], 'safe'],
            [['appid', 'errmsg', 'touser'], 'string', 'max' => 255],
            [['content'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appid' => '应用id',
            'status' => '1发送成功，2发送失败，3已发送，待返回，4用户拒收，5微信系统问题',
            'template_id' => '模板id',
            'content' => 'Content',
            'errcode' => '错误代码',
            'errmsg' => '异常信息',
            'msgid' => '消息id',
            'create_time' => '创建时间',
            'send_time' => 'Send Time',
            'touser' => 'Touser',
        ];
    }
}
