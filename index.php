<?php
/*
This file is part of VCMS.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA
*/

if(is_file('installer.php')){
	die('Um das VCMS zu nutzen, muss nach der Installation die Datei installer.php entfernt werden.');
}

require_once('custom/systemconfig.php');
require_once('vendor/vcms/initialize.php');


$libCronJobs = new \vcms\LibCronJobs();
$libMenuInternet = $libModuleHandler->getMenuInternet();
$libMenuIntranet = $libModuleHandler->getMenuIntranet();
$libMenuAdministration = $libModuleHandler->getMenuAdministration();

//initialize page id
if(!isset($_GET['pid']) || $_GET['pid'] == ''){
	$libGlobal->pid = $libConfig->defaultHome;
} else {
	$libGlobal->pid = $_GET['pid'];
}

if(!$libModuleHandler->pageExists($libGlobal->pid)){
	header('HTTP/1.0 404 Not Found');
	die('HTTP-Fehler 404: Seite nicht gefunden.');
} elseif(!$libSecurityManager->hasAccess($libModuleHandler->getPage($libGlobal->pid), $libAuth)){
	header('HTTP/1.0 404 Not Found');
}

//load page object
$libGlobal->page = $libModuleHandler->getPage($libGlobal->pid);
$libGlobal->module = $libModuleHandler->getModuleByPageid($libGlobal->pid);

//load page header
require_once('vendor/vcms/frame/header.php');

//security check
if(is_object($libGlobal->page) && $libSecurityManager->hasAccess($libGlobal->page, $libAuth)){
	if(is_file($libGlobal->page->getPath())){
		//load page
		require_once($libGlobal->page->getPath());
	}
} else {
	echo '<h1>Zugriffsfehler</h1>';
	echo $libString->getErrorBoxText();
	echo $libString->getNotificationBoxText();
	echo '<p>Für diese Seite ist eine <a href="index.php?pid=login_login">Anmeldung im Intranet</a> nötig.</p>';
}

//load footer
require_once('vendor/vcms/frame/footer.php');
?>