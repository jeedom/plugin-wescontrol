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
$eqLogics = eqLogic::byType('wescontrol', true);
?>

<form class="form-horizontal">
	<fieldset>
		<div class="form-group">
			<label class="col-sm-4 control-label">{{Fréquence de rafraîchissement}} <sub>(s.)</sub>
				<sup><i class="fas fa-question-circle tooltips" title="{{Délai en secondes entre 2 interrogations du serveur Wes. 30 par défaut}}"></i></sup>
			</label>
			<div class="col-sm-6">
				<input type="number" min="0" step="1" class="configKey form-control" data-l1key="pollInterval" onkeydown="if(event.key==='.'||event.key===','||event.key==='+'||event.key==='-'){event.preventDefault();}" oninput="event.target.value=event.target.value.replace(/\D/,'');" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 control-label">{{Version du fichier CGX}}
				<sup><i class="fas fa-question-circle tooltips" title="{{Numéro de la dernière version du fichier CGX disponible dans le plugin}}"></i></sup>
			</label>
			<div class="col-sm-6">
				<span class="configKey label label-info" data-l1key="cgxversion"></span>
				<?php
				$pluginVersion = update::byLogicalId('wescontrol')->getConfiguration('version');
				$localCGXVersion = config::byKey('cgxversion', 'wescontrol', '');
				$countWesServers = $countNotToDate = $countNeedStable = $countNeedBeta = 0;
				foreach ($eqLogics as $eqLogic) {
					if ($eqLogic->getConfiguration('type') === 'general') {
						$countWesServers++;
						if ($eqLogic->getConfiguration('usecustomcgx', 0) == 1 && !empty($cgxWes = $eqLogic->getCmd('info', 'servercgxversion')->execCmd())) {
							if (version_compare($cgxWes, $localCGXVersion, '<')) {
								$countNotToDate++;
							}
						}
						if (!empty($firmwareWes = $eqLogic->getCmd('info', 'firmware')->execCmd())) {
							if (version_compare($firmwareWes, 'V0.84A10', '<') && $pluginVersion != 'stable') {
								$countNeedStable++;
							} else if (version_compare($firmwareWes, 'V0.84A10', '>=') && $pluginVersion != 'beta') {
								$countNeedBeta++;
							}
						}
					}
				}
				if ($countWesServers > 0) {
					if ($countNotToDate == 0) {
						$cgxAlert = 'label-success';
						$message = '{{Tous les serveurs Wes sont à jour}} (' . $countWesServers . ')';
					} else if ($countNotToDate == $countWesServers) {
						$cgxAlert = 'label-danger';
						$message = '{{Aucun serveur Wes à jour sur}} ' . $countWesServers;
						$updatebutton = '<a class="btn btn-success" id="bt_UpdateCGX" title="{{Cliquez sur le bouton pour mettre à jour le fichier CGX sur tous les serveurs Wes}}" style="margin-top:5px;"><i class="fas fa-sync"></i> {{Mettre tous les serveurs Wes à jour}}</a>';
					} else {
						$cgxAlert = 'label-warning';
						$message = $countNotToDate . ' {{serveur(s) Wes à jour sur}} ' . $countWesServers;
						$updatebutton = '<a class="btn btn-success" id="bt_UpdateCGX" title="{{Cliquez sur le bouton pour mettre à jour le fichier CGX sur tous les serveurs Wes}}" style="margin-top:5px;"><i class="fas fa-sync"></i> {{Mettre tous les serveurs Wes à jour}}</a>';
					}
					echo '<span class="label ' . $cgxAlert . '">' . $message . '</span><br>' . $updatebutton;
					if ($countNeedBeta > 0) {
						echo '<div class="alert alert-warning">{{Nous vous conseillons de basculer sur la version beta du plugin pour une meilleure compatibilité avec les firmwares Wes supérieurs ou égaux à V0.84A10.}}</div>';
					} else if ($countNeedStable > 0) {
						echo '<div class="alert alert-warning">{{Nous vous conseillons de basculer sur la version stable du plugin pour une meilleure compatibilité avec les firmwares Wes inférieurs à V0.84A10.}}</div>';
					}
				}
				?>
			</div>
		</div>
	</fieldset>
</form>
<script>
	$('#bt_UpdateCGX').on('click', function() {
		$('#div_alertPluginConfiguration').showAlert({
			message: '{{En cours de mise à jour des fichiers CGX sur tous les serveurs Wes}}',
			level: 'warning'
		});
		$.ajax({
			type: "POST",
			url: "plugins/wescontrol/core/ajax/wescontrol.ajax.php",
			data: {
				action: "updateAllCGX",
			},
			dataType: 'json',
			error: function(error) {
				$('#div_alertPluginConfiguration').showAlert({
					message: error.message,
					level: 'danger'
				})
			},
			success: function(data) {
				window.location.reload()
			}
		})
	})
</script>
