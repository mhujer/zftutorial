<?php
require_once dirname(__FILE__).'/texy/texy.min.php';

$fshlPath = dirname(__FILE__).'/texy/fshl/';
@include_once $fshlPath . 'fshl.php';

/**
 * User handler for code block
 *
 * @param TexyHandlerInvocation  handler invocation
 * @param string  block type
 * @param string  text to highlight
 * @param string  language
 * @param TexyModifier modifier
 * @return TexyHtml
 */
function blockHandler($invocation, $blocktype, $content, $lang, $modifier)
{
	if ($blocktype !== 'block/code') {
		return $invocation->proceed();
	}

	$lang = strtoupper($lang);
	if ($lang == 'JAVASCRIPT') $lang = 'JS';

	$fshl = new fshlParser('HTML_UTF8', P_TAB_INDENT);
	if (!$fshl->isLanguage($lang)) {
		return $invocation->proceed();
	}

	$texy = $invocation->getTexy();
	$content = Texy::outdent($content);
	$content = $fshl->highlightString($lang, $content);
	$content = $texy->protect($content, Texy::CONTENT_BLOCK);

	$elPre = TexyHtml::el('pre');
	if ($modifier) $modifier->decorate($texy, $elPre);
	$elPre->attrs['class'] = strtolower($lang);

	$elCode = $elPre->create('code', $content);

	return $elPre;
}

// processing
$text = file_get_contents('zftutorial.texy');
$text = preg_replace_callback(
    '~<programkod xmlns="" id="([a-z0-9]*?)">(.*)</programkod>~sU',
    function ($matches) {
        $texy = new Texy();
        $texy->addHandler('block', 'blockHandler');
        return $texy->process($matches[2]);
    },
    $text
);
$text = preg_replace('~<img alt="\[Varování\]" src="(.*)"/>~', '!', $text);
$text = preg_replace('~<img alt="\[Poznámka\]" src="(.*)"/>~', '&rarr;', $text);

$css = '<style type="text/css">body { font-family: Calibri;} '. file_get_contents($fshlPath.'styles/COHEN_style.css') . '</style>';
$text = str_replace('</head>', $css . '</head>', $text);

file_put_contents('zftutorial.html', $text);
