<?php

namespace yii2module\markdown\widgets\filters;

use Yii;
use yii\base\BaseObject;
use yii2lab\helpers\yii\FileHelper;
use yii2lab\helpers\yii\Html;
use yii2lab\designPattern\filter\interfaces\FilterInterface;

class ImgFilter extends BaseObject implements FilterInterface {
	
	const FILE_NO_IMAGE = '@frontend/web/images/image/no_image.png';
	const WEB_NO_IMAGE = '@web/images/image/no_image.png';
	
	public function run($html) {
		$html = $this->replace($html);
		return $html;
	}

	private function replace($html) {
		$project_id = Yii::$app->request->getQueryParam('project_id');
		$project = Yii::$domain->guide->project->oneById($project_id);
		$pattern = '~<img src="([^"]+)"([^\>]*)>~';
		$html = preg_replace_callback($pattern, function($matches) use($project) {
			$url = $matches[1];
			if(strpos($url, '://') !== false) {
				return $matches[0];
			}
			$fileName = ROOT_DIR . DS . $project->dir . DS . $url;
			if(!FileHelper::has($fileName)) {
				$fileName = Yii::getAlias(self::FILE_NO_IMAGE);
			}
			$data = Html::getDataUrl($fileName);
			return "<img src=\"{$data}\"{$matches[2]}>";
		}, $html);
		return $html;
	}

}
