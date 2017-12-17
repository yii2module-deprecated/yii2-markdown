<?php

namespace yii2module\markdown\widgets\filters;

use yii\base\BaseObject;
use yii\web\ErrorHandler;

class MarkFilter extends BaseObject {

	public function run($html) {
		$html = $this->replace($html);
		return $html;
	}

	private function replace($html) {
		$pattern = '~\[\[(.+?)\]\]~';
		$html = preg_replace_callback($pattern, function($matches) {
			$arr2 = explode('|', $matches[1]);
			$className = $arr2[0];
			$handler = new ErrorHandler();
			return $handler->addTypeLinks($className);
		}, $html);
		return $html;
	}

}
