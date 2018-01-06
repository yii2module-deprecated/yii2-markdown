<?php

namespace yii2module\markdown\widgets\filters;

use yii\base\BaseObject;
use yii2lab\misc\interfaces\FilterInterface;
use yii2module\markdown\widgets\helpers\MarkdownHelper;

class HeaderFilter extends BaseObject implements FilterInterface {

	public function run($html) {
		$html = $this->replace($html);
		return $html;
	}

	private function replace($html) {
		$pattern = '~\<h([1-6]{1})\>([^<]+)\<\/h[1-6]{1}\>~';
		$menu = [];
		$html = preg_replace_callback($pattern, function($matches) use(&$menu) {
			$item['level'] = $matches[1];
			if($item['level'] == 1) {
				return $matches[0];
			}
			$item['text'] = $matches[2];
			$item['name'] = 'header-' . hash('crc32b', $item['level'] . $item['text']);
			$menu[] = $item;
			return "<h{$item['level']} id=\"{$item['name']}\">{$item['text']}</h{$item['level']}>";
		}, $html);
		$headersHtml = $this->makeMenu($html, $menu);
		$html = str_replace('</h1>', '</h1>' . $headersHtml . PHP_EOL, $html);
		return $html;
	}

	private function makeMenu($html, $menu) {
		$headersMd = PHP_EOL;
		foreach($menu as $item) {
			$link = '<a href="#'.$item['name'].'">'.$item['text'].'</a>';
			$headersMd .= str_repeat(TAB, $item['level'] - 2) . '*' . SPC . $link . PHP_EOL;
		}
		$headersHtml = MarkdownHelper::toHtml($headersMd);
		return $headersHtml;
	}
	
}
