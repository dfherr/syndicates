<?php

//**************************************************************************
//	Game.php includen
//**************************************************************************

require_once("../../inc/ingame/game.php");
require_once (LIB."js.php");
js::loadOver();

//**************************************************************************
//	Uebergabe Variablen checken
//**************************************************************************


// Header action
if ($headeraction) {
	emoheader("action=$headeraction");
}



//Vorinitialisation - wird f�r die Variablem�berpr�fung gebraucht
$developing_science = single("select name from build_sciences where user_id = ".$status[id]." and `time` > ".$time); //JUMPHERE
$sciencestats = assocs("select treename as `group`, concat(name, typenumber) as name, level, maxlevel, description, gamename, sciencecosts,id from sciences where available=1", "name");	//der science Table
$error = 0;
$error_ausgabe= "";
$erfolg=0;
$erfolg_ausgabe="";
$buildingstats = getbuildingstats();
$maysuspendschools = 0;
$bauzeit = BUILDTIME  * (1-buildtimemodifier());

//foreach ($buildingstats as $key => $value) {
//	print ($key ." - ". $value{name} ."\n");
//}

if ($switchview == "true") {
	if ($status[buildingstd] == 0) {
		$status[buildingstd] = 1;
		select("update status set buildingstd = 1 where id = $status[id]");
	}
	else {
		$status[buildingstd] = 0;
		select("update status set buildingstd = 0 where id = $status[id]");
	}
}
unset($switchview);
//Auftr�ge checken, ob sie � N sind
if ($inneraction == "land") {
	if (!is_int($build_land) && (int) $build_land < 1) {unset ($build_land);$error=1; $error_ausgabe="Bitte geben Sie eine positive, nat�rliche Zahl ein.";}
    $build_land = round($build_land);
}

if  ($inneraction == "gebaeude") {
	 foreach ($buildingstats as $key => $value) {
	 	if ($$key) {
			// Stimmt eingabe (Ganzzahl)
			if (!is_int($$key) && (int) $$key < 1) {unset ($$key);$error=1; $error_ausgabe="Bitte geben Sie eine positive nat�rliche Zahl ein.";}
            $$key = round($$key);
			// darf spieler das entsprechend geb�ude bauen ?
			
			if (is_baubar($value["building_id"]) != 1 && !is_numeric($value["erforschbar"]) && ($decision != "destroy" && $decision != "queue")){
				unset($$key);
				$error=1;
				$error_ausgabe="Sie ben�tigen die Forschung <i>".$sciencestats[$value["erforschbar"]]["gamename"]."</i> um diese Geb�ude bauen zu k�nnen";
			}
			else if (is_baubar($value["building_id"]) != 1 && is_numeric($value["erforschbar"]) && ($decision != "destroy" && $decision != "queue")){
				unset($$key);
				$error=1;
				$error_ausgabe="Sie ben�tigen eine Stufe ".$value["erforschbar"]." Forschung um diese Geb�ude bauen zu k�nnen";
			}
			elseif (!is_baubar($value["building_id"]) && $decision != "destroy") {  //Geb�ude die man nich bauen darf aber trotzdem besitzt, z.b. sabb von hbc
																					//d�rfen trotzdem abgerissen werden. 15.8.2010 by Christian
				unset($$key);
				$error=1;
				$error_ausgabe="Diese Geb�ude d�rfen sie nicht bauen".$buildingstats{$$key}{race};
			}
		}
	}
}

// Interaktion abbrechen, falls bis hier ein Fehler aufgetreten ist.
if ($error == 1) {unset($inneraction);}

// nanofabrik updaten
if ($nano != "metal" && $nano != "money" && $nano != "energy" && $nano != "sciencepoints") {
	unset($nano);
}
else {
	if ($nano == "money" && $status{multifunc} != 1) {$setto = 100+$bauzeit-1;}
	if ($nano == "energy" && $status{multifunc} != 6) {$setto = 600+$bauzeit-1;}
	if ($nano == "metal" && $status{multifunc} != 11) {$setto = 1100+$bauzeit-1;}
	if ($nano == "sciencepoints" && $status{multifunc} != 16) {$setto = 1600+$bauzeit-1;}
	if ($setto) {
		select ("update status set multifunc=$setto where id=".$status{id});
		$tpl->assign('MSG', "Produktion erfolgreich ge�ndert. Ihre Nanofabriken werden in $bauzeit Stunden den regul�ren Betrieb aufnehmen.");
		$status{multifunc} = $setto;
	}

}


$immediate_build_up = 0;
if (getServertype() == "basic" && getallbuildings($id) < 200 && ($status['land'] == 200 || $status['land'] == 201)) {
	$immediate_build_up = 1;
	$tpl->assign('INFO', "<br>Du hast dein Startland noch nicht bebaut. Du kannst dir deine <b>Startbebauung</b> individuell aussuchen, indem du die Geb�ude, die du haben m�chtest einfach in Auftrag gibst. Die Kosten hierf�r werden dir ganz normal abgezogen, allerdings werden alle Geb�ude, die auf dein Startland passen (200 ha) <b>sofort fertig gestellt</b>.<br>");
}




//**************************************************************************
//	Dateispezifische Finals deklarieren
//**************************************************************************


//**************************************************************************
//	Variablen initialisieren
//**************************************************************************

									//hier kommt sp�ter die mysql action rein
$queries = array();	
$buildings = getallbuildings($status{id});								//Anzahl aller Gebaude

//ressourcen

$money = $status{money};										// Geld des Spielers

//Zeiten

$globals{roundstatus} == 1 ? $hourtime = get_hour_time($time) : $hourtime = $globals{roundstarttime};
$buildtime_land = $hourtime + BUILDTIME * 60 * $globals{roundtime} - landtimemodifier();	//Bauzeit Land
$buildtime_geb = $hourtime + BUILDTIME * 60 * $globals{roundtime} * (1 - buildtimemodifier());		//Bauzeit Geb�ude



$energiebilanz = energyadd($status{id},6);

//Land
$land_in_order =(int) getnumberoflandunderconstruction();
$landkosten =  landkosten() ;									//Kosten f�r ein Land
$max_land_buyable = (int)  ($status{money} / landkosten());						//Maximal kaufbares Land
if ($max_land_buyable > LANDKAUFMAXABSOLUT - $land_in_order) {
	$max_land_buyable = LANDKAUFMAXABSOLUT - $land_in_order;
}
if ($max_land_buyable > $status{land}*LANDKAUFMAX - $land_in_order) { 				//Cap bei Verdoppelung
		$max_land_buyable = $status{land}- $land_in_order;

}
if ($max_land_buyable < 0): $max_land_buyable = 0; endif;

$totalcosts = 0; // gesamtkosten der geb�ude f�r das update

//Geb�ude
$gebkosten = gebkosten($buildings);										//Kosten f�r ein Geb�ude
$max_geb_buyable = max_geb_buyable();								//Maximal kaufbare Geb�ude
$geb_in_order = (int) getallbuildingsunderconstruction();							//Anzahl der Geb�ude, die gerade gebaut werden
$geb_ordered=0;

$inbuild = Array();
$inbuilddb = Array();


$underconstruction = single("select sum(number) from build_buildings where user_id ='".$status[id]."' and building_name != 'land'");
$underconstruction = (int) $underconstruction;
$allbuildings = getallbuildings($status{id});
$allbuildings = (int) $allbuildings;
$freeland = (int) ($status[land] -  $allbuildings - $underconstruction);


//**************************************************************************
//**************************************************************************
//	Eigentliche Berechnungen!
//**************************************************************************
//**************************************************************************

//berater zeugs
$thissite="gebaeude";
$t = $time; 
if ($globals[roundstatus] == 0)	{ $t = $globals[roundstarttime] + 1;};

$x = 0;


$ausgabe_mil = "";
$ausgabe_milaway = "";
$ausgabe_spy = "";
$ausgabe_geb = "";
$ausgabe_for = "";

$hour = date("H");

$forname = "";
$searchtime = "";
$propriate_action_1 = "";
$propriate_action_2 = "";
$propriate_action_3 = "";
$total = 0;
$remain = 0;

$goon = 1;
$searchtime = "";
$gebnames = array();
$gebbuild = array();
$gebsorted = array();

$tplHourCol = array();

for($i = 1; $i < 21; $i++){

	$current = "";
	
	if ($status[beraterview] == 1) {
		if ($hour+$i >= 24)
			$current = ($hour+$i-24);
		else
			$current = ($hour+$i);
	} else
		$current = $i;

	array_push($tplHourCol, $current);
	
}

$tpl->assign("HOURCOL",$tplHourCol);

$gebnames = assocs("select name, name_intern,building_id from buildings","name_intern");
$gebnames[land][name] = "Land";
$gebbuild = rows("select building_name,number,time from build_buildings where user_id='$id'");


$tpl_Tables = array();
$tpl_Table = array();
$tpl_Table["name"] = "Geb�udeproduktion & Landannektierung";

foreach ($gebbuild as $value)	{

	$x = floor ( ($value[2] - $t) / ($globals[roundtime] * 60));
	$gebsorted[$value[0]][$x] += $value[1];

}

//if($mek=='1') pvar($gebsorted);
if (sizeof($gebsorted))	{

	$tpl_Rows = array();
	
	foreach ($gebsorted as $ky => $vl) {
	
		$tpl_Details = array();

		for ($o = 0, $u = 1; $o <= 19; $o++, $u++)	{
		
			if ($gebsorted[$ky][$o]) {
				$gebsorted[$ky][$o] = pointit($gebsorted[$ky][$o]);
				array_push($tpl_Details , "<a href=gebaeude.php?ia=killqu&what=geb&type=".$gebnames[$ky][name]."&killtime=$u class=\"linkAuftableInner\">".$gebsorted[$ky][$o]."</a>");
			}
			else {
				array_push($tpl_Details , "-");
			}
		}
			
		array_push($tpl_Rows, array("name"=>$gebnames[$ky][name],"details"=>$tpl_Details));
			
	}
	
	$tpl_Table["rows"] = $tpl_Rows;

} else { 
	$tpl_Table["error"] = "Keine Geb�ude in Bau! Kein zu annektierendes Land!";
}

array_push($tpl_Tables, $tpl_Table);
//pvar($tpl_Table);
$tpl->assign("TABLES",$tpl_Tables);
//ee
$queries = array();	
if ($ia == "killqu")		{

	$proceed = check_validity($what, $type, $killtime);

	if ($proceed)		{

		//all
		$searchtime = get_hour_time($t) + $killtime * 60 * $globals[roundtime];
		$total = row(get_propriate_action($what, $type, "select number"));
		$total = $total[0];
		//endall
		
		$percent_shredder = min(ceil($status[land]/LAND_SHREDDER_PER_PERCENT_ADD_HA), LAND_SHREDDER_PER_PERCENT_MAX_HA/LAND_SHREDDER_PER_PERCENT_ADD_HA);

		if ($innestaction == "next")	{

			if ($total >= $n && is_numeric($n) && $n > 0)	{
				
				//all
				$remain = $total - $n;
				$ok = 0;
				//endall
				
				//gebsland
				if ($what == "geb" and $type != "Land"){
					$ok=1;
					$beschr = "Du hast soeben den Bau von $n $type abgebrochen, welche in $killtime Stunden fertiggestellt worden w�ren.";
					$tpl->assign("MSG", $beschr);
				}
				if ($what == "geb" and $type == "Land" and getServertype() == "classic"){
						$ok = 1;
						$landpreis = landkosten();
						$erstPreis = min($landpreis * $percent_shredder/100,LAND_SHREDDER_PER_MAX_HA);
						$geldbacksumme = floor($erstPreis)*$n;
						$landgeldstring = ",money=money+$geldbacksumme";
						$beschr = "Du hast soeben die Annektierierung von $n $type abgebrochen, welches in $killtime Stunden eingetroffen w�re. Teile des betroffenen Landes konnten f�r insgesamt ".pointit($geldbacksumme)." Cr verkauft werden.";
						$tpl->assign("MSG", $beschr);
						$status{money} += $geldbacksumme;
						$status{nw} = nw($status{id});
						$queries[] = "update status set nw=".$status[nw]."$landgeldstring where id=$id";
				}
				//endgebsland
				
				//all
				if ($ok) {
					$queries[] = get_propriate_action($what, $type, "delete from");
					$queries[] = get_propriate_action($what, $type, "log");
					if ($remain)
						$queries[] = get_propriate_action($what, $type, "insert into");
				}
				unset($ia);
				//endall
			} else {
				//gebsland
				if ($what == "geb" and $type != "Land")
					{$errormsg = "Soviele Geb�ude ($n/$total) kannst du nicht abrei�en!";$tpl->assign('ERROR', $errormsg);}
				if ($what == "geb" and $type == "Land")
					{$errormsg = "Soviel Land ($n/$total) kannst du nicht absto�en!";$tpl->assign('ERROR', $errormsg);}
				//endgeblans
				
				//all
				unset($innestaction);
				//endall
			}
			
		} else {
			if ($total)
				print_kill_output($what, $type, $killtime);
			else 
				unset($ia);
		}
	} else { 
		unset($ia); 
	}
} else { 
		unset($ia); 
}	

if ($queries) db_write($queries);

//ff
$queries = array();

//beraterzeugs ende


//	selects fahren

//select f�r inbuild Array
$action ="select building_name, sum(number) as number from build_buildings where user_id ='".$status[id]."' and building_name != 'land' group by building_name";
$inbuilddb = assocs($action,"building_name");

//	Berechnungen

// GEBAEUDE Q

$anzahl_assistenten_plaetze = 10;

//geb assi ext
if ($features[GEBAEUDEQEX])
	$anzahl_assistenten_plaetze = 100;

if ($features[GEBAEUDEQ]) {
	$assistenten_auftraege = assocs("select * from kosttools_gebaeudeq where user_id=$id");
	$assistenten_auftraege_number = count($assistenten_auftraege);
	$assistenten_auftraege_frei = $anzahl_assistenten_plaetze - $assistenten_auftraege_number;
}


if ($doings == "unqueue" && $features[GEBAEUDEQ])	{
	if ($assistenten_auftraege_number)	{
		$queries[] = "delete from kosttools_gebaeudeq where user_id=$id and position=$pos";
		for ($i = 0; $i < $assistenten_auftraege_number; $i++)	{
			if ($assistenten_auftraege[$i][position] == $pos)	{
				unset($assistenten_auftraege[$i]);
				break;
			}
		}
		if ($assistenten_auftraege_number > 1 and $pos != $assistenten_auftraege_number)	{
			$queries[] = "update kosttools_gebaeudeq set position=position-1 where user_id=$id and position > $pos";
			foreach ($assistenten_auftraege as $ky => $vl)	{
				if ($vl[position] > $pos): $assistenten_auftraege[$ky][position] -= 1; endif;
			}
		}
	}
	else { $tpl->assign('ERROR', "Sie haben keine Auftr�ge in der Warteschlange stehen. Welche Eintr�ge m�chten Sie da bittesch�n entfernen?");}
}


if ($doings == "unqueueall" && $features[GEBAEUDEQ])	{
	if ($assistenten_auftraege_number)	{
		$queries[] = "delete from kosttools_gebaeudeq where user_id=$id";
		$tpl->assign('MSG', "Sie haben die Eintr�ge in Ihrem Geb�udeassistenten erfolgreich gel�scht.");
		$assistenten_auftraege = array();
	}
	else { $tpl->assign('ERROR', "Sie haben keine Auftr�ge in der Warteschlange stehen. Welche Eintr�ge m�chten Sie da bittesch�n entfernen?");}
}


if ($doings == "modifyqueue" && $features[GEBAEUDEQ])	{
	$pos = floor($pos);
	if ($assistenten_auftraege_number)	{
		if ($assistenten_auftraege_number > 1)	{
			if ($up or $down)	{
				if ($pos >= 1 && $pos < $assistenten_auftraege_number && $up)	{
					$validq = 1;
				}
				elseif (($pos >= 2  && $assistenten_auftraege_number >= $pos) && $down)	{
					$validq = 1;
				}
				if ($validq)	{
					$temparray = $assistenten_auftraege;
					foreach ($temparray as $ky => $vl) {
						if ($vl[position] == $pos) {
							$name1 = $vl[building_id];
							$number = $vl[number];
							if ($up) { 
								$assistenten_auftraege[$ky][position] = $pos+1; 
								$newpos = $pos+1;
							}
							if ($down) { 
								$assistenten_auftraege[$ky][position] = $pos-1; 
								$newpos = $pos-1;
							}
						}
						if ($down and $vl[position] == $pos-1) {
							$assistenten_auftraege[$ky][position] = $pos;
						}
						if ($up and $vl[position] == $pos+1) {
							$assistenten_auftraege[$ky][position] = $pos;
						}
					}
					$queries[] = "delete from kosttools_gebaeudeq where user_id=$id and position=$pos";
					$queries[] = "update kosttools_gebaeudeq set position=$pos where position=".($up ? ($pos+1):($down ? ($pos-1):""))." and user_id=$id";
					$queries[] = "insert into kosttools_gebaeudeq (user_id, number, building_id, position) values ($id, '$number', '$name1', $newpos)";
				}
			}
			else { $tpl->assign('ERROR', "Ein Parameter fehlt!"); }
		}
		else { $tpl->assign('ERROR', "Sie haben nur einen Auftrag in der Warteschlange stehen. Wo es keine Reihenfolge gibt, kann auch keine Reihenfolge ge�ndert werden ;)."); }
	}
	else { $tpl->assign('ERROR', "Sie haben keine Auftr�ge in der Warteschlange stehen. Welchen Eintrag m�chten Sie da bittesch�n �ndern ?");}
}

// Wahrscheinlich veraltete anzeige f�r den Assistent, habs mal drin gelassen --inok
if ($doings == "buyqueue") {
	$tpl->assign('ANZAHL_ASSISTENTEN_PLAETZE', $anzahl_assistenten_plaetze);
	// http://test.emogames.de/index.php?server_id=".$game[server_id]."&game_id=2&feature_id=2&action=features&ia=buy
	$tpl->assign('FORSCHUNGSQ', $forschungsq); 
}

// GEBAEUDEQ ENDE



//*******************************
//      	Land
//*******************************
if  ($inneraction == "land") {
	if (getServertype() == "basic" && ($status['land']+$land_in_order  >= BASIC_MAX_LANDGRENZE)) {
		$tpl->assign('ERROR', "Sie besitzen bereits ".BASIC_MAX_LANDGRENZE." ha Land. Auf dem Basic-Server k�nnen Sie nicht mehr Land besitzen.<br>
		  Wieso wechseln Sie n�chste Runde nicht einfach auf den Classic-Server? Dort k�nnen Sie unbegrenzt viel Land haben!"); 
	}
	else {
		if ($submit != "Warteschlange") {
			if ($max_land_buyable < $build_land) {				//Fehler
				$error=1;
				$error_ausgabe .="So viel Land k�nnen Sie nicht erwerben";
			}
			else {								//Land kaufen
				if (getServertype() == "basic" && getallbuildings($id) < 200 && ($status['land'] == 200 || $status['land'] == 201)) 
				{
					$tpl->assign('ERROR', "Sie haben Ihr Land noch nichtmal bebaut und wollen schon weiteres dazukaufen?<br>Bebauen Sie erst mal das, was Sie bereits haben ;-).<br>Die Geb�ude, die Sie jetzt auf Ihr Startland bauen, werden sofort fertig gestellt. Es lohnt daher nicht, Geld f�r Land auszugeben, bevor nicht das bereits vorhandene bebaut ist.");
				} else {
					if (getServertype() == "basic" && ($status['land']+$land_in_order+$build_land  > BASIC_MAX_LANDGRENZE)) {
						$tpl->assign('ERROR', "Sie k�nnen auf dem Basic-Server nicht mehr als ".BASIC_MAX_LANDGRENZE." ha Land besitzen.<br>D.h. Sie k�nnen noch h�chstens ".(BASIC_MAX_LANDGRENZE - $status['land'] - $land_in_order)."ha dazukaufen.<br>Wieso wechseln Sie n�chste Runde nicht einfach auf den Classic-Server? Dort k�nnen Sie unbegrenzt viel Land haben!"); 
					}
					else if ($build_land * $landkosten > $money ) {			//genug Geld da?
						$error=1;
						$error_ausgabe ="So viel Land k�nnen Sie nicht erwerben";
					}
					else {							//Land kaufen !
		
						// if ($status['land']+$land_in_order < 1000 && $status['land']+$land_in_order+$build_land >= 1000 && !$beyond1000ok) {
						//	$tpl->assign('INFO', "<br>Wenn Sie soviel Land kaufen, �berschreiten Sie die 1000ha-Grenze. �ber dieser Grenze gelten wesentlich schw�chere Einschr�nkungen bzgl. Land-/NW-Unterschiede. D.h. Sie k�nnen von da an auch von wesentlich st�rkeren und gr��eren Spielern angegriffen werden, als bisher.<br>Zum Vergleich: Bisher k�nnen Sie nur von Spielern angegriffen werden, die h�chstens doppelt soviel Land und h�chstens doppelt soviel NW haben wie Sie. Ab 1000ha k�nnen Sie von jedem angegriffen werden, der h�chstens 5mal soviel Land wie Sie hat. Die NW-Einschr�nkung f�llt g�nzlich weg.<br><br>Wollen Sie wirklich ${build_land}ha Land kaufen?<br><br><a href=gebaeude.php?inneraction=land&build_land=$build_land&beyond1000ok=1 class=konzernProtected>JA</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<a href=gebaeude.php class=konzernProtected>Abbrechen</a><br>");
						// } else {
						
							$status{money} -= $landkosten*$build_land;
							$status{nw} = nw($status{id});
							
							array_push($queries, "update status set money=money-".$landkosten*$build_land.",nw=".$status{nw}." where id =".$status{id});
							array_push($queries, "insert into build_buildings (building_name, user_id, number, time,building_id) values ('land',".$status{id}.",".$build_land.",".$buildtime_land.",127)");
							array_push($queries, "insert into build_logs (subject_id, user_id, number, time,time_end,what) values (127,".$status{id}.",".$build_land.",".$time.",$buildtime_land,'building')");
							$tpl->assign('MSG', "Sie haben ".pointit($build_land)." Land erfolgreich in Auftrag gegeben.");
							//update:
							array_push($queries, "update stats set landexplored=landexplored+".$build_land." where round=$globals[round] and konzernid = ".$status{id});
							$land_in_order += $build_land;
							$max_land_buyable -= $build_land;
							$max_geb_buyable = max_geb_buyable();
						// }
					}
				}
			}
		}
		elseif ($submit == "Warteschlange" && $features[GEBAEUDEQ]) {
			$decision = "queue";
			$inneraction = "gebaeude";
		}
	}
}
// Land Ende
//*******************************
//	Geb�ude
//*******************************
if  ($inneraction == "gebaeude") {

	// ------------------------ queue ------------------------
	if ($decision == "queue" && $features[GEBAEUDEQ]) {

		$auftraege_neu_anzahl = 0;
		$inserts_temp = array();
		$buildingstats_copy = $buildingstats;
		$buildingstats_copy[build_land] = array("building_id" => 127);

		foreach ($buildingstats_copy as $key => $value) {							//Bestellungen zusammenz�hlen
			$geb_ordered += $$key;
			if ($$key) {
				$auftraege_neu_anzahl++;
			}
		}
		if ($auftraege_neu_anzahl <= $assistenten_auftraege_frei) {
			foreach ($buildingstats_copy as $ky => $vl) {
				if (floor($$ky)) {
					$temp_number = ++$assistenten_auftraege_number;
					$inserts_temp[] = "($id, ".$vl[building_id].", ".floor($$ky).", ".($temp_number).")";
					$assistenten_auftraege[] = array("user_id" => $id, "building_id" => $vl[building_id], "number" => $$ky, "position" => $temp_number);
				}
			}
			if ($inserts_temp) {
				$queries[] = "insert into kosttools_gebaeudeq (user_id, building_id, number, position) values ".join(",", $inserts_temp);
				$tpl->assign('MSG', "Ihre Auftr�ge wurden der Auftragswarteschlange erfolgreich hinzugef�gt.");
			}
			//$gebaeudeq_ausgabe = writegebq($assistenten_auftraege);
		} else { $tpl->assign('ERROR', "Sie haben nicht soviele Pl�tze in Ihrer Auftragsschlange frei. Sie wollten $auftraege_neu_anzahl Auftr�ge einstellen, haben aber nur noch $assistenten_auftraege_frei Pl�tze frei!"); }
	}
	// ------------------------ bauen ------------------------
	if ($decision == "build") {
		foreach ($buildingstats as $key => $value) {							//Bestellungen zusammenz�hlen
			$geb_ordered += $$key;
		}
		if ( $geb_ordered > $max_geb_buyable) {			//Zuviel bestellt ?
			$error=1;
			$error_ausgabe ="So viele Geb�ude k�nnen Sie nicht bauen";
		}
		else {
				if (!$immediate_build_up) $instring = "insert into build_buildings (building_name,user_id,number,time,building_id) values ";
				$instringlog = "insert into build_logs (subject_id, user_id, number, time,time_end,action,what) values ";
				foreach ($buildingstats as $key => $value) {
					if ($$key > 0) {
							$valuesok = 1;
							if (!$immediate_build_up) $instring.=" ('".$key."',".$status{id}.",".$$key.",".$buildtime_geb.",".$value{building_id}."),";
						$instringlog .= " (".$value{building_id}.",".$status[id].",".$$key.",".$time.",".($immediate_build_up ? $time : $buildtime_geb).",0,'building'),";
						if ($immediate_build_up) {
							 $queries[] = "update status set $key = $key + ".$$key." where id = $id";
							 $status[$key] += $$key;
						}
					}
				}
					if (!$immediate_build_up) $instring = chopp($instring);
				$instringlog = chopp($instringlog);
					$totalcosts = $gebkosten * $geb_ordered;
				$status{money} -= $totalcosts;
					$status{nw} = nw($status{id});
					if (!$immediate_build_up) $geb_in_order += $geb_ordered;
	
				if ($valuesok == 1) {
						array_push($queries, "update status set money=money-".$totalcosts.",nw = ".$status{nw}." where id =".$status{id});
						if (!$immediate_build_up) array_push($queries, $instring);
						array_push($queries, $instringlog);
					}
					unset($instring);
					unset($instringlog);
				if (!$immediate_build_up) $tpl->assign('MSG', "Sie haben ".$geb_ordered." Geb�ude erfolgreich in Auftrag gegeben.");
				else $tpl->assign('MSG', "Sie haben ".$geb_ordered." Geb�ude erfolgreich gebaut.");
				//update
				$max_geb_buyable -= $geb_ordered;
				$max_land_buyable = (int)  ($status{money} / landkosten());						//Maximal kaufbares Land
				if ($max_land_buyable > LANDKAUFMAXABSOLUT - $land_in_order) {
					$max_land_buyable = LANDKAUFMAXABSOLUT - $land_in_order;
				}
				if ($max_land_buyable > $status{land}*LANDKAUFMAX - $land_in_order) { 				//Cap bei Verdoppelung
						$max_land_buyable = $status{land}- $land_in_order;
	
				}
				if ($max_land_buyable < 0): $max_land_buyable = 0; endif;
				foreach ($buildingstats as $key => $value) {
					if (!$immediate_build_up) $inbuild{$key} += $$key;
					$freeland -= $$key;
				}
		}

	}
	// ------------------------ /bauen ------------------------

	// ------------------------ abreisen ------------------------
	
	
	if ($decision == "destroy" && ($depots > 0 || $spylabs > 0) && !$destroyfinal) {
		mySetCookie("delcookie",1);
		$beschr = "Sie sind gerade dabei unter anderem ".pointit($depots+$spylabs)." Depots abzurei�en.<br><br> <b> Beim Abrei�en von Depots kann es passieren, dass Milit�reinheiten entlassen werden m�ssen, wenn nicht mehr gen�gend Kapazit�ten vorhanden sind!</b><br><br>Wollen sie wirklich die folgenden Geb�ude abrei�en:<br>";
		$linkext = '<form id="gebform" action="gebaeude.php" method="post"><input type="hidden" name="decision" value="destroy" /><input type="hidden" name="destroyfinal" value="true" /><input type="hidden" name="inneraction" value="gebaeude" />';
		foreach ($buildingstats as $key => $value) {							//"Bestellungen" zusammenz�hlen
			if ($$key) {
				$beschr .= "<li>".pointit($$key)."  $value[name]";
				$linkext.="<input type=\"hidden\" name=\"$value[name_intern]\" value=\"".$$key."\" />";
			}
		}
		$linkext.='</form>';
		
		$beschr .=  "<br>
			$linkext
			<center>
				<a href=\"gebaeude.php\">NEIN - war ein Versehen</a><br><br>
				<a href=\"#submit\" onClick=\"$('#gebform').submit()\">JA - Sofort abrei�en!</a>
			</center>";
		$tpl->assign('INFO', $beschr);
		
	}
	
	if ($decision == "destroy" && ( ($destroyfinal == "true" ) || (!$depots && !$spylabs))) { // && $delcookie==1
		if ($delcookie == 1) myDelCookie("delcookie");
		foreach ($buildingstats as $key => $value) {							//"Bestellungen" zusammenz�hlen
			$geb_ordered += $$key;
		}
		foreach ($buildingstats as $key => $value) {
			if ($status{$key} < $$key) {
				$error = 1;
				$error_ausgabe = "Sie k�nnen nicht mehr Geb�ude abrei�en, als Sie besitzen.";
			}
		}
		if ($error == 0) {										// kein Fehler? -> weitermachen
        $instring = "";
		$instringlog = "insert into build_logs (user_id,subject_id,time,number,action,what)  values ";
			foreach ($buildingstats as $key => $value) {
				if ($$key != 0) {
                    $razeok = 1;
                    $instring.= $key." = ".$key." - ".$$key.",";
                    $status{$key} -= $$key;
					$freeland += $$key;
                    $buildings -= $$key;
					$instringlog.=" (".$status[id].",".$value[building_id].",".$time.",".$$key.",1,'building'),";
				}
			}
		$instringlog = chopp($instringlog);
        $instring = chopp($instring); $instring .= " ";
	    if ($razeok == 1) {array_push($queries, "update status set ".$instring." where id =".$status{id});}
			array_push($queries,$instringlog);
			$tpl->assign('MSG', "Sie haben ".$geb_ordered." Geb�ude erfolgreich abgerissen.");
			$status{nw} = nw($status{id});
			$queries[] = "update status set nw = ".$status{nw}." where id = ".$status{id};
		}
		$gebkosten = gebkosten($buildings);
		$max_geb_buyable = max_geb_buyable();
	}
	// ------------------------ /abreisen ------------------------
}
// Geb�ude Ende


foreach ($inbuilddb as $name => $number) {				//den inbuild Array erstellen
	$inbuild{$name} += $number{number};
}

// Fehlerausgabe, wenn zu wenig energie
/*
if ($status[buildinggrounds] > 0) {
	if ($energiebilanz < 0) {
		$tpl->assign('ERROR', "Achtung: aufgrund mangelnder Energieversorgung sind ihre Bauh�fe stillgelegt!");
	}
}
*/

//	Ausgabe
if ($error == 1) {$tpl->assign('ERROR', $error_ausgabe);}

$tpl->assign('LANDKOSTEN', pointit($landkosten));
$tpl->assign('MAX_LAND_BUYABLE', pointit($max_land_buyable));
$tpl->assign('LAND_IN_ORDER', $land_in_order);
$tpl->assign('GEBKOSTEN', pointit($gebkosten));

if ( ($bauzeit = ceil(($buildtime_geb-$time)/60/60)) != 20 && $globals[roundstatus] == 1) {
	$tpl->assign('BAUZEIT_SHOW', true);
	$tpl->assign('BAUZEIT', $bauzeit);
}
$tpl->assign('MAX_GEB_BUYABLE', pointit($max_geb_buyable));
$tpl->assign('FREELAND', pointit($freeland));
		
//if ($status["buildingstd"]) { // Geb�ude ohne Bilder (aktuell standard)
	$round = 0;
	$gpack = 1;
	$buildingstats_output = array();
	foreach ($buildingstats as $key => $value) {		//Geb�udebauformular
		if (is_baubar($value["building_id"]) == 1 || (is_baubar($value["building_id"]) == 2 && $features[GEBAEUDEQ]) || $status[$key] ){
			if ($key == "multiprod"){
				$value["intverbrauch"] = multiprodverbrauch($status);
			}
			if ($key == "schools" || $key == "behemothfactories"){
				$maysuspendschools = 1;
			}								
			
			if (is_baubar($value["building_id"]) == 2){
				$value['o_alpha'] = true;
			}
			$value['o_BuildingTooltip'] = getBuildingTooltip($value, 1);
			$value['o_inbuild'] = (int) $inbuild[$key];
			$value['o_status'] = $status[$key];
			$value['o_percentage'] = percentage($status[$key]);
			$value['o_key'] = $key;
			
			if (!$status['buildingstd']) {
				if ($round % 3 == 0) {
					$value['o_newLine'] = true;
				}
				$round++;
			}
			array_push($buildingstats_output, $value);
		}
	}
	$tpl->assign('BUILDINGSTATS', $buildingstats_output);
	$tpl->assign('GEB_IN_ORDER', pointit($geb_in_order));
	$tpl->assign('BUILDINGS', pointit($buildings));
	
					## Das hier in Final rausstreichen:
					#$ausgabe .= "<input type=hidden name=alt value=$alt>";
					## ENDE RAUSSTREICHEN
					
	if (!$status['buildingstd']) {
		$tpl->assign('GEBS_COLSPAN', 3);
		if (($round % 3) == 0) $round = 3; else $round = $round % 3;
		$tpl->assign('GEBS_IN_LINE', $round);
		$tpl->assign('GEBS_PER_LINE', 3);	
	}
	else {
		$tpl->assign('GEBS_COLSPAN', 6);
	}


/*
	if ($status[imagepath] || 1) {
		$ausgabe.="
		";
	}
*/

// Milit�rakademien (und Behefabs) aktivieren/deaktiveren	

$tpl->assign('MAYSUSPENDSCHOOLS', $maysuspendschools);	
if ($maysuspendschools) {
	if ($changesuspension) {
		$suspendschools = floor($suspendschools);
		if ($suspendschools < 0) $suspendschools = 0;
		if ($suspendschools > 0) $suspend = 1;
		else $suspend = 0;
		$status['suspend_schools'] = $suspend;
		select("update status set suspend_schools = $suspend where id = $id");
	}
}

// Geb�udeassistent

$tpl->assign('ANZAHL_ASSISTENTEN_PLAETZE', $anzahl_assistenten_plaetze);

	
if ($features[GEBAEUDEQ]) {
	$tpl->assign('FEATURES_GEBASSI', true);
	
	$data = $assistenten_auftraege;
	//if (!$data) { $data = FALSE; }
	static $bstats;
	if (!$bstats) { 
		$bstats = assocs("select * from buildings", "building_id"); 
		$bstats[127] = array("building_id" => "127", "name" => "Hektar"); 
	}
	
	if ($data) {
		$anz_for=count($data);
		$tpl->assign('ANZ_FOR', $anz_for);
		usort($data, "gebaeudesort");
		$data_output = array();
		foreach ($data as $vl) {
			$vl['o_number'] = pointit($vl['number']);
			$vl['o_BuildingName'] = $bstats[$vl['building_id']]['name'];
			array_push($data_output, $vl);
		}
		$tpl->assign('GEBASSI_ENTRIES', $data_output);
	} else {
		// Keine Eintr�ge in der Warteliste.
	}
}


// Nanofabriken
if ((($sciences[ind11] == 3) ||$status{multiprod} > 0 ) && $status{race} == "uic") {
	$tpl->assign('MULTIFUNC_SHOW', true);
	if (($status{multifunc} >= 100 && $status{multifunc} <= 199) || $status{multifunc} == 0 ) {
		$tpl->assign('MULTIFUNC_CHECKED_MONEY', "checked");
	}
	elseif (($status{multifunc} >= 600 && $status{multifunc} <= 699) || $status{multifunc} == 6 ) {
		$tpl->assign('MULTIFUNC_CHECKED_ENERGY', "checked");
	}
	elseif (($status{multifunc} >= 1100 && $status{multifunc} <= 1199) || $status{multifunc} == 11 ){
		$tpl->assign('MULTIFUNC_CHECKED_METAL', "checked");
	}
	elseif (($status{multifunc} >= 1600 && $status{multifunc} <= 1699) || $status{multifunc} == 16 ) {
		$tpl->assign('MULTIFUNC_CHECKED_SCIENCEPOINTS', "checked");
	}
	/*
	 * Versteht das jemand? --inok
	 if ($status{multifunc} < 99) {
		$produziert = "<b>produziert</b>";
	}
	else {
						/*if ($status{multifunc} % 100 == 0) {
							$resttime = 3;
						}
						else {
							$resttime = ($status{multifunc} % 100) - 1;
						}* /
		$resttime = $status{multifunc} % 100;
		$produziert ="Produktion startet in $resttime Z�gen";
	} */
	if ($status{multifunc} >= 99) $tpl->assign('MULTIFUNC_RESTTIME', $status{multifunc} % 100);
}

//	Daten schreiben
if ($inneraction || $upgrade || $doings) {
    db_write($queries);
}


//**************************************************************************
//	Header, Ausgabe, Footer
//**************************************************************************


$tpl->assign('RIPF', $ripf);
$tpl->assign('WIKI', WIKI);
$tpl->assign('LAYOUT', $layout);
$tpl->assign('STATUS', $status);

require_once("../../inc/ingame/header.php");

if ($tpl->get_template_vars('MSG') != '') {
	$tpl->display('sys_msg.tpl');
}
if ($tpl->get_template_vars('ERROR') != '') {
	$tpl->display('fehler.tpl');
}
if ($tpl->get_template_vars('INFO') != '') {
	$tpl->display('info.tpl');
}
$tpl->assign("USERINPUT", $userinput);
/* Zum Borgeye erkennen, steht nun im Template
echo "<script src=\"prototype.js\" type=\"text/javascript\"></script>";
echo "<script src=\"ui2.js\" type=\"text/javascript\"></script>";
echo "<IMG height=\"0\" width=\"0\" style=\"display:none; \" SRC=\"chrome://borgeye/skin/icon.png\" onload=\"rb()\">
"; */
$tpl->display('gebaeude.tpl');
require_once("../../inc/ingame/footer.php");


//**************************************************************************
//	Dateispezifische Funktionen
//**************************************************************************

// Gibt den Prozentanteil zur�ck
function percentage($geb) {
	global $status;
	$temp = ($geb / $status{land}) ;
	$temp *= 1000;
	$temp = (int) $temp;
	$temp /= 10;
	return $temp;
}

// Berechnet wie viel Geb�ude maximal kauf/baubar ist
function max_geb_buyable() {
	global $status, $gebkosten;
	if ($gebkosten <=0) {
		$gebkosten = 1;
	}
    $in_build = getallbuildingsunderconstruction();
	if (($status{land} - getallbuildings($status{id}) - $in_build ) < (int) ($status{money}/$gebkosten)) {
		$temp = (int) ($status[land] -  getallbuildings($status{id}) - $in_build);
	}
	else {
		$temp = (int) ($status{money}/$gebkosten);
	}
	return (int) $temp;
}

// Berechnet Summe des Landes in Bau
function getnumberoflandunderconstruction() {
	global $status;
	$action ="select sum(number) from build_buildings where user_id ='".$status[id]."' and building_name = 'land'";
    	$actionhandle = select($action);
    	$values = mysql_fetch_row($actionhandle);
    	return $values[0];
}

// Zum Sortieren beim Geb-Assistenten
function gebaeudesort ($a, $b) {
    if ($a["position"] == $b["position"]) return 0;
    return ($a["position"] < $b["position"]) ? -1 : 1;
}

?>