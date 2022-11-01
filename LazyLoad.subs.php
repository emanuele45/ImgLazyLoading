<?php

/**
 * Image Lazy Loading
 *
 * @author  emanuele
 * @license BSD http://opensource.org/licenses/BSD-3-Clause
 *
 * @version 0.0.3
 */

function img_lazy_loading_buffer($buffer)
{
	if (isset($_REQUEST['xml']) || isset($_REQUEST['api']))
	{
		return $buffer;
	}

	return preg_replace_callback('~<img [^>]*/>~i', static function ($m) {
		if (strpos($m[0], 'loading="lazy"') !== false || strpos($m[0], 'admin_img_') !== false)
		{
			return $m[0];
		}

		$img = strtr($m[0], array(' src="' => ' data-original="'));
		if (strpos($img, 'class="') === false)
		{
			$find = '<img';
			$replace = '<img class="lazyload"';
		}
		else
		{
			$find = 'class="';
			$replace = 'class="lazyload ';
		}

		return strtr($img, array($find => $replace));
	}, $buffer);
}

function img_lazy_loading_scripts()
{
	loadJavascriptFile('jquery.lazyload.min.js', array('defer' => true));
	addInlineJavascript('
	$(document).ready(function() {
		$(".lazyload").lazyload();
	});');
}

function img_lazy_loading_credits(&$credits)
{
	$credits['credits_software_graphics']['software'][] = '<a href="https://www.appelsiini.net/projects/lazyload">Lazy Load Plugin for jQuery</a> | &copy; Mika Tuupola | Licensed under <a href="https://www.opensource.org/licenses/mit-license.php">The MIT License (MIT)</a>';
}
