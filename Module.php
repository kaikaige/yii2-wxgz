<?php

namespace kaikaige\wxgz;

use Yii;
use kaikaige\wxgz\sdk\Wx;

/**
 * Ms module definition class
 */
class Module extends \yii\base\Module {
	
	
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'kaikaige\wxgz\controllers';
    
    public $defaultRoute = 'gateway';
    
    /**
     * @var \kaikaige\wxgz\sdk\Wx
     */
    public $wx = 'wx'; 
    
    /**
     * 
     * @var array
     */
    public $wxConfig;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->wx = Yii::$app->get($this->wx);
    }
}
