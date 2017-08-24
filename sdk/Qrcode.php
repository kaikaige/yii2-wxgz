<?php
namespace kaikaige\wxgz\sdk;

use yii\base\Component;

class Qrcode extends BaseWechat {
	public function str($expire_seconds, $scene_str) {
		$data = [
			'expire_seconds' => $expire_seconds,
			'action_name' => 'QR_STR_SCENE',
			'action_info' => [
				'scene' => [
					'scene_str' => $scene_str
				]
			]
		];
		return $this->generate($data);
	}
	
	public function id($expire_seconds, $scene_id) {
		$data = [
			'expire_seconds' => $expire_seconds,
			'action_name' => 'QR_SCENE',
			'action_info' => [
				'scene' => [
					'scene_id' => $scene_id
				]
			]
		];
		return $this->generate($data);
	}
	
	public function limitStr($scene_str) {
		$data = [
			'action_name' => 'QR_LIMIT_STR_SCENE',
			'action_info' => [
				'scene' => [
					'scene_str' => $scene_str
				]
			]
		];
		return $this->generate($data);
	}
	
	public function limitID($scene_id) {
		$data = [
			'action_name' => 'QR_LIMIT_SCENE',
			'action_info' => [
				'scene' => [
					'scene_id' => $scene_id
				]
			]
		];
		return $this->generate($data);
	}
	
	public function long2short($url) {
		$data = [
			'action' => 'long2short',
			'long_url' => $url,	
		];
		return $this->wx->httpPost("https://api.weixin.qq.com/cgi-bin/shorturl", $data);
	}
	
	private function generate($data) {
		$return = $this->wx->httpPost("https://api.weixin.qq.com/cgi-bin/qrcode/create", $data);
		return 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$return['ticket'];
	}
}