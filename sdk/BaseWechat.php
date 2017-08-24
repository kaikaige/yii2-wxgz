<?php
namespace kaikaige\wxgz\sdk;

use yii\base\Component;
use yii\base\InvalidConfigException;

class BaseWechat extends Component {
	/**
	 * @var Wx
	 */
	public $wx;
	
	public function init() {
		parent::init();
// 		if ($this->wx === null) {
// 			throw new InvalidConfigException('The wx property must be set.');
// 		}
	}
}