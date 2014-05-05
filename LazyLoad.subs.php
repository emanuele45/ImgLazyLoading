<?php

/**
 * Image Lazy Loading
 *
 * @author  emanuele
 * @license BSD http://opensource.org/licenses/BSD-3-Clause
 *
 * @version 0.0.1
 */

function img_lazy_loading_buffer($buffer)
{
	if (isset($_REQUEST['xml']) || isset($_REQUEST['api']))
		return $buffer;

	return preg_replace_callback('~<img ([^>]*)/>~is', function($m) {
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
	loadJavascriptFile('jquery.lazyload.js');
	addInlineJavascript('
	$(document).ready(function() {
		$(".lazyload").lazyload();
	});');
}

function img_lazy_loading_credits(&$credits)
{
	$credits['credits_software_graphics']['software'][] = '<a href="http://www.appelsiini.net/projects/lazyload">Lazy Load Plugin for jQuery</a> | &copy; Mika Tuupola | Licensed under <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License (MIT)</a>';
}