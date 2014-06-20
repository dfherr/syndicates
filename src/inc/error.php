<?php

ob_start();
if ($code == 1) {print "Account nicht vorhanden";}
elseif ($code == 2) {print "Benutzername und/oder Passwort nicht eingegeben";}
elseif ($code == 3) {
	$tuser = htmlentities($tuser,ENT_QUOTES);
	echo "
	<br>
	Besitzen Sie schon einen <a href=$game[BETREIBER_portal_anmeldung]&ref_src=syndicates class=gelblink>BETREIBER-Account</a>? Syndicates ist ab Runde zw�lf nur noch mit einem BETREIBER-Account spielbar.<br>
	Melden Sie sich einfach einen <a href=$game[BETREIBER_portal_anmeldung]&ref_src=syndicates class=gelblink>BETREIBER-Account an</a>.<br><br>
	Wenn Sie das Passwort f�r Ihren BETREIBER-Account vergessen haben, klicken Sie bitte <a href=\"http://BETREIBER.de/index.php?action=pwforgotten&ia=resend&user=$tuser\" class=\"gelblink\">hier</a>.<br><br>";
}
elseif ($code == 31) {
	printmailform();
}
elseif ($code == 4) {print "Dieser Account ist leider nicht mehr verf�gbar";}
elseif ($code == 5) {print "Das Loginsystem konnte Ihnen leider keinen Account zuordnen. Bitte vergewissern Sie sich, dass ihr Browser Cookies akzeptiert. Wenn Cookies aktiviert sind und dieser Fehler trotzdem auftritt, loggen Sie sich bitte aus, schlie�en Sie ihren Browser und versuchen sie erneut, sich einzuloggen. Bei weiteren Problemen wenden Sie sich bitte an den BETREIBER Support unter support@DOMAIN.de.";}
elseif ($code == 6) {print "Ihr Sessionid ist abgelaufen, bitte loggen sie sich neu ein.";}
elseif ($code == 7) {print "In dem Syndikat, dem Sie beitreten wollen, ist kein Platz mehr vorhanden";}
elseif ($code == 8) {print "Du kannst dich mit deinem BETREIBER-Account nicht auf dem Basic-Server anmelden!";}
elseif ($code == 9) {print "Du bist nicht eingelogt!";}
elseif ($code == 10) {print "Die E-Mail-Adresse die zu deinem KOINS-Account geh�rt wird bereits verwendet. Du kannst deine BETREIBER-Accountdaten <a href=\"http://BETREIBER.de/index.php?action=pwforgotten\" class=\"gelblink\">hier</a> erfragen.";}
elseif ($code == 14) {print "Es ist bereits ein Konzern f�r diesen Account registriert! Dein KOINS Account wurde mit deinem BETREIBER-Account zusammengelegt. Du kannst dich entweder �ber KOINS oder BETREIBER einloggen.";}
elseif ($code==12345) {print "Die Anmeldung ist 120 Sekunden vor Rundenstart nicht m�glich, da jetzt bereits die Spieler den Syndikaten zugewiesen werden. Versuchen Sie es bitte in 2 Minuten erneut.";}
elseif ($code==15793) {print "Sie sind wegen wiederholtem Regelversto� permanent von der Teilnahme an Syndicates ausgeschlossen.";}
elseif ($code==65957) {print "Sie haben sich bereits angemeldet.";}
elseif ($code==66666) {print "Sie haben innerhalb von 5 Sekunden mindestens zweimal geklickt. Es ist vor�bergehend nicht erlaubt, innerhalb von 5 Sekunden zwei oder mehrmals zu klicken. Sie wurden daher ausgeloggt, und m�ssen 2 Minuten warten, bevor Sie sich wieder einloggen k�nnen."; }
elseif ($code==76453) {print "Sie m�ssen den beim Login angezeigten Code eingeben! Sollte dies wiederholt nicht funktionieren, leeren Sie bitte Ihren Browsercache.";}
elseif ($code==78453) {print "Ihre Session-ID ist abgelaufen. Bitte loggen Sie sich erneut ein, um weiterspielen zu k�nnen.";}
elseif ($code==83647) {print "Pro Tag d�rfen nur zwei Konzerne angemeldet werden.";}
elseif ($code==84561) {print "Sie k�nnen sich nicht einloggen, solange Sie keinen Konzern angelegt haben!";}
//Account gebannt
elseif ($code==84562) {
    $till = single("select banned from users where id='$userid'");
    $bis = date("d.m.y u\m H:i \U\h\\r",$till);
    if ($bis) {
        print "Ihr Syndicates Account ist noch bis zum $bis vom Spiel ausgeschlossen.<br>Dies kann folgende Gr�nde haben:<br><br><ol type=1><li>Sie haben innerhalb von 5 Sekunden zwei mal geklickt und wurden deshalb f�r 2 Minuten aus dem Spiel ausgeschlossen. <!--Um das Update m�glichst schnell ausf�hren zu k�nnen ben�tigt der Server freie Kapazit�ten. Durch das viele Klicken werden diese Kapazit�ten jedoch eingeschr�nkt, weshalb diese Regel leider notwendig ist.--><br><br><li>Eine andere, weniger wahrscheinliche M�glichkeit, wieso Sie vom Spiel ausgeschlossen wurden besteht darin, dass Sie gegen die Nutzungsbedingungen versto�en haben. Die h�ufigsten Verst��e, die zu diesem Ausschluss f�hren, bestehen in Beleidigungen anderer Mitspieler. Den genauen Grund f�r Ihren Ausschluss haben Sie in diesem Fall in einer an Sie verschickten e-Mail mitgeteilt bekommen.</ol>";
    }
    else {
        print "Ihr Syndicates Account ist momentan wegen Versto� gegen die Nutzungsbedingungen vom Spiel ausgeschlossen.";
    }
}

// Payment: 9xxxx
// �bergibt immer $errorstatus

elseif($code == 90001) {
	print "<br>Login nicht m�glich, ihr Abonnement ist nicht bezahlt: '$errorstatus.'. Sie k�nnen Syndicates unbegrenzt lange kostenlos testen, m�chten Sie in den Genuss s�mtlicher Features kommen, m�ssen Sie ein <a href=\"index.php?action=abo\" class=gelblink>Abonnement</a> abschlie�en, wenn Sie weiterspielen m�chten.";
}



// Inner stuff

if ($ia === "sendmail" && checkmail($mail)) {
	$userdata = assoc("select * from users where email='$mail'");
	if (!$userdata) {
		echo "Es ist kein Nutzer mit dieser E-Mail-Adresse im System bekannt.<br>";
		printmailform();
	}
	else {
		$betreff = "Passwortanfrage";
		$message = "Hallo ".$userdata[username].",\n\nSie erhalten, wie angefordert, mit dieser E-Mail Ihre Zugangsdaten.\nWir m�chten Sie darum bitten, diese Mail aus Sicherheitsgr�nden unverz�glich zu l�schen.\n\n\nIhre Syndicates Zugangsdaten lauten:\n\nBenutzername: ".$userdata[username]."\nPasswort: ".$userdata[password]."\n\nViel Spa� weiterhin bei Syndicates w�nscht Ihnen Ihr Syndicates Admin-Team.";
		$tmail = $mail;
		$to = $userdata[vorname]." ".$userdata[nachname];
		sendthemail($betreff,$message,$tmail,$to);
		echo "<br>Ihr Spielpasswort wurde an Ihre bei Syndicates angegebene E-Mail-Adresse versandt.";
	}
}
elseif($ia === "sendmail") {
	echo "Bitte geben sie eine g�ltige E-Mail-Adresse ein.<br>
	";
	printmailform();
}




function printmailform() {
echo "<br><br>Wenn Sie das Passwort f�r Ihren alten Syndicates Account vergessen vergessen haben, k�nnen Sie es sich an Ihre bei Syndicates angegebene Adresse schicken lassen. Sie k�nnen Ihren Syndicates Account anschlie�end mit einem neuen BETREIBER-Account verkn�pften, um Ihre Statistiken zu behalten.<br><br><form action=\"index.php\" method=post> E-Mail-Adresse: <input name=mail value=\"\"><input name=ia value=sendmail type=hidden><input name=action value=error type=hidden> <input type=\"submit\" value=\"abschicken\"> </form>"; 
}

// fehler in db eintragen
if (!$time) {$time = time();}
if ($time && $code) {
	select("insert into errors (error_id,time) values ($code,$time)");
}


$error_ausgabe = ob_get_contents();
ob_clean();


// Danach std-seite anzeigen
require_once(INC."main.php");

?>

