<?php
namespace kaikaige\wxgz\sdk;

use yii;
use yii\base\Component;
use yii\helpers\StringHelper;

class Xml extends BaseWechat {
	/**
	 * 创建微信格式的XML
	 * @param array $data
	 * @param null $charset
	 * @return string
	 */
	public function generate(array $data, $charset = null)
	{
		$dom = new \DOMDocument('1.0', $charset === null ? Yii::$app->charset : $charset);
		$root = new \DOMElement('xml');
		$dom->appendChild($root);
		$this->buildXml($root, $data);
		$xml = $dom->saveXML();
		return trim(substr($xml, strpos($xml, '?>') + 2));
	}
	
	protected function buildXml($element, $data)
	{
		if (is_object($data)) {
			$child = new \DOMElement(StringHelper::basename(get_class($data)));
			$element->appendChild($child);
			if ($data instanceof Arrayable) {
				$this->buildXml($child, $data->toArray());
			} else {
				$array = [];
				foreach ($data as $name => $value) {
					$array[$name] = $value;
				}
				$this->buildXml($child, $array);
			}
		} elseif (is_array($data)) {
			foreach ($data as $name => $value) {
				if (is_int($name) && is_object($value)) {
					$this->buildXml($element, $value);
				} elseif (is_array($value) || is_object($value)) {
					$child = new \DOMElement(is_int($name) ? $this->itemTag : $name);
					$element->appendChild($child);
					$this->buildXml($child, $value);
				} else {
					$child = new \DOMElement(is_int($name) ? $this->itemTag : $name);
					$element->appendChild($child);
					$child->appendChild(new \DOMText((string) $value));
				}
			}
		} else {
			$element->appendChild(new \DOMText((string) $data));
		}
	}
}