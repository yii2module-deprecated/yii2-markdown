<?php

namespace yii2module\markdown\widgets\filters;

use Yii;
use yii\base\Object;
use yii2lab\helpers\yii\Html;

class ImgFilter extends Object {

	public function run($html) {
		$html = $this->replace($html);
		return $html;
	}

	private function replace($html) {
		$project_id = Yii::$app->request->getQueryParam('project_id');
		$project = Yii::$app->guide->project->oneById($project_id);
		$pattern = '~<img src="([^"]+)"([^\>]*)>~';
		$html = preg_replace_callback($pattern, function($matches) use($project) {
			$url = $matches[1];
			if(strpos($url, '://') !== false) {
				return $matches[0];
			}
			$fileName = ROOT_DIR . DS . $project->dir . DS . $url;
			$data = Html::getDataUrl($fileName);
			return "<img src=\"{$data}\"{$matches[2]}>";
		}, $html);
		return $html;
	}

}
