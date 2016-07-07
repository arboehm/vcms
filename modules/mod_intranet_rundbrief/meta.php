<?php
$moduleName = 'Intranet Rundbrief';
$version = '2.23';
$installScript = 'install/install.php';
$uninstallScript = '';
$updateScript = 'install/update.php';

$ar = new LibAccessRestriction(array('F', 'B', 'P', 'C', 'G', 'W'), '');

$pages[] = new LibPage('intranet_rundbrief_schreiben', 'scripts/', 'write.php', $ar, 'Rundbrief');
$pages[] = new LibPage('intranet_rundbrief_senden', 'scripts/', 'send.php', $ar, 'Rundbrief');
$menuElementsInternet = array();
$menuElementsIntranet[] = new LibMenuEntry('intranet_rundbrief_schreiben', 'Rundbrief', 3333);
$menuElementsAdministration = array();
$includes = array();
$headerStrings = array();