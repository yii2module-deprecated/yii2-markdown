<?php

namespace yii2module\markdown\widgets\filters;

use Yii;
use yii\base\Object;

class AlertFilter extends Object {

	public function run($html) {
		$html = $this->replace($html);
		return $html;
	}

	private function replace($html) {
		$pattern = '~<blockquote>\s*<p>\s*(\w+?)\:~';
		$html = preg_replace_callback($pattern, function($matches) {
			
			return '<blockquote class="'.strtolower($matches[1]).'"><p><b>'.Yii::t('guide/blocktypes', strtolower($matches[1])).'</b>:';
		}, $html);
		return $html;
	}

}
