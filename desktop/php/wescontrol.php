<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('wescontrol');
$eqLogics = eqLogic::byType($plugin->getId());
$typeArray = wescontrol::getTypes();
sendVarToJS(['eqType'=>$plugin->getId(),'typeid'=>$typeArray, 'jeedomversion'=>config::byKey('version')]);
?>
<style>
.ui-sortable-placeholder {
  display: block!important;
}
</style>
<div class="row row-overflow">
	<div class="col-lg-12 eqLogicThumbnailDisplay">
		<legend><i class="fas fa-cog"></i>  {{Gestion}}</legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor eqLogicAction logoPrimary" data-action="add">
				<i class="fas fa-plus-circle"></i>
				<br>
				<span>{{Ajouter}}</span>
			</div>
			<div class="cursor eqLogicAction logoSecondary" data-action="gotoPluginConf">
				<i class="fas fa-wrench"></i>
				<br>
				<span>{{Configuration}}</span>
			</div>
		</div>
		<legend><i class="fas fa-digital-tachograph"></i> {{Mes serveurs Wes}}</legend>
		<?php
		if (count($eqLogics) == 0) {
			echo "<br/><div class=\"text-center\" style='font-size:1.2em;font-weight: bold;'>{{Aucun serveur Wes n'est paramétré, cliquer sur \"Ajouter\" pour commencer}}</div>";
		} else {
			echo '<div class="input-group" style="margin-bottom:5px;">';
			echo '<input class="form-control roundedLeft" placeholder="{{Rechercher}}" id="in_searchwescontrol"/>';
			echo '<div class="input-group-btn">';
			echo '<a id="bt_resetwescontrolSearch" class="btn tooltips" style="width:30px" title="{{Annuler la recherche}}"><i class="fas fa-times"></i></a>';
			echo '</div>';
			echo '<div class="input-group-btn">';
			echo '<a class="btn tooltips" id="bt_openAllwescontrol" title="{{Tout déplier}}"><i class="fas fa-folder-open"></i></a>';
			echo '</div>';
			echo '<div class="input-group-btn">';
			echo '<a class="btn tooltips roundedRight" id="bt_closeAllwescontrol" title="{{Tout plier}}"><i class="fas fa-folder"></i></a>';
			echo '</div>';
			echo '</div>';
			echo '<div class="panel-group">';
			$generalEqLogics = array();
			$sortedMenu = array();
			$childEqLogics = array();
			$activeChildEqLogics = array();

			foreach ($eqLogics as $eqLogic) {
				if ($eqLogic->getConfiguration('type') == 'general') {
					array_push($generalEqLogics, $eqLogic);
					$sortedMenu[$eqLogic->getId()] = $eqLogic->getDisplay('menuorder', '');
				}
				else {
					$generalId = substr($eqLogic->getLogicalId(), 0, strpos($eqLogic->getLogicalId(),"_"));
					$childEqLogics[$generalId][$eqLogic->getConfiguration('type')][] = $eqLogic;
					if ($eqLogic->getIsEnable()) {
						$activeChildEqLogics[$generalId][$eqLogic->getConfiguration('type')][] = '';
					}
				}
			}

			foreach ($generalEqLogics as $generalEqLogic) {
				echo '<div style="width:100%;display:flex;">';
				echo '<div class="eqLogicThumbnailContainer" style="width:130px;">';
				$opacity = ($generalEqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor '.$opacity.'" data-eqLogic_id="' . $generalEqLogic->getId() . '">';
				$img = $plugin->getPathImgIcon();
				if (file_exists(dirname(__FILE__) . '/../../core/config/general.png')) {
					$img = 'plugins/wescontrol/core/config/general.png';
				}
				if ($generalEqLogic->getConfiguration('screen',0) == 1 && file_exists(dirname(__FILE__) . '/../../core/config/general_screen.png')) {
					$img = 'plugins/wescontrol/core/config/general_screen.png';
				}
				echo '<img src="' . $img . '"/>';
				echo '<span class="name">' . $generalEqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';
				echo '</div>';

				echo '<div class="col-sm-12 wesSortableMenu" data-generalId="'.$generalEqLogic->getId().'" style="margin-bottom:20px;">';
				if (!empty($sortedMenu[$generalEqLogic->getId()]) && is_array($sortedMenu[$generalEqLogic->getId()])) {
					$childEqLogics[$generalEqLogic->getId()] = array_merge(array_flip($sortedMenu[$generalEqLogic->getId()]), $childEqLogics[$generalEqLogic->getId()]);
				}
				foreach ($childEqLogics[$generalEqLogic->getId()] as $type => $childEqLogic) {
					if (empty($childEqLogic) || !is_array($childEqLogic)) {
						continue;
					}
					echo '<div class="panel panel-default" data-type="'.$type.'">';
					echo '<div class="panel-heading">';
					echo '<div class="panel-title">';
					echo '<a class="accordion-toggle wescontrolTab" data-toggle="collapse" data-parent="" aria-expanded="false" href="#wescontrol_'.$type.$generalEqLogic->getId().'">';
					$img = $plugin->getPathImgIcon();
					if (file_exists(dirname(__FILE__) . '/../../core/config/'.$type.'.png')) {
						$img = 'plugins/wescontrol/core/config/'.$type.'.png';
					}
					$countTotal = count($childEqLogic);
					$countActive = count($activeChildEqLogics[$generalEqLogic->getId()][$type]);
					$classCount = 'icon_orange';
					if ($countActive == $countTotal) {
						$classCount = 'icon_green';
					}
					else if ($countActive == 0) {
						$classCount = 'icon_red';
					}
					echo '<img src="'.$img.'" width="30px"/> ' . $typeArray[$type]['name'] . '  <sub class="'.$classCount.'">'.$countActive.'/'.$countTotal.'</sub>';
					echo '</div>';
					echo '</div>';
					echo '<div id="wescontrol_'.$type.$generalEqLogic->getId().'" class="panel-collapse collapse">';
					echo '<div class="panel-body" style="padding:0 0 0 5px!important;">';
					echo '<div class="eqLogicThumbnailContainer packery">';
					foreach ($childEqLogic as $eqLogic) {
						$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
						echo '<div class="eqLogicDisplayCard cursor '.$opacity.'" data-eqLogic_id="' . $eqLogic->getId() . '">';
						if (file_exists(dirname(__FILE__) . '/../../core/config/'.$type.'.png')) {
							$img = 'plugins/wescontrol/core/config/'.$type.'.png';
						}
						if (isset($typeArray[$type]['alternateimg'])) {
							if ($typeArray[$type]['alternateimg']['type'] == 'binary' && $eqLogic->getConfiguration($typeArray[$type]['alternateimg']['value'], 0) == 1 && file_exists(dirname(__FILE__) . '/../../core/config/'.$type.'_'.$typeArray[$type]['alternateimg']['value'].'.png')) {
								$img = 'plugins/wescontrol/core/config/'.$type.'_'.$typeArray[$type]['alternateimg']['value'].'.png';
							} else if ($typeArray[$type]['alternateimg']['type'] == 'select' && file_exists(dirname(__FILE__) . '/../../core/config/'.$type.'_'.$eqLogic->getConfiguration($typeArray[$type]['alternateimg']['value'],'').'.png')) {
								$img = 'plugins/wescontrol/core/config/'.$type.'_'.$eqLogic->getConfiguration($typeArray[$type]['alternateimg']['value'],'').'.png';
							}
						}
						echo '<img src="' . $img . '"/>';
						echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
						echo '</div>';
					}
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				}
				echo '</div>';
				echo '</div>';
			}
			echo '</div>';
		}
		?>
	</div>

	<div class="col-lg-12 eqLogic" style="display: none;">
		<div class="input-group pull-right" style="display:inline-flex">
			<span class="input-group-btn">
				<a class="btn btn-primary btn-sm eqLogicAction roundedLeft" id="bt_goCarte"><i class="far fa-window-restore"></i><span class="hidden-xs"> {{Interface Wes}}</span>
				</a><a class="btn btn-default btn-sm eqLogicAction" data-action="configure"><i class="fa fa-cogs"></i><span class="hidden-xs"> {{Configuration avancée}}</span>
				</a><a class="btn btn-default btn-sm eqLogicAction" data-action="copy"><i class="fas fa-copy"></i><span class="hidden-xs"> {{Dupliquer}}</span>
				</a><a class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}
				</a><a class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
			</span>
		</div>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fas fa-arrow-circle-left"></i></a></li>
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-tachometer-alt"></i> {{Équipement}}</a></li>
			<li role="presentation"><a href="#commandtab" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-list"></i> {{Commandes}}</a></li>
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="eqlogictab">
				<form class="form-horizontal">
					<fieldset>
						<div class="col-lg-6">
							<legend><i class="fas fa-wrench"></i> {{Paramètres généraux}}</legend>
							<div class="form-group">
								<label class="col-sm-3 control-label">{{Nom}}</label>
								<div class="col-sm-7">
									<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
									<input id="typeEq" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="type" style="display : none;"/>
									<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement}}"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" >{{Objet parent}}</label>
								<div class="col-sm-7">
									<select class="eqLogicAttr form-control" data-l1key="object_id">
										<option value="">{{Aucun}}</option>
										<?php
										$options = '';
										foreach ((jeeObject::buildTree(null, false)) as $object) {
											$options .= '<option value="' . $object->getId() . '">' . str_repeat('&nbsp;&nbsp;', $object->getConfiguration('parentNumber')) . $object->getName() . '</option>';
										}
										echo $options;
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">{{Catégorie}}</label>
								<div class="col-sm-7">
									<?php
									foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
										echo '<label class="checkbox-inline">';
										echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
										echo '</label>';
									}
									?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">{{Options}}</label>
								<div class="col-sm-7">
									<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-label-text="{{Activer}}" data-l1key="isEnable" checked/>Activer</label>
									<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-label-text="{{Visible}}" data-l1key="isVisible" checked/>Visible</label>
								</div>
							</div>

							<legend class="showgeneral" style="display: none;"><i class="fas fa-cogs"></i> {{Paramètres spécifiques}}</legend>
							<div class="form-group showgeneral" style="display: none;">
								<label class="col-sm-3 control-label">{{Options Wes}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Cocher les matériels optionnels branchés sur ce serveur Wes}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-label-text="{{Écran}}" data-l1key="configuration" data-l2key="screen"/>{{Écran}}</label>
									<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-label-text="{{Alimentation 9V}}" data-l1key="configuration" data-l2key="9v"/>{{Alimentation 9V}}</label>
								</div>
							</div>
							<br class="showgeneral">
							<div class="form-group showgeneral" style="display: none;">
								<label class="col-sm-3 control-label">{{IP du Wes}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Adresse ip sur laquelle le serveur Wes est joignable}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="ip"/>
								</div>
							</div>
							<div class="form-group showgeneral" style="display: none;">
								<label class="col-sm-3 control-label">{{Port du Wes}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Port de communication sur lequel le serveur Wes est joignable. (facultatif - 80 par défaut)}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="port" placeholder="80"/>
								</div>
							</div>
							<div class="form-group showgeneral" style="display: none;">
								<label class="col-sm-3 control-label">{{Identifiant HTTP}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Renseigner l'identifiant du compte pour l'accès HTTP. Permet de communiquer avec le serveur Wes}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="username"/>
								</div>
							</div>
							<div class="form-group showgeneral" style="display: none;">
								<label class="col-sm-3 control-label">{{Mot de passe HTTP}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Renseigner le mot de passe du compte pour l'accès HTTP. Permet de communiquer avec le serveur Wes}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<input type="text" class="eqLogicAttr form-control inputPassword" data-l1key="configuration" data-l2key="password"/>
								</div>
							</div>

							<legend class="showgeneral" style="display: none;"><i class="fas fa-file-code"></i> {{Fichier CGX Jeedom}}</legend>
							<div class="form-group showgeneral" style="display: none;">
								<label class="col-sm-3 control-label" >{{Activer}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Cocher la case pour utiliser le fichier CGX spécialement conçu pour le plugin afin de récupérer davantage de données}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<input type="checkbox" class="eqLogicAttr" data-label-text="{{Activer}}" data-l1key="configuration" data-l2key="usecustomcgx"/>
								</div>
							</div>
							<div class="showgeneral" id="CGXParams" style="display: none;">
							<br>
							<div class="form-group">
								<label class="col-sm-3 control-label">{{Identifiant FTP}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Renseigner l'identifiant du compte pour l'accès FTP. Permet l'envoi du fichier CGX sur le serveur Wes}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="ftpusername"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">{{Mot de passe FTP}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Renseigner le mot de passe du compte pour l'accès FTP. Permet l'envoi du fichier CGX sur le serveur Wes}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<input type="text" class="eqLogicAttr form-control inputPassword" data-l1key="configuration" data-l2key="ftppassword"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" >{{Envoyer le fichier}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Cliquer sur le bouton pour envoyer le fichier CGX sur le serveur Wes}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<a class="btn btn-primary btn-sm eqLogicAction tooltips" data-action="sendCGX"><i class="fas fa-file-export"></i> {{Envoyer fichier CGX}}</a>
									<label class="checkbox-inline" style="margin-left:10px;"><input type="checkbox" class="eqLogicAttr" data-label-text="{{Mise à jour automatique}}" data-l1key="configuration" data-l2key="autoupdatecgx"/>{{Mise à jour automatique}}	<sup><i class="fas fa-question-circle tooltips" title="{{Cocher la case pour que le fichier soit automatiquement mis à jour sur le serveur en cas de nouvelle version}}"></i></sup></label>
								</div>
							</div>
						</div>

							<legend class="showteleinfo" style="display: none;"><i class="fas fa-cogs"></i> {{Paramètres spécifiques}}</legend>
							<div class="form-group showteleinfo" style="display: none;">
								<label class="col-sm-3 control-label">{{Tarification}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Indiquer la formule de tarification de votre abonnement}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="tarification">
										<option value="BASE">{{Base/Sans Tarification}}</option>
										<option value="HC">Heures Creuses</option>
										<option value="BBRH">Tempo</option>
										<option value="EJP">EJP</option>
									</select>
								</div>
							</div>
							<div class="form-group showteleinfo" style="display: none;">
								<label class="col-sm-3 control-label">{{Type de mesure}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Indiquer le type de mesure à relever}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="ticMeasure">
										<option value="" disabled>*** {{A renseigner}} ***</option>
										<option value="consumption">{{Consommation}}</option>
										<option value="production">{{Production}}</option>
									</select>
								</div>
							</div>
							<div class="form-group showteleinfo" style="display: none;">
								<label class="col-sm-3 control-label">{{Type de compteur}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Indiquer le type de compteur TIC utilisé afin de personnaliser l'image d'illustration}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="typetic">
										<option value="" disabled>*** {{A renseigner}} ***</option>
										<option value="linky">{{Linky}}</option>
										<option value="other">{{Autre}}</option>
									</select>
								</div>
							</div>

							<legend class="showpince" style="display: none;"><i class="fas fa-cogs"></i> {{Paramètres spécifiques}}</legend>
							<div class="form-group showpince" style="display: none;">
								<label class="col-sm-3 control-label">{{Type de mesure}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Indiquer le type de mesure à relever}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="pinceMeasure">
										<option value="" disabled>*** {{A renseigner}} ***</option>
										<option value="consumption">{{Consommation}}</option>
										<option value="production">{{Production}}</option>
									</select>
								</div>
							</div>
							<div class="form-group showpince" style="display: none;">
								<label class="col-sm-3 control-label">{{Type de pince}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Indiquer le type de pince utilisé afin de personnaliser l'image d'illustration de l'équipement}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="typepince">
										<option value="" disabled>*** {{A renseigner}} ***</option>
										<option value="20a">{{20 Ampères (20A)}}</option>
										<option value="100a">{{100 Ampères (100A)}}</option>
									</select>
								</div>
							</div>

							<legend class="showcompteur" style="display: none;"><i class="fas fa-cogs"></i> {{Paramètres spécifiques}}</legend>
							<div class="form-group showcompteur" style="display: none;">
								<label class="col-sm-3 control-label">{{Type de compteur}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Indiquer le type de compteur utilisé afin de personnaliser l'image d'illustration de l'équipement}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="typecompt">
										<option value="" disabled>*** {{A renseigner}} ***</option>
										<option value="cal">{{Calories}}</option>
										<option value="eau">{{Eau}}</option>
										<option value="elec">{{Electricité}}</option>
										<option value="fioul">{{Fioul}}</option>
										<option value="gaz">{{Gaz}}</option>
										<option value="gazpar">{{Gazpar}}</option>
									</select>
								</div>
							</div>
							<div class="form-group showcompteur" style="display: none;">
								<label class="col-sm-3 control-label">{{Type de mesure}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Indiquer le type de mesure à relever}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="comptMeasure">
										<option value="" disabled>*** {{A renseigner}} ***</option>
										<option value="consumption">{{Consommation}}</option>
										<option value="production">{{Production}}</option>
									</select>
								</div>
							</div>

							<legend class="showsonde" style="display: none;"><i class="fas fa-cogs"></i> {{Paramètres spécifiques}}</legend>
							<div class="form-group showsonde" style="display: none;">
								<label class="col-sm-3 control-label">{{Type de mesure}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Indiquer le type de mesure à relever}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="sondeMeasure">
										<option value="" disabled>*** {{A renseigner}} ***</option>
										<option value="temperature">{{Température}}</option>
										<option value="humidity">{{Humidité}}</option>
										<option value="luminosity">{{Luminosité}}</option>
									</select>
								</div>
							</div>
						</div>


						<div class="col-lg-6 showgeneral" style="display: none;">
							<legend><i class="fas fa-tasks"></i> {{Gestion des équipements}}</legend>
							<div class="alert alert-warning col-xs-10 col-xs-offset-1">
								<i class="fas fa-exclamation-triangle"></i>
								{{Décocher une ou plusieurs cases aura pour conséquence la suppression du ou des équipements correspondants.}}
							</div>
							<?php
							foreach ($typeArray as $key => $value) {
								if (isset($value["maxnumber"])) {
									echo'<div class="form-group">';
									echo '<label class="col-sm-3 control-label">'.$value["name"].'<img width="30px" src="plugins/wescontrol/core/config/'.$key.'.png"/></label>';
									echo '<div class="col-sm-7">';
									foreach (range(1,$value["maxnumber"]) as $number) {
										echo '<label class="checkbox-inline">';
										echo '<input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="' . $key.$number . '"/>' .$value["type"].' '.$number;
										echo '</label>';
									}
									echo '</div>';
									echo '</div>';
								}
							}
							?>
						</div>
						<div class="col-lg-6 hidegeneral">
							<legend><i class="fas fa-info"></i> {{Informations}}</legend>
							<div class="form-group">
								<label class="col-sm-3 control-label">{{Type d'équipement Wes}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Catégorie d'équipement Wes}}"></i></sup>
								</label>
								<div class="col-sm-7">
									<strong id="span_type"></strong>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3"></label>
								<div class="col-sm-7">
									<img id="icon_visu" style="max-width:160px;"/>
								</div>
							</div>
						</div>
					</fieldset>
				</form>
				<hr>
			</div>

			<div role="tabpanel" class="tab-pane" id="commandtab">
					<table id="table_cmd" class="table table-bordered table-condensed">
						<thead>
							<tr>
								<th class="visible-lg">{{ID}}</th>
								<th>{{Nom}}</th>
								<th>{{Type}}</th>
								<th>{{Paramètres}}</th>
								<th>{{Options}}</th>
								<th>{{Actions}}</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
			</div>
		</div>
	</div>
</div>

<?php
include_file('core', 'plugin.template', 'js');
include_file('desktop', 'wescontrol', 'js', 'wescontrol');
?>
