自用微信公众号功能开发
===========
自用

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

### 安装看人品

```
composer require "kaikaige/yii2-wxgz":"*"
```

### 倒数数据表
```
vendor/kaikaige/yii2-wxgz/wx.sql
```

### config
```
'components' => [
	...	
	'wx' => [
		'class' => 'kaikaige\wxgz\sdk\Wx',
		'appid' => 'appid',
		'secret' => 'xxxxxx',
		'token' => 'xxxxxx',
		'wxid' => 'xxxxxx'
    ]
	...
]
```

### Usage
发送模板消息

```
$data = [
	'first' => ['value' => '恭喜您在下单成功！'],
];
$v = $this->wx->getMsg()->sendTemplate('oaByzwlXzenn5Lj2NEdAeIX9XJ-A', '3tmjfdpAQvnfN1pD3Pf7CP0vX4U45ACCEDdD8BXVzOs', $data, 'http://www.baidu.com')

```