<?php
function news_parse($title, $content, $date, $icon = 0, $author = '', $comments = '')
{
	return '
		<h1>' . stripslashes($title) . '</h1>
		<p class="meta">' . date("j.n.Y", $date) . ' by ' . $author . '</p>
		' . $content . (isset($comments[0]) ? '
			<div style="text-align: right; margin-right: 10px;"><a href="' . $comments . '">» Comment on this news</a></div>' : '');
}
?>
