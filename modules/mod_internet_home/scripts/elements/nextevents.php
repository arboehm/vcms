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

if(!is_object($libGlobal))
	exit();


if($libModuleHandler->moduleIsAvailable('mod_internet_semesterprogramm')){
	$stmtCount = $libDb->prepare('SELECT COUNT(*) AS number FROM base_veranstaltung WHERE datum > NOW()');
	$stmtCount->execute();
	$stmtCount->bindColumn('number', $count);
	$stmtCount->fetch();

	// if there are entries
	if($count > 0){
		echo '<hr />';
		echo '<div class="row">';

		$semesterCoverString = $libTime->getSemesterCoverString($libGlobal->semester);
		$semesterCoverAvailable = $semesterCoverString != '';
		$maxNumberOfNextEvents = $semesterCoverAvailable ? 3 : 4;

		$stmt = $libDb->prepare('SELECT * FROM base_veranstaltung WHERE datum > NOW() ORDER BY datum LIMIT 0,' .$maxNumberOfNextEvents);
		$stmt->execute();

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			echo '<div class="col-sm-6 col-md-3">';
			echo '<p>';

			printVeranstaltungTitle($row);
			printVeranstaltungTime($row);

			echo '</p>';
			echo '</div>';
		}

		if($semesterCoverAvailable){
			echo '<div class="col-sm-6 col-md-3">';
			echo '<div class="thumbnailBox">';
			echo '<div class="thumbnailOverflow">';
			echo '<a href="index.php?pid=semesterprogramm_calendar&amp;semester=' .$libGlobal->semester. '">';
			echo $semesterCoverString;
			echo '</a>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}

		echo '</div>';
	}
}
?>