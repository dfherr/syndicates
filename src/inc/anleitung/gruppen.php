?>

<ol>
W�hrend der Anmeldephase k�nnen Spieler Gruppen bilden.<br>Es k�nnen bis zu <? echo MAX_USERS_A_GROUP; ?> Spieler einer Gruppe angeh�ren.
Spieler die bei Rundenstart in einer Gruppe sind, werden gemeinsam einem Syndikat zugeteilt, k�nnen auf
die Weise also zusammen Spielen.<br>
Solange die Runde noch nicht gestartet ist, kann man jederzeit einer Gruppe beitreten oder diese wieder verlassen.
Um einer Gruppe beizutreten ist die Kenntnis der Gruppennummer sowie des Gruppenpassworts n�tig.
<br>
Der Gruppenadministrator kann eine Gruppe schlie�en. <i>[nur Classic-Server]</i> Einer geschlossenen Gruppe,
die mindestens <? echo USERS_NEEDED_FOR_CLOSED_GROUP; ?> Spieler hat, wird bei Rundenstart ein eigenes Syndikat zugewiesen.
<br>
Der Gruppenadministrator kann ferner Spieler aus der Gruppe ausschlie�en und das Gruppenpasswort �ndern.<br>
Verl�sst der Gruppenadministator die Gruppe, wird der bestimmte Nachfolger zum Gruppenadministrator.
Ist der Gruppenadministrator der letzter Spieler der Gruppe, wird die Gruppe gel�scht, wenn er sie verl�sst.
<br>
Jeder Gruppe steht ein eigenes Forum zur Verf�gung, in dem man sich vor Rundenstart schonmal unterhalten und letzte Dinge kl�ren kann.
Die Eintr�ge sind nach Anfang der Runde nicht mehr verf�gbar, es sei denn die Gruppe war geschlossen und hat ihr eigenes Syndikat erhalten.
</ol>

<?
