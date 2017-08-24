<?php
namespace kaikaige\wxgz\controllers;

use yii\web\Controller;
class BaseController extends Controller {
	/**
	 * @var \kaikaige\wxgz\sdk\Wx
	 */
	public $wx;
	
	public $enableCsrfValidation = false;
	
	public function init() {
		parent::init();
		$this->wx = $this->module->wx;
	}
}