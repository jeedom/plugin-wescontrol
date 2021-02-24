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
			<label class="col-sm-3 control-label">{{Temps entre deux lectures}} <sub>(s.)</sub>
				<sup><i class="fas fa-question-circle tooltips" title="{{Délai en secondes entre 2 interrogations du serveur Wes.}}"></i></sup>
			</label>
			<div class="col-sm-7">
				<input class="configKey form-control" data-l1key="temporisation_lecture"/>
			</div>
		</div>
	</fieldset>
</form>
