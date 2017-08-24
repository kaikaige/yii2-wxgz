<?php

namespace kaikaige\wxgz\models;

use Yii;

/**
 * This is the model class for table "wx_log_gateway".
 *
 * @property int $id
 * @property string $type
 * @property string $get_data
 * @property string $post_data
 * @property string $return_xml
 * @property string $create_time
 */
class WxLogGateway extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_log_gateway';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['get_data', 'post_data', 'return_xml'], 'string'],
            [['create_time'], 'safe'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'get_data' => 'Get Data',
            'post_data' => 'Post Data',
            'return_xml' => 'Return Xml',
            'create_time' => 'Create Time',
        ];
    }
}
