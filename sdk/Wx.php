<?php
namespace kaikaige\wxgz\sdk;

use yii;
use yii\base\Component;
use yii\helpers\BaseJson;
use yii\httpclient\Client;
use kaikaige\wxgz\components\DbTarget;
use kaikaige\wxgz\models\WxLogGateway;
use yii\helpers\VarDumper;
use yii\httpclient\CurlTransport;

class Wx extends Component {
	const EVENT_TEXT = 'text'; //文本
	const EVENT_VOICE = 'voice'; //音频
	const EVENT_SCAN = 'SCAN'; //扫描
	/**
	 * @var string
	 */
	public $appid; 
	/**
	 * @var string
	 */
	public $secret;
	/**
	 * @var string
	 */
	public $token;
	/**
	 * @var string
	 */
	public $wxid;
	/**
	 * @var string
	 */
	public $openId;
	/**
	 * @var class name
	 */
	public $behavior = 'kaikaige\wxgz\WxBehavior';
	/**
	 * @var xml string
	 */	
	public $returnXml;
	
	/** 
	 * @var Qrcode 
	 */
	private $_qr;
	
	private $_httpClient;
	
	private $_accessToken;
	
	private $_xml;
	/**
	 * 微信post过来的XML数据，解析为数组
	 * @var array 
	 */
	public $wxPostData;
	
	public function init() {
		if (Yii::$app->request->isPost) {
			$str = file_get_contents('php://input');
			$xml_parser = xml_parser_create();
			if(!xml_parse($xml_parser,$str,true)){
				xml_parser_free($xml_parser);
			}else {
				$this->wxPostData = $wxPostData = (array)simplexml_load_string($str, 'SimpleXMLElement', LIBXML_NOCDATA);
				$this->openId = isset($wxPostData['FromUserName']) ? $wxPostData['FromUserName'] : null;
			} 
		}
	}
	
	public function behaviors() {
		return [
			'wx_behavior' => $this->behavior		
		];
	}
	
	public static $builtClass = [
		'qr' => 'kaikaige\wxgz\sdk\Qrcode',
		'msg' => 'kaikaige\wxgz\sdk\Message',
		'xml' => 'kaikaige\wxgz\sdk\Xml',
		'menu' => 'kaikaige\wxgz\sdk\Menu',
	];
	
	public function get($id) {
		return Yii::createObject([
			'class' => self::$builtClass[$id], 
			'wx' => $this
		]);
	}
	
	/**
	 * @return Qrcode
	 */
	public function getQr() {
		return $this->get('qr');
	}
	/**
	 * @return Message 
	 */
	public function getMsg() {
		return $this->get('msg');
	}
	/**
	 * @return Xml
	 */
	public function getXml() {
		return $this->get('xml');
	}
	
	/**
	 * @return Menu
	 * @return object
	 * @author: gaokai
	 * @date: 2017年8月8日下午3:36:05
	 * @modified_date: 2017年8月8日下午3:36:05
	 * @modified_user: gaokai
	 */
	public function getMenu() {
		return $this->get('menu');
	}
	
	/**
	 * @return yii\httpclient\Client
	 * @author: gaokai
	 * @date: 2017年8月4日下午2:44:56
	 * @modified_date: 2017年8月4日下午2:44:56
	 * @modified_user: gaokai
	 */
	public function getHttpClient() {
		if ($this->_httpClient === null) {
			$this->_httpClient = Yii::createObject([
				'class' => Client::className(),
				'transport' => CurlTransport::className()
			]);
		}
		return $this->_httpClient;
	}
	
	public function httpGet($url, $isToken=true, $data=null) {
		if ($isToken) {
			$url .= "?access_token=".$this->getAccessToken();
		}
		$request = $this->getHttpClient()->get($url, $data);
		return $this->sendHttp($request);
	}
	
	public function httpPost($url, $data=null, $isToken=true, $isEncode=true) {
		if ($isToken) {
			$url .= "?access_token=".$this->getAccessToken();
		}
		if ($isEncode && is_array($data)) {
			$data = BaseJson::encode($data);
		}
		$request = $this->getHttpClient()->post($url, $data);
		return $this->sendHttp($request);
	}
	
	/**
	 * @param yii\httpclient\Request $request
	 * @author: gaokai
	 * @date: 2017年8月4日下午2:49:39
	 * @modified_date: 2017年8月4日下午2:49:39
	 * @modified_user: gaokai
	 */
	private function sendHttp($request) {
		return $request->send()->getData();
	}
	
	public function getAccessToken() {
		if ($this->_accessToken === null) {
			$this->_accessToken = $this->getToken();
		}
		return $this->_accessToken;
	}
	
	public function addLog($type) {
		$log = new WxLogGateway([
			'type' => $type,
			'get_data' => VarDumper::export($_GET),
			'post_data' => VarDumper::export($this->wxPostData),
			'return_xml' => $this->returnXml,
			'create_time' => date('Y-m-d H:i:s', time()),
		]);
		$log->save();
	}

	
	/**
	 * 微信绑定的开发域名获取到回调状态后，推送至该接口进行最终状态修改
	 * @return string
	 * @author: gaokai
	 * @date: 2016年10月31日上午11:08:29
	 * @modified_date: 2016年10月31日上午11:08:29
	 * @modified_user: gaokai
	 */
	public function updateMsg() {
		$content = json_decode(file_get_contents("php://input"), true);
		$msgid = $content['MsgID'];
		$status_msg = $content['Status'];
		if ($status_msg == 'success') {
			$status = 1;
		} elseif ($status_msg == 'failed:user block') {
			$status = 4;
		} elseif ($status_msg == 'failed: system failed') {
			$status = 5;
		}
		$msgobj = WxMsg::findOne(['msgid' => $msgid]);
		$msgobj->status = $status;
		$msgobj->errmsg = $status_msg;
		$msgobj->send_time = f_date($content['CreateTime']);
		$msgobj->save();
		return $content;
	}
	
	/**
	 * 获取调用接口时的acces_token
	 * @throws Exception
	 * @return mixed
	 * @author: gaokai
	 * @date: 2016年10月24日下午5:22:44
	 * @modified_date: 2016年10月24日下午5:22:44
	 * @modified_user: gaokai
	 */
	public function getToken() {
		//先从数据库中查找是否有token，如果没有请求接口
		$token_obj = WxToken::findOne('access_token');
		if ($token_obj->expires_time < time() || !$this->checkToken($token_obj->token)) {
			$params = [
				'grant_type' => 'client_credential',
				'appid' => $this->appid,
				'secret' => $this->secret
			];
			$query = http_build_query($params);
			$url = "https://api.weixin.qq.com/cgi-bin/token?".$query;
			$return = $this->httpGet($url, false);
			if (isset($return['errcode']))
				throw new Exception($return['errmsg'], $return['errcode'], null);
				
			$token_obj->token = $return['access_token'];
			$token_obj->expires_time = $return['expires_in']+ time();
			$token_obj->access_count = 1;
			$token_obj->save();
		} else {
			$token_obj->access_count++;
			$token_obj->save();
		}
		//如果有直接返回token
		return $token_obj->token;
	}
	
	/**
	 * 获取JsApiTicket 
	 * @author: gaokai
	 * @date: 2017年8月2日上午11:24:25
	 * @modified_date: 2017年8月2日上午11:24:25
	 * @modified_user: gaokai
	 */
	public function getJsApiTicket() {
		$token_obj = WxToken::findOne('jsapi_ticket');
		if ($token_obj->expires_time < time()) {
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=".$this->getToken();
			$return = BaseJson::decode(file_get_contents($url));
			$token_obj->token = $return['ticket'];
			$token_obj->expires_time = $return['expires_in']+ time() - 200;
			$token_obj->access_count = 1;
			$token_obj->save();
		} else {
			$token_obj->access_count++;
			$token_obj->save();
		}
		return $token_obj->token;
	}
	
	/**
	 * 通过调用微信不限制次数的接口，服务号IP来测试access_toke是否有效
	 * @param string $token
	 * @return boolean 有效返回true,无效返回false
	 * @author: gaokai
	 * @date: 2016年10月25日上午10:19:19
	 * @modified_date: 2016年10月25日上午10:19:19
	 * @modified_user: gaokai
	 */
	private function checkToken($token) {
		$url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=$token";
		$content = file_get_contents($url);
		if ($content === false) {
			throw new Exception('校验access_token，调用无限次数接口连接异常', 500, null);
		}
		$content = json_decode($content, true);
		if (isset($content['errcode']) && $content['errcode'] == 40001) {
			return false;
		}
		return true;
	}
	
}