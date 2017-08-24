<?php
namespace kaikaige\wxgz;
use yii;
use yii\base\Behavior;
use kaikaige\wxgz\sdk\Wx;

class WxBehavior extends Behavior{
	/**
	 * @var \kaikaige\wxgz\sdk\Wx
	 */
	public $owner;
	
	public function events() {
		return [
			Wx::EVENT_TEXT => 'text',
			Wx::EVENT_SCAN => 'scan',
			Wx::EVENT_VOICE => 'voice'
		];
	}
	
	public function text() {
		$this->owner->getMsg()->text($this->owner->wxPostData['Content']);
	}
	
	public function scan() {
		$this->owner->getMsg()->text('扫描事件');
	}
	
	public function voice() {
		$this->owner->getMsg()->text('暂不支持语音信息');
	}
}