?><font class="normal">

<i>Konzerne ab einer Gr��e von 2000 ha Land sind bereits so stark, dass sich kleinere Organisationen, Firmen und Konzerne daf�r interessieren, von diesen unter Schutz genommen zu werden. Deshalb gehen sie mit diesem eine "Partnerschaft" ein. Sie geben dem Konzern einen Teil ihrer Einnahmen und bekommen im Gegenzug Schutz von ihm.</i><br>Spieltechnisch muss nat�rlich niemandem tats�chlich "Schutz" gew�hrt werden. Die erw�hnten "Organisationen, Firmen und Konzerne" bestehen aus fiktiven "NPCs" (Non Player Character), die sich nur dadurch im Spiel bemerkbar machen, dass man von Ihnen Boni bekommt.<br>Man kann sich also ab einer Gr��e von 2000 Hektar Land einen der folgenden Boni aussuchen. Bei einer Gr��e von 3000, 4000 und 5000ha kann man sich dann nochmals je einen Bonus aussuchen (man kann den selben <b>nicht</b> mehrmals w�hlen). Zu beachten ist, dass die Wahl dauerhaft ist und sp�ter nicht mehr ge�ndert werden kann. Hat man einmal die Grenze (2000, 3000, 4000, 5000) zum Ausw�hlen eines Bonus erreicht, beh�lt man das Recht sich einen Bonus aussuchen zu d�rfen auch bei Landverlust unter die Grenze weiterhin. Die Wahl eines Bonus entspricht sinnbildlich dem Sch�tzen eines "kleinen unbedeutenden fiktiven NPC-Konzerns", wodurch man im Gegenzug dessen "Einnahmen" bekommt, welche f�r die St�rkung des eigenen Konzerns verwendet werden und im entsprechenden Bonus resultieren.<br>Um die verschiedenen Runden abwechslungsreicher zu gestalten, stehen nicht jede Runde alle Boni zur Auswahl zur Verf�gung. Welche Boni zur Verf�gung stehen, k�nnt ihr aus der Tabelle entnehmen. Die Boni f�r die jeweils n�chste Runde werden erst 7 Tage vor Rundenende ermittelt!<br>Hier nun die m�glichen Boni, die zur Auswahl stehen (sie entsprechen prinzipiell, mit ein paar kleineren Ausnahmen, den Stufe-1-Forschungen):

<?
$act_round = $globals[round];
if ($globals[roundendtime] < $time) $act_round++;
$partner_settings_general = assocs("select * from partnerschaften_general_settings order by id asc", "id");

$partner_available_actual = singles("select id from partnerschaften_settings where round = $act_round");
$partner_available_next = singles("select id from partnerschaften_settings where round = ".($act_round+1));

foreach ($partner_settings_general as $ky => $vl) {
	$lines .= "<tr class=body><td align=center>$ky</td><td align=center>".(in_array($ky, $partner_available_actual) ? "<font class=hellgruen11>JA</font>":"<font class=rot11>NEIN</font>")."</td><td align=center>".($partner_available_next ? (in_array($ky, $partner_available_next) ? "<font class=hellgruen11>JA</font>":"<font class=rot11>NEIN</font>") : "?")."</td><td>$vl[bonus]</td></tr>";
}

?>
<br><br>
<table width="700" cellspacing="1" cellpadding="0" border="0" class=rand align=center>
	<tr>
		<td>
			<table width="100%" cellspacing="0" cellpadding="4">
			<tr class=head>
				<td width="20" align=center><b>#</b></td>
				<td width="100" align="center"><b>Aktuell</b></td>
				<td width="100" align="center"><b>Runde <? echo ($act_round-1) ?></b></td>
				<td width="480" align="left"><b>Bonus</b></td>
			</tr>
			<? echo $lines ?>
			</table>
		</td>
	</tr>
</table>


<?
