<?
require_once("../includes.php");
connectdb();
if (!$argv[1]) exit("\n\nKeine Datenbank �bergeben! Abbruch\n\n");
$db = $argv[1];
mysql_select_db($db);


$time = time();
$tag = date("d",$time);
$monat = date("m",$time);
$jahr = date("Y",$time);
$stunde = date("H",$time);
$minute = date("i",$time);
$sekunde = date("s",$time);

	$ki_pfad_absolut =DATA."konzernimages/";
	$disapproved_pfad_absolut = PUB."php/admin/konzernimages_disapproved/";


$globals = assoc("select * from globals order by roundstarttime desc limit 1");

if (!$globals['updating']) {

	$casedata = assocs("select * from admin_case where status = 4", "id");
	$punishments = assocs("select * from admin_punishment_settings", "id");

	foreach ($casedata as $case_id => $data) {
		$involved_data = assocs("select * from admin_case_involved where case_id = $case_id", "user_id");
		select("update admin_case set status = 5, endtime = $time where id = $case_id");
		select("insert into admin_case_messages (case_id, type, message_text, time) values ($case_id, 5, '<b>Die festgelegten Strafen wurden durchgef�hrt, der Case geschlossen.</b>', $time)");

		foreach ($involved_data as $user_id => $idata) {
			$subject = "";
			$message = "";
			$pid = $idata['punishment_id'];
			$userdata = assoc("select * from users where id = $user_id");
			$punishment_endtime = 0;
			echo "strafe:".$punishments[$pid]['gruppe']."\n";
			if ($punishments[$pid]['gruppe'] == "nothing") {
				1; // Nichts eben
			}
			elseif ($punishments[$pid]['gruppe'] == "warning") {
				$subject = $punishments[$pid]['bezeichnung'];
				$message = "Du bist hiermit verwarnt.\nWeiteres Verletzen der Nutzungsbedingungen kann Geldstrafen in Form von Cr-Abzug oder tempor�ren Spielausschluss bis hin zu L�schung des Konzerns zur Folge haben!\n\nBegr�ndung:\n".$idata['fazit_user'];
			}
			elseif ($punishments[$pid]['gruppe'] == "tempban") {
				$subject = "Tempor�rer Spielausschluss";
				$punishment_endtime = $time + 3600 * $punishments[$pid]['wert'];
				$message = "Du bist tempor�r bis zum ".date("d.M., H:i:s", $punishment_endtime)." (".$punishments[$pid]['wert']."h) aus dem Spielgeschehen ausgeschlossen. Dein Konzern kann nach wie vor angegriffen und ausspioniert werden und kann in dieser Zeit auch inaktiv werden, jedoch wird er nicht automatisch nach den �blichen 5.5 Tagen gel�scht.\n\nBegr�ndung:\n".$idata['fazit_user'];
				select("update users set banned = $punishment_endtime where id = $user_id");
				select("update sessionids_actual set gueltig_bis = $time where user_id = ".$userdata['konzernid']."");
			}
			elseif ($punishments[$pid]['gruppe'] == "delete") {
				$subject = "Dein Konzern wurde gel�scht";
				$message = "Dein Konzern wurde wegen �bertretens der Nutzungsbedingungen gel�scht.\n\nBegr�ndung:\n".$idata['fazit_user'];
				kill_den_konzern(0,0,4,$user_id);
			}
			elseif ($punishments[$pid]['gruppe'] == "suspend") {
				
				$message = "Dein Konzern wurde wegen des Verdachtes eine Versto�es gegen die Nutzungsbedingungen vorr�bergehend vom Spiel ausgeschlossen.\n\nBegr�ndung:\n".$idata['fazit_user'];
				$punishment_endtime = $time + 3600 * $punishments[$pid]['wert'] * 24;
				select("update users set banned = $punishment_endtime where id = $user_id");
				select("update sessionids_actual set gueltig_bis = $time where user_id = ".$userdata['konzernid']."");
				$hisStatus = assoc("select * from status where id=".$userdata['konzernid']);
				if($punishments[$pid]['wert']>0){
					//umode an
					echo"umodean";
					$subject = "Dein Konzern wurde suspendiert";
					$message = "Dein Konzern wurde wegen des Verdachtes eine Versto�es gegen die Nutzungsbedingungen vorr�bergehend vom Spiel ausgeschlossen.\n\nBegr�ndung:\n".$idata['fazit_user'];
					select("update status set alive = 2 where id =".$userdata['konzernid']);
					$msgforakt = "Der Konzern ".$hisStatus['syndicate']." (#".$hisStatus['rid'].") wurde vorr�bergehend aus dem Spiel ausgeschlossen [Verdacht des Versto�es gegen die Nutzungsbedingungen]";
				} else {
					echo"umodeaus";
					//umode aus
					$subject = "Suspendierung aufgehoben";
					$message = "Du kannst dich nun wieder ganz normal in deinen Konzern einloggen.\n\nBegr�ndung:\n".$idata['fazit_user'];
					select("update status set alive = 1 where id =".$userdata['konzernid']);
					$msgforakt = "Die Suspendierung des Konzern ".$hisStatus['syndicate']." (#".$hisStatus['rid'].") wurde aufgehoben.";
				}
				select("insert into towncrier (time,rid,message) values ($time,'".$hisStatus['rid']."','$msgforakt')");	
			}
			elseif ($punishments[$pid]['gruppe'] == "geldstrafe") {
				$subject = "�bertreten der Nutzungsbedingungen";
				$message = "Dein Konzern hat die Nutzungsbedingungen verletzt und erh�lt deshalb eine Geldstrafe in H�he von ".pointit($punishments[$pid]['wert'])." Cr.\n\nBegr�ndung:\n".$idata['fazit_user'];
				select("update status set money = money - ".$punishments[$pid]['wert']." where id = ".$userdata['konzernid']);
			}
			if ($idata['konzernbild_deleted']) {
				if (!$subject) $subject = "Dein Konzernbild wurde gel�scht.";
				if (!$message) $message = "Dein Konzernbild wurde gel�scht.\n\nBegr�ndung:\n".$idata['fazit_user'];

					$imageendung = single("select image from status where id=".$userdata['konzernid']);
					$servertypespecific = getServertype() == "basic" ? "basic_" : "";
					echo "\npfad:\n".$ki_pfad_absolut."konzern_".$userdata['konzernid'].".".$imageendung."\n\n";
					if (file_exists($ki_pfad_absolut."konzern_".$userdata['konzernid'].".".$imageendung))	{
						echo "\n\nda 1\n\n";
						$number = single("select number from admin_konzernimages_disapproved where user_id='".$user_id."' order by time desc limit 1");
						$number++;
						if (copy($ki_pfad_absolut."konzern_".$servertypespecific.$userdata[konzernid].".".$imageendung, $disapproved_pfad_absolut."user_".$user_id."_".$servertypespecific.$number.".".$imageendung))	{
						echo "\n\nda 2\n\n";
							select("insert into admin_konzernimages_disapproved (user_id, round, time, number, dateiendung, punishment) values ('".$userdata[user_id]."','".$globals['round']."','$time','$number','".$imageendung."','0')");
						}
						if (unlink($ki_pfad_absolut."konzern_".$servertypespecific.$userdata[konzernid].".".$imageendung))	{
						echo "\n\nda 3\n\n";
							select("update status set image='' where id='".$userdata['konzernid']."'"); # Wichtig damit Bild nicht nochmal erscheint beim n�chsten Aufruf
						}
						select("insert into message_values (id, user_id, time) values ('19', '".$userdata['konzernid']."', '$time')");
					}
			}
			if ($idata['konzernname_deleted']) {
				if (!$subject) $subject = "Dein Konzernname wurde gel�scht.";
				if (!$message) $message = "Dein Konzernname wurde gel�scht. Du kannst dir unter Optionen einen neuen Namen einstellen.\n\nBegr�ndung:\n".$idata['fazit_user'];
				$ncnumber = 1;
				// wenn Feature, dann zwei mal, damit das Feature nicht weg f�llt (r�hrt von der Implementierung in options.php her)
				if (single("select count(*) from features where konzernid = ".$userdata['konzernid']." and feature_id = ".KOMFORTPAKET)) {
					$ncnumber = 2;
				}
				select("update status set nc = nc + $ncnumber, syndicate = '".$userdata['konzernid']."', rulername='Gesch�ftsf�hrer' where id = ".$userdata['konzernid']);
			}
			if ($idata['konzernbeschreibung_deleted']) {
				if (!$subject) $subject = "Deine Konzernbeschreibung wurde gel�scht.";
				if (!$message) $message = "Deine Konzernbeschreibung wurde gel�scht.\n\nBegr�ndung:\n".$idata['fazit_user'];
				select("update settings set kategorie = '', description = '' where id = ".$userdata['konzernid']);

			}

			if ($subject && $message) {

				sendthemail($subject,$message."\n\nMit freundlichen Gr��en,\nDas Syndicates Game-Master-Team",$userdata['email'],$userdata['vorname']." ".$userdata['nachname']);

				sendthemail("GM-TRACKING -- $subject",$message."\n\nMit freundlichen Gr��en,\nDas Syndicates Game-Master-Team\n\nKonzernid: ".$userdata['konzernid'],"info@DOMAIN.de");

				select("insert into messages (user_id, sender, time, betreff, message) values (".$userdata['konzernid'].", 0, $time, '$subject', '".preg_replace("/\n/", "<br>", $message."\n\nDu kannst auf diese Mitteilung nicht antworten.\nBei R�ckfragen wende dich bitte per PN �bers Forum oder per eMail an einen der Game-Master")."')");

			}
			select("update admin_case_involved set punishment_starttime = $time, punishment_endtime = ".($punishment_endtime ? $punishment_endtime : $time)." where id = ".$idata['id']);
		}
	}

}


#####################################
?>
