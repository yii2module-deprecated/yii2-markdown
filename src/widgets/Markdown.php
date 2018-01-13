<?php

namespace yii2module\markdown\widgets;

use yii\apidoc\templates\bootstrap\assets\AssetBundle;
use yii\base\Widget;
use yii2lab\designPattern\filter\helpers\FilterHelper;
use yii2module\markdown\widgets\helpers\MarkdownHelper;

class Markdown extends Widget {

	public $content;
	public $filters = [
		'yii2module\markdown\widgets\filters\AlertFilter',
		'yii2module\markdown\widgets\filters\CodeFilter',
		'yii2module\markdown\widgets\filters\ImgFilter',
		'yii2module\markdown\widgets\filters\LinkFilter',
		'yii2module\markdown\widgets\filters\MarkFilter',
		//'yii2module\markdown\widgets\filters\HeaderFilter',
	];

	public function init() {
		parent::init();
		$this->registerAssets();
	}

	public function run() {
		$html = MarkdownHelper::toHtml($this->content);
		$html = FilterHelper::runAll($this->filters, $html);
		return $html;
	}

	protected function registerAssets() {
		$view = $this->getView();
		AssetBundle::register($view);
	}

}