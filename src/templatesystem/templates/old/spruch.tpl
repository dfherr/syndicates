		<div align="center">
{if !$ZUGANG}
		<br />
		<br />
		<h4>Neuen Spruch einf�gen:</h4>
		<form action="spruch.php" method="post">
			<input type="hidden" name="action" value="insert">
			<textarea name="text" rows="4" cols="35"></textarea><br />
			<input type="submit" value="Eintragen">
		</form>
		<br />
		<br />
		<table border="0" cellspacing="1" cellpadding="2" width="600" align="center" class="tableOutline">
			<tr class="tableHead2">
				<td align="center" width="30px"><img src="{$GP_PATH}dot-gelb.gif" border="0" hspace="5"></td>
				<td align="center" width="390px">Spruch</td>
				<td align="center" width="100px">User</td>
				<td align="center" width="80px">Aktion</td>
			</tr>
			{foreach name=sprueche item=SPRUCH from=$SPRUECHE}
			<form action="spruch.php" method="post">
				<input type="hidden" name="action" value="delete">
				<input type="hidden" name="id" value="{$SPRUCH.id}">
				<tr class="tableInner1">
					<td align="center">{$smarty.foreach.sprueche.iteration}.:</td>
					<td align="left">{$SPRUCH.txt}</td>
					<td align="center">{$SPRUCH.name}</td>
					<td align="center"><input type="submit" value="l�schen"></td>
				</tr>
			</form>
			{/foreach}
		</table>
{else}
		<br />
		<br />
		<h3>F�r den Zugang wird ein Passwort ben�tigt</h3>
		<form action="spruch.php" method="post">
			<input type="password" name="password" size="15">
			<input type="submit" value="Login">
		</form>
{/if}
		</div>