<?php

namespace yii2module\markdown\widgets\helpers;

use Yii;

class FilterHelper {

	public static function run($html, $filters) {
		foreach($filters as $className) {
			$html = static::runFilter($className, $html);
		}
		return $html;
	}

	private static function runFilter($className, $html) {
		$filterInstance = Yii::createObject($className);
		$html = $filterInstance->run($html);
		return $html;
	}

}
