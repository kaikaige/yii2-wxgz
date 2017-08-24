<?php
namespace kaikaige\wxgz\sdk;

use yii\base\Component;
use yii\helpers\ArrayHelper;

class Message extends BaseWechat {
	
	public function text($message) {
		$data = [
			'MsgType' => 'text',
			'Content' => $message
		];
		return $this->buildXML($data);
	}
	
	public function image($MediaId) {
		$data = [
			'MsgType' => 'image',
			'Image' => [
				'MediaId' => $MediaId
			]
		];
		return $this->buildXML($data);
	}
	
	public function voice() {}
	public function video() {}
	public function music() {}
	public function news() {}
	
	private function buildXML($data) {
		$data = ArrayHelper::merge($data, [
			'ToUserName' => $this->wx->openId, 
			'FromUserName' => $this->wx->wxid, 
			'CreateTime' => time(),
		]);
		$this->wx->returnXml = $this->wx->getXml()->generate($data);
	}
	
	/**
	 * 发送模板消息给关注者
	 * 示例数据
	 * [
	 *   "touser" => "接收消息的用户openid",
	 *   "template_id" => "模板id",
	 *   "url" => "http://weixin.qq.com/download",
	 *   "topcolor" => "#FF0000",
	 *   "data" => [
	 *       "first" => [
	 *           "value" => "恭喜你购买成功！",
	 *           "color" => "#173177"
	 *       ],
	 *       "product" => [
	 *           "value" => "巧克力",
	 *           "color" => "#173177"
	 *       ],
	 *       "price" => [
	 *           "value" => "39.8元",
	 *           "color" => "#173177"
	 *       ],
	 *       "time" => [
	 *           "value" => "2014年9月16日",
	 *           "color" => "#173177"
	 *       ],
	 *       "remark" => [
	 *           "value" => "欢迎再次购买！",
	 *           "color" => "#173177"
	 *       ]
	 *   ]
	 *
	 *   ]
	 * @param $toUser 关注者openID
	 * @param $templateId 模板ID(模板需在公众平台模板消息中挑选)
	 * @param array $data 模板需要的数据
	 * @return int
	 */
	public function sendTemplate($toUser, $templateId, $data, $url=null) {
		$requestParams = [
			'touser' => $toUser,
			'template_id' => $templateId,
			'url' => $url,
			'topcolor' => '#FF0000',
			'data' => $data
		];
		return $this->wx->httpPost("https://api.weixin.qq.com/cgi-bin/message/template/send", $requestParams);
	}
}