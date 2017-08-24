<?php

namespace kaikaige\wxgz\controllers;

use Yii;
/**
 * LogGatewayController implements the CRUD actions for WxLogGateway model.
 */
class MessageController extends BaseController {
	public function actionIndex() {
// 		$url = "https://api.weixin.qq.com/cgi-bin/message/mass/preview";
// 		$r = $this->wx->httpPost($url, [
// 			'touser'=>'oaByzwlXzenn5Lj2NEdAeIX9XJ-A', 
// 			'text' => ['content'=>'hello'],
// 			'msgtype' => 'text',
// 		]);
// 		f_d($r); 
		$data = [
			'text' => ['content'=>'hello all test'],
			'filter' => [
				'is_to_all' => true
			],
			'msgtype' => 'text',
		];
		$url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall';
		f_d($this->wx->httpPost($url, $data));
	}
	
	public function actionQuery() {
		$url = 'https://api.weixin.qq.com/cgi-bin/message/mass/get';
		f_d($this->wx->httpPost($url, ['msg_id' => '1000000001']));
	}
}
