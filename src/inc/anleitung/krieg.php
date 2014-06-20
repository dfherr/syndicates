?>


Kaum ein Spieler wird auf Dauer Syndicates spielen k�nnen, ohne irgendwann einmal in einen Krieg hineinzugeraten oder vielleicht sogar absichtlich einen anzufangen.<br>
Alle wichtigen Informationen bzgl. Krieg sind hier deshalb nochmals zusammengefasst:<br><br><br>

<ol>
<li><b>Wer kann mit wem Krieg f�hren?</b><br><br>
	<ul>
		<li>In einem Krieg k�nnen maximal sechs Syndikate beteiligt sein, wenn n�mlich zwei 3er-Allianzen gegeneinander antreten.
		<li>Im �brigen ist jede denkbare Konstellation zwischen einzelnem Syndikat und Allianz mit zwei oder drei Syndikaten m�glich
	</ul>
<br>
<li><b>Bedingungen, um Krieg erkl�ren zu k�nnen</b><br><br>
	<ul>
		<li>WICHTIG: Nach einer Kriegserkl�rung dauert es 24h, bis der Krieg wirklich beginnt, also die weiter unten aufgef�hrten �nderungen bei Angriffen und Spionage zu wirken beginnen. Diese Vorwarnzeit dient dazu, dem Gegner die Chance zu gew�hren, sich halbwegs auf den Krieg vorzubereiten und so unfaire Bashaktionen durch die kriegserkl�rende Partei gleich nach der Kriegserkl�rung zu verhindern.
		<li>Befindet sich ein Syndikat in einer Allianz, kann diesem Syndikat alleine kein Krieg erkl�rt werden. M�chte man diesem Syndikat den Krieg erkl�ren, erkl�rt man ihn automatisch auch seinen Allianzpartnern.
		<li>Wenn eine Allianz jemand anderem den Krieg erkl�ren m�chte, m�ssen die Pr�sidenten der an der Allianz beteiligten Syndikate alle zustimmen (derzeit noch nicht implementiert).
		<li>Im Folgenden ist mit der Bezeichnung "Syndikat" auch "Allianz" gemeint. Der Unterschied zwischen Syndikat und Allianz spielt also bei den folgenden Einschr�nkungen keine Rolle.				<li>Ein Syndikat kann erst dann Krieg erkl�ren bzw. erkl�rt bekommen, wenn jeder Spieler im Schnitt 1.000 ha Land besitzt (also Gesamtland/Anzahl_der_Spieler gr��er oder gleich 1.000).
		<li>Das Syndikat, welchem der Krieg erkl�rt werden soll, darf zum Zeitpunkt der Kriegserkl�rung maximal 20% weniger Networth als auch Durchschnittsnetworth (Gesamtnetworth geteilt durch Anzahl der Spieler) haben als das kriegserkl�rende Syndikat. (Beachte Ausnahmeregelung bei Allianzen mit kleinen Syndikaten, siehe n�chster Punkt)
		<li>Syndikaten, die mit mindestens einem anderen Syndikat alliiert sind, welches weniger als 50% des Networths des Syndikats hat, kann unabh�ngig vom Faktor Durchschnittsnetworth der Krieg erkl�rt werden.
		<li>Zwischen zwei Kriegserkl�rungen gegen den selben Gegner muss mindestens soviel Zeit verstreichen, wie der Krieg davor gedauert hat. Das bedeutet, wenn ein krieg 48h lang ging, kann erst 48h nach Ende dieses Krieges ein erneuter Krieg zwischen den selben Parteien erkl�rt werden.
	</ul>
<br>
<li><b>�nderungen bei Angriffen w�hrend eines Krieges</b><br><br>
	<ul>
		<li>Die Angriffstypen "Belagerung" und "Spione zerst�ren" sind w�hrend des Kriegszustandes effizienter, siehe auch <a href=index.php?action=docu&kat=2&aid=12 class=gelblink>Angriff</a>.
		<li>W�hrend eines Krieges werden 50% des Landgewinns bei erfolgreichen Angriffen gleichm��ig unter den Syndikatsmitgliedern aufgeteilt, damit nicht nur die auf den Angriff spezialisierten Spieler einen Nutzen davon haben.
		<li>Es besteht nur ein sehr geringer Schutz vor wiederholten Angriffen.
		<li>Es gibt keine Beschr�nkung der Anzahl ausf�hrbarer Angriffe (f�r gew�hnlich k�nnen nur f�nf Angriffe pro Tag unternommen werden).
		<li>Um zu verhindern, dass einzelne Spieler zu den alleinigen Opfern eines Krieges werden, gilt folgende Priorit�tenregelung:<br>
Bei Spielern, die noch nicht angegriffen wurden (wei� in der Syndikats�bersicht), wird insgesamt 20% mehr Land erobert als gew�hnlich.<br>
Spieler, die bereits einmal angegriffen wurden haben mit normalem Landverlust (100%) zu rechnen.<br>Bei Spielern die mehr als einmal angegriffen wurden, sinkt die Menge eroberten Landes pauschal auf 80% dessen, was erobert w�rde, wenn sie unter normalen Bedingungen angegriffen w�rden.
	</ul>
<br>
<li><b>�nderungen bei Spionage w�hrend eines Krieges</b><br><br>
	<ul>
		<li><b>Sabotage</b>aktionen sind w�hrend des Kriegszustandes effizienter.
		<li>W�hrend eines Krieges kann die Sabotageaktion "Forschung zerst�ren" ausgef�hrt werden.
		<li>Sabotageaktionen werden nicht mehr schw�cher, wenn mehrere Aktionen gegen denselben Spieler ausgef�hrt werden.
		<li>Bei der Sabotageaktion "Milit�reinheiten zerst�ren" wird nun tats�chlich ein Teil der sabotierten Einheiten vernichtet (ca. 40%), der �brige Teil wird nachwievor f�r 12h au�er Gefecht gesetzt.
	</ul>
<br>
<li><b>�nderungen bei Auftr�gen w�hrend eines Krieges</b><br><br>
	<ul>
		<li>Auftr�ge gegen Spieler aus dem/den Syndikat/en des Kriegsgegners k�nnen nicht mehr angenommen werden. Ausnahme: der Auftraggeber kommt aus dem eigenen Syndikat bzw. der eigenen Allianz. (<i>Sinn und Zweck dieser Regel ist, dass das eroberte Land innerhalb der Kriegsparteien bleibt und nicht an Auftraggeber au�erhalb des Krieges verschoben werden kann</i>)
	</ul>
<br>
<li><b>Kriegsende</b><br><br>
	<ul>
		<li>Um zu vermeiden, dass ein Krieg ewig dauert, z�hlt diejenige Partei, die zuerst 12% des Landes, welche sie zu Beginn des Krieges besessen hat, durch den Kriegsgegner in Angriffen verloren hat, abz�glich des selbst eroberten Landes vom Kriegsgegner ("Seilziehen-Prinzip"), als Verlierer des Krieges. Der Gewinner enth�lt entsprechend die Pr�mie (s.o.) und evtl. das Monument des Verlierers (wichtig: der Pr�sident muss einstellen, dass das Monument erobert oder zerst�rt werden soll!).<br>Um der verteidigenden Partei das Gewinnen zu erleichtern, ben�tigt sie je 12h Krieg, die vergangen sind, 3% weniger Landerobung zum Gewinnen, bis nach 4 Tagen der Krieg f�r den Angreifer automatisch verloren ist (es reichen dann -12% Landeroberung f�r den Verteidiger zum Gewinnen, was dann quasi immer erf�llt ist, da der Angreifer sonst schon gewonnen h�tte).
		<li>Jede Partei hat nach 6%-netto-Landverlust bezogen auf das zum Zeitpunkt der Kriegserkl�rung vorhandene Gesamtland die M�glichkeit zu kapitulieren und dadurch den Krieg zu beenden. Ein eventuell vorhandenes Monument geht dabei allerdings verloren.
		<li><b>Kriegspr�mie</b>
			<ul>
				<li>Am Ende eines Krieges bekommt der Gewinner (das Syndikat, welches den Krieg beendet, ist der Verlierer) eine Kriegspr�mie in H�he von 600 Handelspunkten (das ist die interne Syndikatsw�hrung) pro erobertem Land w�hrend des Krieges und pro angefangenem Spieltag zu Beginn der Kriegserkl�rung (beginnt ein Krieg beispielsweise am 14. Tag nach Rundenstart, ist die Pr�mie 8.400 Handelspunkte je erobertem Land). Der ermittelte Wert wird auf die Ressourcen Credits, Erz und Forschungspunkte im Verh�ltnis 2:1:1 aufgeteilt und ins Lager eingezahlt.
25% der Pr�mie wird nach dem Verh�ltnis des eigenen Lands zum Syndikatsgesamtland verteilt.
25% nach Anzahl der erfolgreichen Spionageaktionen (der Schwierigkeitsgrad wird entsprechend< 1=einfach,2=mittel,3=schwer,4=sehr schwer gewichtet).
Die restlichen 50% schlie�lich nach erobortem Land / zerst�rten Geb�uden / zerst�rten Spionen (f�r die Gewichtung z�hlen jeweils 2 eroberte Land aus einem Eroberungsangriff, 1,75 zerst�rte Geb�ude bei einem Belagerungsangriffe bzw. 5 zerst�rte Spione wie 1 erobertes Land aus einem Standardangriff)
Jeder einzelne Spieler erh�lt dann seinen Anteil am Wert dieser Ressourcen als Handelspunkte gutgeschrieben.
				<li><!--Wurde der Krieg innerhalb der ersten 36h gewonnen (dies ist nur durch die 15%-Regel m�glich, s.o.) und b-->Besitzt der Verlierer ein Monument, wird dieses vom Gewinner erobert, sofern der Gewinner mindestens 6% Land netto erobert hat und noch kein Monument besitzt. Andernfalls wird es zerst�rt. (Wichtig: der Pr�sident muss dies allerdings einstellen, sonst wird das Monument zerst�rt!)
			</ul>
	</ul>
<li><b>Sonstiges</b><br>
	<ul><li>W�hrend des Krieges k�nnen keine Spieler gekickt werden oder in das Syndikat wechseln.
	<li>Es k�nnen maximal 2 Kriege zur selben Zeit erkl�rt werden
	</ul>

<br><br>

<?
