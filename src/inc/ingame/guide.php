<?

if ($inner == "tutend" && $tutendaccept == "on") {
	$status[tutorial] = 0;
}




$istyle = "style=\"color:black;text-decoration:underline;font-size:12px;\"";

if ($status[tutorial] >= 1 && $status[tutorial] < 8 || $tview) {

	if (!$tview) $tview = $status[tutorial];
	
	$tsteps = array(
		1 => array("�bersicht","statusseite.php?tview=1"),
		2 => array("Konfigurationsphase","configseite.php?tview=2"),
		3 => array("Land & Geb�ude","gebaeude.php?tview=3"),
		4 => array("Forschung","forschung.php?tview=4"),
		5 => array("Milit�r","militaerseite.php?tview=5"),
		6 => array("Bauauftr�ge","berater.php?tview=6"),
		7 => array("Viel Erfolg!","statusseite.php?tview=7"),
	);

	$tutmenu = "";
	foreach($tsteps as $k => $temp) {
		$tutmenu.="
			<a  $istyle href=\"$temp[1]\" class=\"linkAuftableInner\">
				";
				if ($k == $tview) $tutmenu.="<b>";
				$tutmenu.= "$k. ".$temp[0];
				if ($k == $tview) $tutmenu.="</b>";
			$tutmenu.="
			</a>&nbsp";	
			if ($k < count($tsteps)) $tutmenu.="|&nbsp;";
	}
	$tutmenu.="| <a align=\"right\" $istyle href=\"?tend=true\" class=\"linkAuftableInner\">Tutorial beenden</a><br>";

	i ($tutmenu);
	// Welcome - Schritt 1
	if($tview == 1) {
	
		i("<b><u>Tutorial - �bersicht</u></b><br><br>

		Hallo <b>$status[rulername]</b>! Wir begr��en dich herzlich als neuen Gesch�ftsf�hrer von <b>$status[syndicate]</b> und Mitglied des Syndikats!<br>
		Dies ist eine kleine Einf�hrung, die es dir erleichtern soll, in die Welt von Syndicates einzudringen.<br><br>

		Fangen wir an!<br>
		Wir werden nacheinander in 6 Schritten die anfangs ben�tigten Aspekte von Syndicates durchgehen. Du kannst dir zuerst alle Schritte durchlesen, bevor du wirklich etwas tust. Dies ist vor allem bei der Wahl der richtigen Konfiguration wichtig.<br><br>

		In der Leiste oben siehst du das aktuelle Guthaben deines Konzerns. Du hast zu Beginn ein kleines Startkapital erhalten. Von links nach rechts wird in der Leiste der Firmenwert (Networth) deines Konzerns, seine Landmenge (in Hektar), dein Guthaben (in Credits), deine Stromreserven (in MWh), deine Erzreserven, deine Forschungspunkte und schlie�lich die aktuelle (Syndicates-)Zeit angegeben.<br><br>

		Die aktuelle �bersicht im Hauptbildschirm ist die Statusseite. Sie bietet dir einen �berblick �ber deine Ressourcenproduktion und den Besitz deines Konzerns. Um deine Wirtschaft in Gang zu bringen, musst du erst deinen Konzern konfigurieren. Wechsele dazu bitte zu dem Men�punkt <a $istyle href=configseite.php?tutnext=2 class=linkAuftableInner>'Konfiguration'</a>.");


	
	}

	// Schritt 2
	if($tview == 2) {

i("
	".bu("Tutorial - Konfigurationsphase")."<br><br>

	In der Konfigurationsphase kannst du der Strategie deines Konzerns die erste Ausrichtung geben. Du startest mit 100 Rangern und 1.700 Punkten. Das Punktesystem erm�glicht es dir mit Hilfe dieser Punkte Land, Einheiten, Forschungen und Ressourcen zu erwerben.<br><br>

	Geb�ude sind w�hrend der Konfigurationsphase gratis, also bebaue dein komplettes Land auch mit Geb�uden. Am Besten mit m�glichst wenig verschiedenen Geb�udearten. Schau dir dazu auch die Beispielkonzerne an, die du rechts am Rand ausw�hlen kannst.<br><br>

	F�r Neueinsteiger gibt es vordefinierte Beispielkonzerne, die es lohnt f�r das erste Spielvergn�gen auszuw�hlen, da somit eine stabile Grundlage f�r den Einstieg gew�hrleistet ist.<br><br>

	Ein Beispiel, sowie eine genauere �bersicht �ber die Konfiguration, findest du <a $istyle href=".WIKI."/Tutorial#Erste_Schritte class=linkAuftableInner target=_blank>im Tutorial der Synpedia</a>.<br><br>

	Wenn du mit deiner Konfiguration zufrieden bist, klicke ganz unten auf den Button 'Konfiguration beenden'.
	<br><br>Anschlie�end geht es <a $istyle href=gebaeude.php?tutnext=3 class=linkAuftableInner>hier weiter</a>.");


	}


	// Schritt 3
	if($tview == 3) {

		i("
".bu("Tutorial - Land und Geb�ude")."<br><br>

Eine gesunde wirtschaftliche Basis geh�rt zu den wichtigsten Aspekten bei Syndicates. In der Konfigurationsphase konntest du ja schon kostenlos Geb�ude bauen.<br>
Wenn man eine Ressource produziert, sollte man dringend darauf achten, dass die Geb�ude die diese Ressource produzieren mehr als 35% des Landes einnehmen, da man daf�r einen gro�z�gigen Zuschlag, den so genannten Synergiebonus erh�lt.<br>
Dies bedeutet gleichzeitig, dass man maximal zwei verschiedene Ressourcen gleichzeitig produzieren sollte!<br><br>

Trotzdem ben�tigt man alle der vier im Spiel verf�gbaren Ressourcen.<br>
Die weiteren Ressourcen kannst du dir am <a $istyle href=market.php class=linkAuftableInner>Globalen Markt</a> kaufen. Du kannst sie eventuell aber auch aus dem Lager entnehmen, wenn die n�tigen Ressourcen im Lager nicht vorhanden sind, gibt es die M�glichkeit andere Syndikatsmitglieder, die gerade online sind danach zu fragen.<br>
Eine besondere Stellung unter den Ressourcen nimmt Energie ein. Jedes Geb�ude hat einen gewissen Energieverbrauch (von Kraftwerken abgesehen). Wenn du keine Energie mehr hast sinkt die Leistung deiner Geb�ude. Es ist daher sinnvoll entweder selbst gen�gend Energie zu produzieren oder sich mit einem kleinen Vorrat einzudecken!<br><br>

Die Fertigstellung neuer Geb�ude dauert im Normalfall 20 Stunden (bei UIC 16h). Wenn du neues Land kaufst, ist dieses ebenfalls in 20 Stunden (NEB 15h) verf�gbar.<br>
Informationen �ber die einzelnen Geb�ude findest du <a $istyle href=".WIKI."/Geb%C3%A4ude_und_Land_(Men%C3%BCpunkt)#Geb.C3.A4udetypen class=linkAuftableInner target=_blank>hier</a>.<br><br>

Je mehr du produzieren willst, desto mehr Land wird auch ben�tigt, also denke immer daran, dass du wachsen musst um gen�gend zu produzieren.<br><br>

Nachdem du nun einen ersten �berblick zu Land und Geb�uden bekommen hast, geht es <a $istyle href=forschung.php?tutnext=4 class=linkAuftableInner>im n�chsten Schritt weiter</a>.
");

	}


	// Schritt 4
	if($tview == 4) {

i("
".bu("Tutorial - Forschung")."<br><br>

Du befindest dich jetzt auf der Forschungsseite. Forschungen spielen in Syndicates eine wichtige Rolle. Durch Forschung ist es m�glich, modernere Geb�ude zu errichten oder fortschrittlichere Milit�reinheiten zu konstruieren. Die Forschungszeit ist eines der wichtigsten G�ter, deshalb solltest du darauf achten, m�glichst ununterbrochen zu forschen!<br><br>

Die Forschungen sind in drei Zweige unterteilt:<br>
Milit�r-Forschungen / Industrie-Forschungen / Spionage-Forschungen<br><br>

Langfristig wird es von deiner Strategie abh�ngen, welche Forschungen du ben�tigst.<br><br>

F�r den Anfang macht eine Forschung aus dem Bereich 'Industrial Sciences' Sinn. Genauer gesagt nimmt man am besten eine Forschung die die eigene Ressourcenproduktion erh�ht, wie zum Beispiel 'Better Ore Mining', 'Advanced Power Management' oder 'Pure Capitalism'.<br><br>

Wenn du deine Forschungspunkte sparen willst oder nicht gen�gend Forschungspunkte zur Verf�gung hast, machst du mit 'Gamble' auf jeden Fall nichts falsch. (Eine Art Gl�ckspiel, die Teilnahme ist kostenlos, das Ergebnis aber zuf�llig). Wenn du selbst Forschungspunkte produzieren willst, musst du daf�r Forschungslabore bauen (wie in Schritt zwei des Tutorials gezeigt).<br><br>

Sofort nach Rundenbeginn hast du die M�glichkeit innerhalb deines Syndikats Forschungspunkte zu ertauschen. Dazu kannst du einfach Mitglieder deines Syndikats anschreiben (Men�punkt <a $istyle href=mitteilungen.php class=linkAuftableInner>Mitteilungen</a>) oder du er�ffnest einen Tauschbeitrag im <a $istyle href=syndboard.php class=linkAuftableInner>Syndikatsforum</a>.<br><br>

Oder du kaufst dir von deinen Credits Forschungspunkte von beliebigen Spielern unter dem Men�punkt '<a $istyle href=market.php class=linkAuftableInner>Global Market</a>' -> 'Rohstoffe erwerben'.<br><br>

Wenn du dich f�r eine Forschung entschieden hast ".($page == "forschung" ? "":"(Men�punkt Forschung - nach unten scrollen und 'erforschen' anklicken)")." geht es <a $istyle href=militaerseite.php?tutnext=5 class=linkAuftableInner>weiter zum n�chsten Schritt</a>.");
	

	}

	// Schritt 5
	if($tview == 5) {

i("
".bu("Tutorial - Milit�r")."<br><br>

Du befindest dich jetzt auf der Milit�rseite. Hier kannst du Milit�reinheiten und Spione rekrutieren. Au�erdem siehst du, wieviele Milit�reinheiten du besitzt und wieviele du noch bauen kannst.<br><br>

Es ist wichtig, dass du deinen Konzern immer vor Angriffen und Spionageaktionen so gut wie m�glich sch�tzt, sonst wirst du sehr schnell von anderen Spielern angegriffen (d.h. du verlierst einen Teil deines Landes) oder ausgeraubt (d.h. dir werden Ressourcen gestohlen). Am Anfang bieten Ranger einen guten Schutz und sind dazu recht g�nstig. Zur Spionageabwehr bieten sich ".($status['race'] == "sl" ? "'Hacker'":"'Guardians'")." an. Schaue aber auch unbedingt auf dem Global Market nach Milit�reinheiten. Hier gibt es Anbieter, die sich auf den Verkauf von Einheiten spezialisiert haben und somit Einheiten sehr g�nstig anbieten k�nnen (unter Umst�nden g�nstiger, als wenn du sie selbst bauen w�rdest!).<br><br>

Durch das Geb�ude '<a $istyle href=".WIKI."/Fabriken class=linkAuftableInner target=_blank>Fabriken</a>' l�sst sich der Preis von Milit�reinheiten senken.<br>
Eine Beschreibung aller Milit�reinheiten findest du <a $istyle href=".WIKI."/Milit%C3%A4reinheiten class=linkAuftableInner target=_blank>hier</a>.<br>
Eine Beschreibung aller Spionageeinheiten findest du <a $istyle href=".WIKI."/Spionageeinheiten class=linkAuftableInner target=_blank>hier</a>.<br><br>

<a $istyle href=berater.php?tutnext=6 class=linkAuftableInner>Weiter zum n�chsten Schritt</a>");
	}

	// Schritt 6
	if($tview == 6) {

$land_to_insert = 2;
$land_in_build = single("select count(*) from build_buildings where user_id = $id and building_id = 127");
$land_inserted = 0;
if ($land_in_build == 0) {
	if ($globals['roundstatus'] == 0 || $time-$status['createtime'] <= 10 * 3600) {
		$land_inserted = 1;
		select("insert into build_buildings (building_name, user_id, number, time, building_id) values ('land', ".$status['id'].", $land_to_insert, ".(get_hour_time($time) + 17 * 3600).", 127)");
	}
}

if ($globals[roundstatus] == 1) {$link="syndboard.php";} else {$link = "statusseite.php";}
i("
".bu("Tutorial - Bauauftr�ge")."<br><br>

Wenn du den Empfehlungen des Tutorials bis hierhin gefolgt bist, hast du schon eine Forschung gestartet. Du kannst hier (unter dem Men�punkt Bauauftr�ge) die absehbare Entwicklung deines Konzerns verfolgen.<br><br>


Die Zahlen (von 1-20) geben an, wie viele Stunden es noch dauert, bis die jeweilige Produktion abgeschlossen ist, die einzelnen Zahlen in den K�stchen geben an, wie viel jeweils gekauft wurde.
".($land_inserted ? "<br>So bedeutet z.B. die Zahl $land_to_insert in der Spalte 17, dass du in 17h $land_to_insert ha Land erh�ltst (die du behalten darfst :-))":"")."
<br><br>

Du kannst hier auch deine Auftr�ge wieder abbrechen. Klicke dazu einfach auf den entsprechenden Eintrag. Das ist besonders n�tzlich, wenn du dich mal verbaut hast.<br><br>

<a $istyle href=$link?tutnext=7 class=linkAuftableInner>Zum n�chsten Schritt</a>");
	}


	// Schritt 7
	if( $tview == 7) {


$tuttext = ("
".bu("Tutorial - Viel Erfolg")."<br><br>

Du hast nun die Grundlagen von Syndicates gelernt. Dies ist jedoch ein sehr vielf�ltiges Spiel welchen von seiner Spieltiefe lebt. Selbst f�r erfahrene Spieler gibt es immer noch etwas zu entdecken. Scheue dich daher nicht Fragen zu stellen oder in die Spielanleitung zu sehen um das Spiel zu verstehen.<br><br>

Ein wichtiger Punkt zum Schluss: Du spielst nicht allein! Syndicates ist ein Teamspiel. ");

if ($globals[roundstatus] == 1) {
$tuttext .= "Du befindest dich mit bis zu ".(MAX_USERS_A_SYNDICATE-1)." weiteren Spielern in einem Syndikat.<br><br>

Nimm unbedingt Kontakt zu deinen Mitspielern auf! <a $istyle href=\"syndboard.php?action=create\" class=linkAuftableInner>Er�ffne</a> am besten jetzt gleich ein neues Thema im Syndikatsforum und stelle dich deinen Mitspielern vor. Im allgemeinen werden Neulinge herzlich willkommen gehei�en. Deine Mitspieler k�nnen dir sicherlich auch viele Tipps mit auf den Weg geben.<br><br>";
} else {

			$tuttext.="Sobald die Anmeldephase zuende ist, wirst du einem Syndikat zugeteilt, das aus bis zu ".(MAX_USERS_A_SYNDICATE)." Spielern besteht. Zusammen bilden diese eine Gruppe und spielen gegen alle anderen Syndikate. Nimm unbedingt Kontakt zu deinen Mitspielern auf, sobald du einem Syndikat zugeteilt worden bist. Neue Spieler sind herzlich willkommen und deine Syndikatskollegen k�nnen dir sicherlich eine Menge n�tzlicher Tipps mit auf den Weg geben.<br><br>";

}
$tuttext .= "Wir verabschieden uns jetzt von dir und hoffen, dass du in Zukunft viel Spa� mit Syndicates haben wirst.<br>
Lies dir die <a $istyle href=".WIKI."/Hauptseite class=linkAuftableInner target=_blank>Anleitung</a> einmal aufmerksam durch, vergiss nicht, dich um Verteidigungseinheiten zu k�mmern und deinem Erfolg als Konzernchef steht nichts mehr im Weg!<br><br>";

if (getServertype() == "basic") {
$tuttext .= "Auf dem Server sind Mentoren verteilt die dir gerne helfen. Wenn du Fragen hast oder allgemein Hilfe ben�tigst, dann schreibe eine Nachricht an einen Mentor. Sie sind in der <a $istyle href=syndicate.php class=linkAuftableInner>Syndikats�bersicht</a> und im <a $istyle href=rankings.php class=linkAuftableInner>Ranking</a> gesondert gekennzeichnet.<br><br>";
}
$tuttext .= "
Du kannst das Tutorial �brigens jederzeit unter dem Men�punkt <a $istyle href=options.php class=linkAuftableInner>Optionen</a> neu starten.<br><br>

<a $istyle href=?tend=true class=linkAuftableInner>Tutorial beenden</a>";

		
		i($tuttext);
	}

	if ($kopf) {
		$kopf = kopf($pagestats{name},$pagestats{hilfedateiname});
	}
	
}


function bu($string) {
 return "<b><u>$string</u></b>";
}

?>
