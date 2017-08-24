<?php
namespace kaikaige\wxgz\actions;

use yii;
use yii\base\Action;
class OpenIdAction extends Action {
	public $callback;
	
	public $wx = 'wx';
	
	public function init() {
		$this->wx = Yii::$app->get($this->wx);
	}
	
	public function run() {
		$appid = $this->wx->appid;
		$secret = $this->wx->secret;
		if (isset($_GET['code']) && ($code = $_GET['code'])) {
			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
			if (($content = file_get_contents($url)) !== false && !isset($content['errcode'])) {
				$result = json_decode($content, true);
				call_user_func([$this->controller, $this->callback], $result['openid']);
				return;
			} else {
				return $result;
			}
		} else {
			$redirect_uri = urlencode(Yii::$app->request->absoluteUrl);
			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_base&state=kaikaige#wechat_redirect";
			$this->controller->redirect($url);
		}
	}
}