<?php

namespace kaikaige\wxgz\controllers;

use Yii;
use yii\helpers\BaseJson;
/**
 * LogGatewayController implements the CRUD actions for WxLogGateway model.
 */
class MenuController extends BaseController {
	public function actionIndex() {
		if (Yii::$app->request->isPost) {
			$action = Yii::$app->request->post("action", "update");
			if ($action == "update") {
				$menus = Yii::$app->request->post("menus");
				return BaseJson::encode(($this->wx->getMenu()->create(['button' => $menus])));
			} elseif ($action == 'clear') {
				return $this->asJson($this->wx->getMenu()->clear());
			}
		}
		
		$menus = $this->wx->getMenu()->query();
		return $this->render('index', [
			'menus' => BaseJson::encode($menus['menu']['button']), 
			'menuTypes' => BaseJson::encode($this->wx->getMenu()->menuTypes) 
		]);
	}
}
