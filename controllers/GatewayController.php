<?php
namespace kaikaige\wxgz\controllers;

use yii;
class GatewayController extends BaseController {
	/**
	 * @var \kaikaige\wxgz\sdk\Wx
	 */
	public $wx;
	/**
	 * 关闭csrf防御
	 * @var boolean
	 */
	public $enableCsrfValidation = false;
	
	public function actionIndex() {
		if ($this->validateSign()) {
			if (isset($_GET['echostr'])) return $_GET['echostr'];
		} else {
			$this->wx->addLog('validate-error');
		}
		
		$wxPostData = $this->wx->wxPostData;
		$event_name = isset($wxPostData['Event']) ? $wxPostData['Event'] : $wxPostData['MsgType'];
		$this->wx->trigger($event_name);
		
		$this->wx->addLog($event_name);
		return $this->wx->returnXml;
	}
	
	private function validateSign() {
		//1. 将timestamp , nonce , token 按照字典排序
		$token = $this->wx->token;
		$timestamp = $_GET['timestamp'];
		$nonce = $_GET['nonce'];
		$signature = $_GET['signature'];
		$array = array($timestamp,$nonce,$token);
		sort($array, SORT_STRING);
	
		//2.将排序后的三个参数拼接后用sha1加密
		$tmpstr = implode($array);
		$tmpstr = sha1($tmpstr);
	
		//3. 将加密后的字符串与 signature 进行对比, 判断该请求是否来自微信
		return $tmpstr == $signature;
	}
}