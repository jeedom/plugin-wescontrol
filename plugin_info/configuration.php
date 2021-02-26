<?php
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<form class="form-horizontal">
	<fieldset>
		<div class="form-group">
			<label class="col-sm-3 control-label">{{Version CGX locale}}
				<sup><i class="fas fa-question-circle tooltips" title="{{Version du fichier CGX Jeedom du plugin}}"></i></sup>
			</label>
			<div class="col-sm-7">
				<span class="configKey label label-info" data-l1key="cgxversion"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">{{Fréquence de rafraîchissement}} <sub>(s.)</sub>
				<sup><i class="fas fa-question-circle tooltips" title="{{Délai en secondes entre 2 interrogations du serveur Wes. 30 par défaut}}"></i></sup>
			</label>
			<div class="col-sm-7">
				<input type="number" min="0" step="1" class="configKey form-control" data-l1key="pollInterval" onkeydown="if(event.key==='.'||event.key===','||event.key==='+'||event.key==='-'){event.preventDefault();}" oninput="event.target.value=event.target.value.replace(/\D/,'');"/>
			</div>
		</div>
	</fieldset>
</form>
