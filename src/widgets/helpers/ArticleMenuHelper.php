<?php

namespace yii2module\markdown\widgets\helpers;

use yii2lab\helpers\yii\Html;

class ArticleMenuHelper {
	
	const HEADER_PATTERN = '~<h([2-6]{1}).*>(.+)</h[2-6]{1}.*>~m';
	const HEADER_PATTERN1 = '~\s*([#]+)\s*(.+)$~m';
	
	public static function makeMenuMd($menu) {
		$headersMd = PHP_EOL;
		$min = self::getMinMargin($menu);
		foreach($menu as $item) {
			$link = Html::a($item['content'], '#'.$item['name']);
			$headersMd .= str_repeat(TAB, $item['level'] - $min) . '*' . SPC . $link . PHP_EOL;
		}
		return $headersMd;
	}
	
	public static function addIdInHeaders($html) {
		$callback = function($matches) {
			$item = self::buildMenuItem($matches[1], $matches[2]);
			$rightContent = '';
			$rightContent .= Html::a(Html::fa('arrow-up', ['class' => 'pull-right'], 'fa fa-', 'small'), '#go_to_top');
			$rightContent .= Html::a(Html::fa('hashtag', ['class' => 'pull-right'], 'fa fa-', 'small'), '#' . $item['name']);
			$tagHtml = self::buildHeader($item, $rightContent);
			return $tagHtml;
		};
		$html = preg_replace_callback(self::HEADER_PATTERN, $callback, $html);
		return $html;
	}
	
	public static function getMenuFromHtml($html) {
		$menu = [];
		$callback = function($matches) use(&$menu) {
			$item = self::buildMenuItem($matches[1], $matches[2]);
			if(!empty($item['content'])) {
				$menu[$item['name']] = $item;
			}
		};
		preg_replace_callback(self::HEADER_PATTERN, $callback, $html);
		
		return $menu;
	}
	
	public static function getMenuFromMarkdown($md) {
		$menu = [];
		$callback = function($matches) use(&$menu) {
			$item = self::buildMenuItem(strlen($matches[1]), $matches[2]);
			if(!empty($item['content'])) {
				$item['content'] = trim($item['content']);
				$menu[$item['name']] = $item;
			}
		};
		preg_replace_callback(self::HEADER_PATTERN1, $callback, $md);
		return $menu;
	}
	
	private static function getMinMargin($menu) {
		$min = 10;
		foreach($menu as $item) {
			if($item['level'] < $min) {
				$min = $item['level'];
			}
		}
		return $min;
	}
	
	private static function buildHeader($item, $rightContent) {
		$tagContent = $rightContent . $item['content'];
		$tagName = 'h' . $item['level'];
		$tagHtml = Html::tag($tagName, $tagContent, ['id' => $item['name']]);
		return $tagHtml;
		
	}
	
	private static function buildMenuItem($level, $content) {
		$item['level'] = intval($level);
		$item['content'] = strip_tags($content);
		$item['name'] = self::headerName($item);
		return $item;
	}
	
	private static function headerName($item) {
		$name = $item['content'];
		$name = preg_replace('#\s+#', ' ', $name);
		$name = mb_ereg_replace('#[\W]+#', '-', $name);
		$strtolowerCallback = function ($matches) {
			return strtolower($matches[1]);
		};
		$name = preg_replace_callback('/([A-Za-z]+)/', $strtolowerCallback, $name);
		$name = trim($name,  ' -');
		$name = str_replace([' ', '#', '?'], '-', $name);
		return $name;
	}
	
}
