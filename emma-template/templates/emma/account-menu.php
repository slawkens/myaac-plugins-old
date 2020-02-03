<?php
/**
 * Account menu for emma
 *
 * @name      emma-template
 * @author    Slawkens <slawkens@gmail.com>
 * @version   1.1
 */
defined('MYAAC') or die('Direct access not allowed!');

global $action, $twig, $template_name;
if($template_name == 'emma' && PAGE == 'accountmanagement' && !empty($action)) {
	echo $twig->render('emma-account-menu.html.twig');
}
?>