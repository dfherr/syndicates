<?
	$redac = floor($redac);
	if ($redac == 1) {
		$modrprot = 60*60*12;
		select("update status set createtime = createtime - $modrprot,reduce_protection=-1 where id=$status[id]");
		$status[reduce_protection] = 0;
		$status[createtime] -= $modrprot;
	}
	elseif ($redac == 2) {
		select("update status set reduce_protection=0 where id=$status[id]");
		$status[reduce_protection] = 0;
	}


if ($status[reduce_protection] == 1) {

	i("Wir haben heute nacht um 04:00 Uhr ein Backup von Mittwoch 04:00 Uhr eingespielt (n�heres dazu in den News). Da einige Spieler dadurch nicht die M�glichkeit hatten,
	Verteidigungseinheiten zu bauen, wurde die Schutzzeit f�r JEDEN Spieler OPTIONAL um 12 Stunden verl�ngert (d.h. jeder Spieler hat jetzt 3 Tage und 12 Stunden Schutzzeit). Wenn du m�chtest, kannst du auf die 12 Stunden zus�tzliche Schutzzeit verzichten:<center><br><br>
	<a href=\"statusseite.php?redac=1\">Ich m�chte auf die zus�tzliche Schutzzeit VERZICHTEN</a><br><br>
	<a href=\"statusseite.php?redac=2\">Ich AKZEPTIERE die verl�ngerte Schutzzeit von 12 Stunden</a></center>"
	);
}


?>