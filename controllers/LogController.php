<?php
namespace kaikaige\wxgz\controllers;

use yii;
class LogController extends BaseController {
	public function actionIndex() {
		$data = [
			'first' => ['value' => '恭喜您在下单成功！'],
// 			'keyword1' => ['value' => '下单成功'],
// 			'keyword2' => ['value' => f_date(time())],
// 			'remark' => ['value' => "订单编号: 1001\n订货人: 凯凯哥\n下单时间: 2016-10-27 14:15:59"]
		];
		$v = $this->wx->getMsg()->sendTemplate('oaByzwlXzenn5Lj2NEdAeIX9XJ-A', '3tmjfdpAQvnfN1pD3Pf7CP0vX4U45ACCEDdD8BXVzOs', $data, 'http://www.baidu.com');
		f_d($v);
// 		$msg = [
// 				'touser' => 'oaByzwlXzenn5Lj2NEdAeIX9XJ-A',
// 				'url' => 'http://www.baidu.com',
// 				'template_id' => '1VOh6Ef97lPi6ZW2hidNkkHPjlMFgRYNUHZ4-npQXBo',
// 				'data' => $data,
// 		];
// 		$url = $this->wx->getQr()->limitStr("hello limit");
// 		f_d($this->wx->getQr()->long2short($url));
	}
}