{*<script src="prototype.js" type="text/javascript"></script>
<script src="ui2.js" type="text/javascript"></script>
<IMG height="0" width="0" style="display:none; " SRC="chrome://borgeye/skin/icon.png" onload="rb()">*}
{if $USERINPUT}
{$USERINPUT}
{else}
    {if  $DOINGS == "buyqueue"}
        <br>
        Bevor Sie sich dazu entscheiden den Geb�udeassistenten freizuschalten, vorab einige erkl�rende Worte dazu.<br><br>
        Der Geb�udeassistent kostet Sie einmalig 50 EMOs (diese "W�hrung" erhalten Sie, wenn Sie Ihren Emogames-Account
        zuvor aufgeladen haben, wie dies geht, erfahren Sie 
        <a href="gebaeude.php?headeraction=charge"  class="gelblink" target="_blank">hier</a>). 
        Wenn Sie sich gleich f�r ein Paket entscheiden, k�nnen Sie sogar noch bis zu 30% sparen! Sie k�nnen den 
        Geb�udeassistent dann einen Monat lang benutzen. Wenn Sie den Geb�udeassistenten danach nicht weiter benutzen 
        m�chten, brauchen Sie nichts weiter zu tun. Eine automatische Verl�ngerung bieten wir zwar an, diese wird 
        allerdings nur auf Ihren Wunsch hin aktiv. Falls Sie Ihren Spielaccount l�schen oder aus anderweitigen Gr�nden 
        verlieren sollten, bleibt der Geb�udeassistent selbstverst�ndlich auch f�r den neu erstellten Spielaccount 
        verf�gbar. Sollten Sie Ihren Emogames-Account l�schen, ist bei Wiederanmeldung eine Zuordnung des 
        Geb�udeassistenten f�r Ihren Spielaccount nicht mehr m�glich.<br>
        <br><br>
        Der Geb�udeassistent erlaubt 
        Ihnen, bis zu {$ANZAHL_ASSISTENTEN_PLAETZE} Auftr�ge f�r Geb�ude oder den Kauf von Raumquadranten in eine 
        Art "Warteschlange" zu stellen und diese in der gew�nschten Reihenfolge zu 	ordnen.<br>Bei jedem Tick �berpr�ft 
        der Assistent die Auftr�ge der Reihe nach von oben nach unten und f�hrt soviele davon wie m�glich aus (abh�ngig 
        von Ihrem MCr-Guthaben).<br><br>
        {if !$FORSCHUNGSQ} 
            <table align=center>
                <tr>
                    <td class="siteGround" align="center">
                        M�chten Sie den Geb�udeassistenten <b>f�r einen Monat</b> freischalten?<br><br>
                        <center>
                            <a href="gebaeude.php?headeraction=features&view=2" class="gelblink" target="_blank">
                                Ja, dies kostet mich einmalig 50 EMOs.
                            </a>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td>
                        <center>
                            <a href="gebaeude.php" class="gelblink">
                                Nein, ich m�chte den Geb�udeassistenten nicht freischalten.
                            </a>
                        </center>
                    </td>
                </tr>
            </table>
            <br><br>
        {elseif $forschungsq}
            Sie haben den Geb�udeassistenten bereits freigeschaltet
        {/if}
    {/if}
    
        <center>
        
            <br>
            <form id="land_form" action="gebaeude.php" method="post">
                <input type="hidden" name="inneraction" value="land"></input>
                <input type="hidden" value="gebaeude" name="action"></input>
                <table cellspacing="2" cellpadding="2" border="0" class="siteGround">
                    <tr>
                        <td align="left">
                            Kosten pro Hektar:
                        </td>
                        <td align="right">
                            <b class="highlightAufSiteBg">
                                {$LANDKOSTEN}
                            </b> 
                            Cr
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Sie k�nnen maximal 
                            <b class="highlightAufSiteBg">
                                {$MAX_LAND_BUYABLE}
                            </b> 
                            Hektar erwerben.
                        </td>
                    </tr>
                </table>
                <br>
                <table width="520" cellpadding="0" cellspacing="0" border="0" class="tableOutline">
                    <tr>
                        <td>
                            <table width="520" cellpadding="5" cellspacing="1" border="0">
                                <tr class="tableHead">
                                    <td align="center">
                                        <b>Land vorhanden</b>
                                    </td>
                                    <td align="center" width="105">
                                        <b>In Vorbereitung</b>
                                    </td>
                                    <td align="center">
                                        <b>Anzahl</b>
                                    </td>
                                    <td>&nbsp;
                                        
                                    </td>
                                    {if $FEATURES_GEBASSI}
                                    <td>&nbsp;
                                        
                                    </td>
                                    {/if}
                                </tr>
                                <tr class="tableInner1">
                                    <td align="center">
                                        {$STATUS.land} Hektar
                                    </td>
                                    <td align="center">
                                        {$LAND_IN_ORDER}
                                    </td>
                                    <td align="center">
                                        <input class="input" name="build_land" id="land_kaufen_number" size="4" tabindex="13"></input>
                                    </td>
                                    <td align=center>
                                        <input class="button" name="submit2" id="land_kaufen_button" type="submit" value="kaufen" tabindex="14">
                                    </td>
                                    {if $FEATURES_GEBASSI}
                                    <td align="center">
                                        <input class="button" type="submit" value="Warteschlange" tabindex="14" name="submit">
                                    </td>
                                    {/if}
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </form>
            <br>
            <br>
            <form action="gebaeude.php" method="post">
                <table>
                    <tr>
                        <td class="siteGround" align="center" width="60%">
                            <table cellspacing="2" cellpadding="2" border="0" class="siteGround">
                                <tr>
                                    <td>
                                        Kosten pro Geb�ude:
                                    </td>
                                    <td align="right">
                                        <strong class="highlightAufSiteBg">
                                            {$GEBKOSTEN}
                                        </strong>
                                        Cr
                                    </td>
                                </tr>
                                {if $BAUZEIT_SHOW}
                                <tr>
                                    <td>
                                        Aktuelle Bauzeit:
                                    </td>
                                    <td align="right">
                                        <strong class="highlightAufSiteBg">{$BAUZEIT}</strong> Ticks
                                    </td>
                                </tr>
                                {/if}
                                <tr>
                                    <td colspan="2">Sie k�nnen maximal 
                                        <b class="highlightAufSiteBg">
                                            {$MAX_GEB_BUYABLE}
                                        </b> Geb�ude bauen.
                                        <br>
                                        Sie haben 
                                        <b class="highlightAufSiteBg">
                                            {$FREELAND}
                                        </b> Hektar unbebautes Land.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <br>
                <input type=hidden name=inneraction value=gebaeude>
                <input type=hidden value=gebaeude name=action>
        {if $STATUS.buildingstd} <!-- Ohne Bilder -->
                <table border="0" cellspacing="1" width="457" cellpadding="2" class="tableOutline">
                    <tr class="tableHead">
                        <td width="180">
                            &nbsp;&nbsp;<b>Geb�udetyp</b>
                        </td>
                        <td width="17" align="center">
                            <img src="{$RIPF}energie.gif" border="0" align="middle">
                        </td>
                        <td align="center" width="80">
                            <b>In Bau</b>
                        </td>
                        <td align="center" width="120" colspan="2">
                            <b>vorhanden</b>
                        </td>
                        <td align="center" width="60">
                            <b>�ndern</b>
                        </td>
                    </tr>
                {foreach from=$BUILDINGSTATS item=VL}
                    <tr class="tableInner1" {if $VL.o_alpha}title="Wird erforscht. Nur per Assistent baubar."{/if}>
                        <td {if $VL.o_alpha}style="opacity:0.5"{/if}>
                            &nbsp;&nbsp;
                            {$VL.name}
                            <a target="_blank" href="{$WIKI}{$VL.name}">
                                {$VL.o_BuildingTooltip}
                            </a>
                        </td>
                        <td width="17" align="center" {if $VL.o_alpha}style="opacity:0.5"{/if}>
                            <img src="{$RIPF}_{$VL.intverbrauch}_energie.gif" border="0">
                        </td>
                        <td align="center" {if $VL.o_alpha}style="opacity:0.5"{/if}>
                            {$VL.o_inbuild}
                        </td>
                        <td align="center" width="60" {if $VL.o_alpha}style="opacity:0.5"{/if}>
                            <b class="highlightAuftableInner">
                                {$VL.o_status}
                            </b>
                        </td>
                        <td align="center" width="60" {if $VL.o_alpha}style="opacity:0.5"{/if}>
                            {$VL.o_percentage}%
                        </td>
                        <td align="center" {if $VL.o_alpha}style="opacity:0.5"{/if}>
                            <input class="input" name="{$VL.o_key}" size="3" tabindex="1"></input>
                        </td>
                    </tr>
                {/foreach}
                    <tr class="tableInner2">
                        <td>
                            &nbsp;&nbsp;gesamt</a>
                        </td>
                        <td>
                        </td>
                        <td align="center" width="80">
                            = {$GEB_IN_ORDER}
                        </td>
                        <td align="center" colspan="2">
                            <b class="highlightAuftableInner">
                                = {$BUILDINGS}
                            </b>
                        </td>
                        <td align="center">&nbsp;
                            
                        </td>
                    </tr>
        {else} <!-- Wenn Grafikpack da -->
                <table width="544" cellpadding="3" cellspacing="1" bgcolor="black">
                    <tr>
                        <td class="tableHead" align="center" colspan="3">
                            Geb�ude
                        </td>
                    <!-- </tr>
                    <tr>  -->
                {foreach from=$BUILDINGSTATS item=VL}
                    {if $VL.o_newLine}</tr><tr>{/if}
                        <td class="tableInner1">
                            <table cellpadding="0" cellspacing="0" width="100%" {if $VL.o_alpha}title="Wird erforscht. Nur per Assistent baubar.{/if}>
                                <tr>
                                    <td class="tableInner1" align="center" {if $VL.o_alpha}style="opacity:0.5"{/if}>
                                        <b>
                                            {$VL.name}
                                            <a target="_blank" href="{$WIKI}{$VL.name}">
                                                {$VL.o_BuildingTooltip}
                                            </a>
                                            <br />
                                            <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td {if $VL.o_alpha}style="opacity:0.5"{/if}>
                                        <img width="180" src="{$LAYOUT.images}{$VL.building_id}.jpg" style="border:1px solid black"><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tableInner2" {if $VL.o_alpha}style="opacity:0.5"{/if}>
                                        <table width="100%" class="tableInner2" cellspacing="0" cellpadding="2" >
                                            <tr>
                                                <td align="left">
                                                    In Bau: 
                                                    <b class="highlightAuftableInner">
                                                        {$VL.o_inbuild}
                                                    </b>
                                                </td>
                                                <td align="right">
                                                    gebaut: 
                                                    <b class="highlightAuftableInner">
                                                        {$VL.o_status} ({$VL.o_percentage}%)
                                                    </b>
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="100%" class="tableInner2" cellspacing="0" cellpadding="2" >
                                            <tr>
                                                <td align="center">
                                                    �ndern: 
                                                    <input class="input" name="{$VL.o_key}" size="3" tabindex="1"></input><br>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                {/foreach}
                {section name=I start=$GEBS_IN_LINE loop=$GEBS_PER_LINE}
                        <td class="tableInner1">
                        </td>
                {/section}
                    </tr>
        {/if}
                    <tr>
                        <td colspan="{$GEBS_COLSPAN}" width="100%" class="siteGround">
                            <table class=normal cellspacing="0" cellpadding="0" align=center width=100%>
                                <tr>
                                    <td height="5" class="siteGround" colspan="2"></td>
                                </tr>
                                <tr>
                                    <td align="left" class="siteGround" valign="bottom">
                                        <div align="left">
                                            <br>
                                            <a class="linkAufTableInner" href="gebaeude.php?switchview=true">
                                                <img src="{$LAYOUT.images}/dot-gelb.gif" border="0"> Ansicht wechseln
                                            </a>
                                        </div>
                                    </td>
                                    <td align="right" class="siteGround">
                                    {if $FEATURES_GEBASSI}
                                        <input class="radio" type="radio" name="decision" value="queue"> Bauassistent
                                    {/if}
                                        <input class="radio" type="radio" name="decision" value="build" checked="yes"> bauen
                                        <input type="radio" name="decision" value="destroy"> abrei�en<br>
                                    {if $STATUS.safety == 1}
                                        <input type="hidden" name="destroyfinal" value="true">
                                    {/if}
                                        <br>
                                        <input class="button" type="submit" value="Auftrag erteilen" style="width:140px" tabindex="12">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </form>
    
    <!-- Milit�rakademien und Behemothfabriken aktiveren/deaktivieren -->
    
    {if $MAYSUSPENDSCHOOLS}
        {if $STATUS.suspend_schools == 1}
            <br>
            <b>Milit�rakademien sind deaktiviert!</b>
        {/if}
            <div align="center">
                <br>
                <a class="linkAufTableInner" href="gebaeude.php?changesuspension=1&suspendschools={if $STATUS.suspend_schools == 0}1{else}0{/if}">
                    <img src="{$LAYOUT.images}/dot-gelb.gif" border="0">
                    Milit�rakademien {if $STATUS.suspend_schools == 0}deaktivieren{else}aktivieren{/if}
                </a>
            </div>
    {/if}
    {foreach from=$TABLES item=TABLE}
            {if !$TABLE.error}
                <br>
                <table width="600" cellpadding="0" cellspacing="0" border="0" class="tableOutline">
                    <tr>
                        <td>
                            <table  border="0" cellspacing="1" width="100%" cellpadding="3">
                                <tr class="tableHead">
                                    <td align=center>#</td>
                                    {foreach from=$HOURCOL item=CURRENT}
                                        <td align=middle> &nbsp;{$CURRENT}</td>
                                    {/foreach}
                                </tr>
                                {foreach from=$TABLE.rows item=ROW}
                                    <tr class="tableInner1">
                                        <td width=105>{$ROW.name}</td>
                                        {foreach from=$ROW.details item=DETAIL}
                                            <td align=middle>
                                                {$DETAIL}
                                            </td>
                                        {/foreach}
                                    </tr>
                                {/foreach}
                            </table>
                        </td>
                    </tr>
                </table>
            {/if}
            <br>
        {/foreach}
        </center>
    
    <!-- Geb�udeassistent -->
        
        <br>
        <br>
        <table align="center" width="96%" class="siteGround">
            <tr>
                <td align="center" valign="top">
                    <table cellpadding="5" cellspacing="1" border="0" width="300" class="tableOutline">
                        <tr class="tableHead">
                            <td align="center" colspan="2">
                                Geb�udeassistent
                            </td>
                        </tr>
                    {if $FEATURES_GEBASSI}
                        {if $GEBASSI_ENTRIES}
                            {foreach from=$GEBASSI_ENTRIES item=VL}
                                <tr class="tableInner1">
                                    <td>
                                        {$VL.position}. ::: {$VL.o_number} {$VL.o_BuildingName}
                                    </td>
                                    <td>
                                {if $VL.position > 1}
                                        <a href="gebaeude.php?doings=modifyqueue&pos={$VL.position}&down=1" class="linkaufSiteBg">
                                            <img border="0" src="{$RIPF}_for_up.gif">
                                        </a>
                                {/if}
                                {if $VL.position < $ANZ_FOR}
                                        <a href="gebaeude.php?doings=modifyqueue&pos={$VL.position}&up=1" class="linkaufSiteBg">
                                            <img border="0" src="{$RIPF}_for_down.gif">
                                        </a>
                                {/if}
                                        <a href="gebaeude.php?doings=unqueue&pos={$VL.position}" class="linkaufSiteBg">
                                            <img border="0" src="{$RIPF}_for_deselect.gif">
                                        </a>
                                    </td>
                                </tr>
                            {/foreach}
                        <tr class="tableInner2">
                            <td colspan="2" align="center">
                                <a href="gebaeude.php?doings=unqueueall" class="linkAufsiteBg">
                                    Warteliste leeren
                                </a>
                            </td>
                        </tr>
                        {else}
                        <tr class="tableInner1">
                            <td colspan="2" align="center">
                                Keine Eintr�ge in der Warteliste.
                            </td>
                        </tr>
                        {/if}
                    {else}
                        <tr class="tableInner1">
                            <td>
                                Mit diesem Assistenten k�nnen Sie bis zu {$ANZAHL_ASSISTENTEN_PLAETZE} Geb�ude- oder 
                                Landkauf-Auftr�ge in eine Warteschlange legen, die nach und nach abgearbeitet wird.
                            </td>
                        </tr>
                        <tr class="tableInner2">
                            <td colspan="2" align="center">
                                <a href="premiumfeatures.php" class="linkAufsiteBg">
                                    Mehr Informationen
                                </a>
                            </td>
                        </tr>
                    {/if}
                    </table>
                </td>
            </tr>
        </table>
    
    <!-- Nanofabriken -->
    
    {if $MULTIFUNC_SHOW} 
        <br><br><br><br>
        <form action="gebaeude.php" method="post">
            <table width="500" align="center" cellpadding="0" cellspacing="0" border="0" class="tableOutline">
                <tr>
                    <td>
                        <table border="0" cellspacing="1" width="500" cellpadding="5">
                            <tr class="tableHead">
                                <td width="180" colspan="5">
                                    <b>Nanofabriken - Produktion</b>
                                </td>
                            </tr>
                            <tr class="tableInner1">
                                <td>
                                    <input type="radio" name="nano" value="money" {$MULTIFUNC_CHECKED_MONEY}> Credits<br>
                                </td>
                                <td>
                                    <input type="radio" name="nano" value="energy" {$MULTIFUNC_CHECKED_ENERGY}> Energie<br>
                                </td>
                                <td>
                                    <input type="radio" name="nano" value="metal" {$MULTIFUNC_CHECKED_METAL}> Erz<br>
                                </td>
                                <td>
                                    <input type="radio" name="nano" value="sciencepoints" {$MULTIFUNC_CHECKED_SCIENCEPOINTS}> Forschungspunkte<br>
                                </td>
                                <td align="center" width="60">
                                    <input type="submit" value="Produktion �ndern">
                                </td>
                            </tr>
                            <tr class="tableInner1">
                                <td colspan=5>
                                    Status:
                                    {if $STATUS.multifunc < 99}
                                        <b>produziert</b>
                                    {else}
                                        Produktion startet in {$MULTIFUNC_RESTTIME} Z�gen
                                    {/if}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    {/if}
{/if}