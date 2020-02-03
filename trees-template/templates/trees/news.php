<?php
function news_parse($title, $content, $date, $icon = 0, $author = '', $comments = '')
{
	global $template_path;
	return '
	<table class="table" style="clear:both" border=0 cellpadding=0 cellspacing=0 width="100%" >
		<tr>
			<th width="15%">' . date("j.n.Y", $date) . '</th>
			<th>' . stripslashes($title) . '</th>
			' . (isset($author[0]) ? '
			<th style="text-align: right" width="30%"><b>Author: </b><i>' . $author . '</i></th>' : '') . '
		</tr>
		<tr>
			<td colspan="3" style="padding-left:10px;padding-right:10px;" >' . $content . '</td>
		</tr>'
		. (isset($comments[0]) ? '
		<tr>
			<td colspan="3">
				<div style="text-align: right; margin-right: 10px;"><a href="' . $comments . '">» Comment on this news</a></div>
			</td>
		</tr>' : '') .
	'</table><br/>';
}
?>
