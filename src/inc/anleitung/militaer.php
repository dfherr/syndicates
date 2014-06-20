?>
In der rauhen Welt von Syndicates spielt milit�rische Macht eine gro�e Rolle. Wer sich nicht angemessen verteidigen kann, unterliegt schnell im vorherrschenden Machtkampf.<br>
Damit Sie nicht zu den Verlierern geh�ren, gibt es hier einige grundlegende Informationen zu Kampfsystem und Milit�reinheiten in Syndicates.<br><br>
Mit einigen Ausnahmen kann man von jedem beliebigen Spieler angegriffen werden. Verl�uft der Angriff erfolgreich, erobert der Angreifer einen Teil Ihres Landes. Alle darauf errichteten Geb�ude werden dabei vernichtet. Unabh�ngig vom Erfolg der Kampfhandlung verlieren beide beteiligten Seiten einen Teil ihrer Milit�reinheiten (Kampfverluste<font color=green>*</font>).<br>
Aber wann ist ein Angriff erfolgreich ?<br>
Jede Milit�reinheit besitzt eine bestimmte Anzahl an Angriffpunkten (AP) und Verteidigungspunkten (VP). Der Angriff ist genau dann erfolgreich, wenn der Angreifer mehr Angriffspunkte hat, als der Verteidiger Vertedigigungspunkte.<br>
Um eine effiziente Verteidigung aufzubauen, sollten also nach M�glichkeit Einheiten mit vielen Verteidigungspunkten gebaut werden - anfangs empfehlen sich bei allen Fraktionen <i>Ranger</i> wegen der geringen Kosten.<br>
Details zum Angriff finden sie <a href="index.php?action=docu&kat=2&aid=12" class="gelblink">hier</a>.
<br><br>

<b><i>Bau von Milit�reinheiten</i></b><br>
Um neue Milit�reinheiten zu produzieren ben�tigen Sie ausreichend <a href="index.php?action=docu&kat=1&aid=14" class="gelblink">Ressourcen</a> und gen�gend freie Kapazit�ten.<br>
Kapazit�ten ? Auf jeden Hektar Land k�nnen Sie <?=LANDWERT?> Milit�reinheiten bauen, errichten Sie zus�tzlich noch Lagerhallen, k�nnen Sie entsprechend mehr Milit�reinheiten bauen.<br>
Das Produzieren neuer Milit�rinheiten dauert gew�hnlich 20 Z�ge. Sie k�nnen alternativ Milit�reinheiten am <a href="index.php?action=docu&kat=2&aid=7" class="gelblink">Global Market</a> erwerben, diese sind dann schneller verf�gbar.
<br><br>
Jede Fraktion bei Syndicates verf�gt �ber f�nf verschiedene Milit�reinheiten:<br><br><br><br>
<table width=800 cellspacing=0 cellpadding=0 border=0>
	<tr>
		<td>
			<table class=rand cellspacing=1 cellpadding=0 border=0 width=800>
				<tr>
					<td>
						<table class=head cellspacing=0 cellpadding=4 border=0 width=100%>
							<tr>
								<td align=center>
									<b><i>United Industries Corporation:</i></b><br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="800" cellspacing="0" cellpadding="4" border="0" class=body>
							<tr>
								<td width="100" align="left">Name</td>
								<td width="100" align="left">Kampfst�rke</td>
								<td width="150" align="left">Produktionskosten</td>
								<td width="350" align="left">Specials</td>
							</tr>
							<tr><td colspan="4" height="8"></td>
							<?
								$result = mysql_query("select name,op,dp,credits,minerals,energy,specials,sciencepoints from military_unit_settings where race='uic' order by unit_id");
								while($return = mysql_fetch_assoc($result)) {
									if ($return[sciencepoints]) {
										$spstring = ", ".$return[sciencepoints]." P";
										//$sentinelstring = "*";
									}
									if ($return[credits] > 0) {
										$crstring = $return[credits]." Cr,";
									}

									echo("
											<tr><td colspan=\"4\" height=\"8\"></td>
											<tr>
												<td width=\"100\" align=\"left\">$return[name]</td>
												<td width=\"100\" align=\"left\">$return[op] AP".$sentinelstring." / $return[dp] VP".$sentinelstring."</td>
												<td width=\"150\" align=\"left\">$crstring $return[minerals] t, $return[energy] MWh$spstring </td>
												<td width=\"350\" align=\"left\">$return[specials]</td>
											</tr>
									");
									unset($spstring,$crstring);
								} // while
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr><td><br></td></tr>
	<tr>
		<td>
			<table class=rand cellspacing=1 cellpadding=0 border=0 width=800>
				<tr>
					<td>
						<table class=head cellspacing=0 cellpadding=4 border=0 width=100%>
							<tr>
								<td align=center>
									<b><i>Shadow Labs:</i></b><br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="800" cellspacing="0" cellpadding="4" border="0" class=body>
							<tr>
								<td width="100" align="left">Name</td>
								<td width="100" align="left">Kampfst�rke</td>
								<td width="150" align="left">Produktionskosten</td>
								<td width="350" align="left">Specials</td>
							</tr>
							<tr><td colspan="4" height="8"></td>
							<?
								$result = mysql_query("select name,op,dp,credits,minerals,energy,specials,sciencepoints from military_unit_settings where race='sl' order by unit_id");
								while($return = mysql_fetch_assoc($result)) {
									if ($return[sciencepoints]) {
										$spstring = ", ".$return[sciencepoints]." P";
									}
									if ($return[credits] > 0) {
										$crstring = $return[credits]." Cr,";
									}
									echo("
											<tr><td colspan=\"4\" height=\"8\"></td>
											<tr>
												<td width=\"100\" align=\"left\">$return[name]</td>
												<td width=\"100\" align=\"left\">$return[op] AP / $return[dp] VP</td>
												<td width=\"150\" align=\"left\">$crstring $return[minerals] t, $return[energy] MWh$spstring </td>
												<td width=\"350\" align=\"left\">$return[specials]</td>
											</tr>
									");
									unset($spstring,$crstring);
								} // while
							?>

						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td><br></td></tr>
	<tr>
		<td>
			<table class=rand cellspacing=1 cellpadding=0 border=0 width=800>
				<tr>
					<td>
						<table class=head cellspacing=0 cellpadding=4 border=0 width=100%>
							<tr>
								<td align=center>
									<b><i>Brute Force:</i></b><br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="800" cellspacing="0" cellpadding="4" border="0" class=body>
							<tr>
								<td width="100" align="left">Name</td>
								<td width="100" align="left">Kampfst�rke</td>
								<td width="150" align="left">Produktionskosten</td>
								<td width="350" align="left">Specials</td>
							</tr>
							<tr><td colspan="4" height="8"></td>
								<?
								$result = mysql_query("select name,op,dp,credits,minerals,energy,specials,sciencepoints from military_unit_settings where race='pbf' order by unit_id");
								while($return = mysql_fetch_assoc($result)) {
									if ($return[sciencepoints]) {
										$spstring = ", ".$return[sciencepoints]." P";
									}
									if ($return[credits] > 0) {
										$crstring = $return[credits]." Cr,";
									}
									echo("
											<tr><td colspan=\"4\" height=\"8\"></td>
											<tr>
												<td width=\"100\" align=\"left\">$return[name]</td>
												<td width=\"100\" align=\"left\">$return[op] AP / $return[dp] VP</td>
												<td width=\"150\" align=\"left\">$crstring $return[minerals] t, $return[energy] MWh$spstring </td>
												<td width=\"350\" align=\"left\">$return[specials]</td>
											</tr>
									");
									unset($spstring,$crstring);
								} // while
								?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td><br></td></tr>
	<tr>
		<td>
			<table class=rand cellspacing=1 cellpadding=0 border=0 width=800>
				<tr>
					<td>
						<table class=head cellspacing=0 cellpadding=4 border=0 width=100%>
							<tr>
								<td align=center>
									<b><i>New Economic Block:</i></b><br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="800" cellspacing="0" cellpadding="4" border="0" class=body>
							<tr>
								<td width="100" align="left">Name</td>
								<td width="100" align="left">Kampfst�rke</td>
								<td width="150" align="left">Produktionskosten</td>
								<td width="350" align="left">Specials</td>
							</tr>
							<tr><td colspan="4" height="8"></td>
							<?
								$result = mysql_query("select name,op,dp,credits,minerals,energy,specials,sciencepoints from military_unit_settings where race='neb' order by unit_id");
								while($return = mysql_fetch_assoc($result)) {
									if ($return[sciencepoints]) {
										$spstring = ", ".$return[sciencepoints]." P";
									}
									if ($return[credits] > 0) {
										$crstring = $return[credits]." Cr,";
									}

									echo("
											<tr><td colspan=\"4\" height=\"8\"></td>
											<tr>
												<td width=\"100\" align=\"left\">$return[name]</td>
												<td width=\"100\" align=\"left\">$return[op] AP / $return[dp] VP</td>
												<td width=\"150\" align=\"left\">$crstring $return[minerals] t, $return[energy] MWh$spstring </td>
												<td width=\"350\" align=\"left\">$return[specials]</td>
											</tr>
									");
									unset($spstring,$crstring);
								} // while
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td><br></td></tr>
	<tr>
		<td>
			<table class=rand cellspacing=1 cellpadding=0 border=0 width=800>
				<tr>
					<td>
						<table class=head cellspacing=0 cellpadding=4 border=0 width=100%>
							<tr>
								<td align=center>
									<b><i>Nova Federation:</i></b><br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="800" cellspacing="0" cellpadding="4" border="0" class=body>
							<tr>
								<td width="100" align="left">Name</td>
								<td width="100" align="left">Kampfst�rke</td>
								<td width="150" align="left">Produktionskosten</td>
								<td width="350" align="left">Specials</td>
							</tr>
							<tr><td colspan="4" height="8"></td>
							<?
								$result = mysql_query("select name,op,dp,credits,minerals,energy,specials,sciencepoints,type from military_unit_settings where race='nof' order by unit_id");
								while($return = mysql_fetch_assoc($result)) {
									$estring = $return[energy]." MWh";
									if ($return[sciencepoints]) {
										$spstring = ", ".$return[sciencepoints]." P";
									}
									if ($return[credits] > 0) {
										$crstring = $return[credits]." Cr,";
									}
									if ($return[type] == "techs") {
										//$spstring.="*";
										//$estring.="*";
									}

									echo("
											<tr><td colspan=\"4\" height=\"8\"></td>
											<tr>
												<td width=\"100\" align=\"left\">$return[name]</td>
												<td width=\"100\" align=\"left\">$return[op] AP / $return[dp] VP</td>
												<td width=\"150\" align=\"left\">$crstring $return[minerals] t, $estring $spstring </td>
												<td width=\"350\" align=\"left\">$return[specials]</td>
											</tr>
									");
									unset($spstring,$crstring);
								} // while
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
</table>
<br><br>




<ul>* Recycelt: In einem erfolgreichen Angriff recycelt ein Sentinel eine gefallene Einheit f�r pauschal 2000 Cr, wobei dieser Betrag als Lagerguthaben ausbezahlt wird.<br></ul>
<!--<ul>* Produziert: Der Sentinel produziert 10 Cr je Stunde.<br><br></ul>-->
<!--<ul>* Variable St�rke: Die Angriffsst�rke richtet sich nach dem Verh�ltnis von gegnerischem Land zu eigenem Land bzw. eigenem Land zu gegnerischem Land. Es steht hierbei immer die kleinere Landmenge im Nenner. Diese Zahl mit 100 multipliziert ergibt eine Prozentzahl. F�r je 10% von 100% abweichend, erh�lt der Sentinel entweder 1 AP dazu (man selbst steht im Nenner), bzw. weniger (man selbst steht im Z�hler). Die St�rke des Sentinel varriiert jedoch nie um mehr als 6 AP.
Die Verteidigungspunkte des Sentinel berechnen sich analog, jedoch k�nnen die Verteidigungspunkte nicht unter 17 fallen.
</ul>-->
<ul><font color=green>*</font>Kampfverluste k�nnen durch Boni nicht auf weniger als 10% der Standardkampfverluste gesenkt werden!

<?
