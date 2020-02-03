<?php
defined('MYAAC') or die('Direct access not allowed!');
defined('ADMIN_PANEL') or die('Direct access not allowed!');

if(!tableExist('znote_accounts')) {
	warning('znote_accounts table not found. Seems ZnoteAAC is not installed?');
	return;
}

$tmp = null;
if(fetchDatabaseConfig('converted_from_znote', $tmp) && $tmp) {
	warning('Seems tables has been already converted. Skipping..');
	return;
}

$converted = array();

// convert accounts
$query = $db->query('SELECT `id`, `account_id`, `created`, `points`, `flag` FROM `znote_accounts`;');
foreach($query->fetchAll() as $account) {
	$db->update('accounts', array('created' => $account['created'], 'premium_points' => $account['points'], 'country' => $account['flag']), array('id' => $account['account_id']));
}
$converted['accounts'] = $query->rowCount();

// convert players
$query = $db->query('SELECT `player_id`, `created`, `hide_char`, `comment` FROM `znote_players`;');
foreach($query->fetchAll() as $player) {
	$db->update('players', array('created' => $player['created'], 'hidden' => $player['hide_char'], 'comment' => $player['comment']), array('id' => $player['player_id']));
}
$converted['players'] = $query->rowCount();

// convert changelog
$query = $db->query('SELECT `text`, `time` FROM `znote_changelog`;');
foreach($query->fetchAll() as $changelog) {
	$db->insert(TABLE_PREFIX . 'changelog', array('body' => $changelog['text'], 'date' => $changelog['time']));
}
$converted['changelogs'] = $query->rowCount();

// convert newses
$query = $db->query('SELECT `title`, `text`, `date`, `pid` FROM `znote_news`;');
foreach($query->fetchAll() as $news) {
	$db->insert(TABLE_PREFIX . 'news', array('title' => $news['title'], 'body' => $news['text'], 'date' => $news['date'], 'player_id' => $news['pid'], 'comments' => '', 'type' => 1));
}
$converted['newses'] = $query->rowCount();

// convert forum
$query = $db->query('SELECT `ordering` FROM `' . TABLE_PREFIX . 'forum_boards` ORDER BY `ordering` DESC;')->fetch();
$lastOrdering = $query['ordering'];

// boards
$converted['boards'] = 0;
$board_ids = array();
$query = $db->query('SELECT * FROM `znote_forum` ORDER BY `id` ASC');
foreach($query->fetchAll() as $board) {
	$db->insert(TABLE_PREFIX . 'forum_boards', array('name' => $board['name'], 'ordering' => $lastOrdering + $board['id'], 'closed' => $board['closed'], 'guild' => $board['guild_id'], 'access' => $board['access']));
	$board_ids[$board['id']] = $db->lastInsertId();
	$converted['boards']++;
}

// threads
$converted['threads'] = 0;
$converted['posts'] = 0;
$query = $db->query('SELECT * FROM `znote_forum_threads` ORDER BY `created`;');
foreach($query->fetchAll() as $thread) {
	// fetch author_aid
	$author_aid_db = $db->query('SELECT `account_id` FROM `players` WHERE `id` = ' . $db->quote($thread['player_id']));
	if($author_aid_db->rowCount() == 1) {
		$author_aid = $author_aid_db->fetch();
		$author_aid = $author_aid['account_id'];
	}
	else {
		$author_aid = 0;
	}
	
	// insert thread
	$db->insert(TABLE_PREFIX . 'forum', array('section' => $board_ids[$thread['forum_id']], 'author_aid' => $author_aid, 'author_guid' => $thread['player_id'], 'post_topic' => $thread['title'], 'post_text' => $thread['text'], 'post_smile' => 1, 'post_date' => $thread['created'], 'edit_date' => $thread['updated'], 'sticked' => $thread['sticky'], 'closed' => $thread['closed']));
	$lastThreadId = $db->lastInsertId();
	
	$converted['threads']++;
	
	// set first_post to id
	$db->query('UPDATE `' . TABLE_PREFIX . 'forum` SET `first_post` = ' . $db->quote($lastThreadId) . ' WHERE `id` = ' . $db->quote($lastThreadId));
	
	// get posts
	$posts_db = $db->query('SELECT * FROM `znote_forum_posts` WHERE `thread_id` = ' . $db->quote($thread['id']));
	foreach($posts_db as $post) {
		$author_aid_db = $db->query('SELECT `account_id` FROM `players` WHERE `id` = ' . $db->quote($post['player_id']));
		if($author_aid_db->rowCount() == 1) {
			$author_aid = $author_aid_db->fetch();
			$author_aid = $author_aid['account_id'];
		}
		else {
			$author_aid = 0;
		}
		
		$db->insert(TABLE_PREFIX . 'forum', array('first_post' => $lastThreadId, 'section' => $board_ids[$thread['forum_id']], 'author_aid' => $author_aid, 'author_guid' => $post['player_id'], 'post_text' => $post['text'], 'post_topic' => '', 'post_smile' => 1, 'post_date' => $post['created'], 'edit_date' => $post['updated']));
		$converted['posts']++;
	}
}

global $twig;
success(
	$twig->render('znote-converter.html.twig', array(
			'converted' => $converted
		)
	));
registerDatabaseConfig('converted_from_znote', true);
?>