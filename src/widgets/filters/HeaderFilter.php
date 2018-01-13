<?php

namespace yii2module\markdown\widgets\filters;

use yii\base\BaseObject;
use yii2lab\designPattern\filter\interfaces\FilterInterface;
use yii2module\markdown\widgets\helpers\ArticleMenuHelper;
use yii2module\markdown\widgets\helpers\MarkdownHelper;

class HeaderFilter extends BaseObject implements FilterInterface {

	public function run($html) {
		$html = $this->replace($html);
		return $html;
	}

	private function replace($html) {
		$menu = ArticleMenuHelper::getMenuFromHtml($html);
		if(!empty($menu)) {
			$html = ArticleMenuHelper::addIdInHeaders($html);
		}
		$menuMd = ArticleMenuHelper::makeMenuMd($menu);
		$menuHtml = MarkdownHelper::toHtml($menuMd);
		$html = str_replace('</h1>', '</h1>' . $menuHtml . PHP_EOL, $html);
		return $html;
	}
	
}
