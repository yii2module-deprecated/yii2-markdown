Установка
===

Устанавливаем зависимость:

```
composer require yii2module/yii2-markdown
```

Создаем полномочие:

```
oExamlpe
```

Объявляем модуль:

```php
return [
	'modules' => [
		// ...
		'markdown' => 'yii2module\markdown\console\Module',
		// ...
	],
];
```

Объявляем домен:

```php
return [
	'components' => [
		// ...
		'markdown' => [
			'class' => 'yii2lab\domain\Domain',
			'path' => 'yii2module\markdown\domain',
			'repositories' => [
				'default',
			],
			'services' => [
				'default',
			],
		],
		// ...
	],
];
```
