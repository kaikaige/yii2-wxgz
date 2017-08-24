自用微信公众号功能开发
===========
自用

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist kaikaige/yii2-wxgz "*"
```

or add

```
"kaikaige/yii2-wxgz": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \kaikaige\wxgz\AutoloadExample::widget(); ?>
```




```php
php yii migrate --migrationPath=@vendor/kaikaige/yii2-wxgz/migrations
```

### 获取open_id
```php
/**
 * @inheritdoc
 */
public function actions()
{
    return [
	    'open-id' => [
			'class' => 'kaikaige\wxgz\actions\OpenIdAction',
			'callback' => 'function' //回调参数为open_id
	    ]
    ];
}
```