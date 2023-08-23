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

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class wescontrol extends eqLogic {

	private function getListeCommandes() {
		$commands = array(
			"teleinfo" => array(
				"ADCO" => array("name" => __("Numéro compteur", __FILE__), "type" => "info", "subtype" => "numeric", "xpath" => "//tic#id#/ADCO", "visible" => 0, "dashboard" => "line", "mobile" => "line", "order" => 0),
				"OPTARIF" => array("name" => __("Option tarif", __FILE__), "type" => "info", "subtype" => "string", "xpath" => "//tic#id#/OPTARIF", "visible" => 0, "order" => 1),
				"ISOUSC" => array("name" => __("Intensité souscrite", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "A", "visible" => 0, "dashboard" => "line", "mobile" => "line", "xpath" => "//tic#id#/ISOUSC", "order" => 2),
				"PTEC" => array("name" => __("Tarif en cours", __FILE__), "type" => "info", "subtype" => "string", "xpath" => "//tic#id#/PTEC", "order" => 3),
				"PAP" => array("name" => __("Puissance Apparente", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "VA", "xpath" => "//tic#id#/PAP", "dashboard" => "line", "mobile" => "line", "order" => 4),
				"IINST" => array("name" => __("Intensité instantanée", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "A", "xpath" => "//tic#id#/IINST", "dashboard" => "line", "mobile" => "line", "order" => 5),
				"IINST1" => array("name" => __("Intensité instantanée 1", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "A", "visible" => 0, "xpath" => "//tic#id#/IINST1", "dashboard" => "line", "mobile" => "line", "order" => 6),
				"IINST2" => array("name" => __("Intensité instantanée 2", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "A", "visible" => 0, "xpath" => "//tic#id#/IINST2", "dashboard" => "line", "mobile" => "line", "order" => 7),
				"IINST3" => array("name" => __("Intensité instantanée 3", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "A", "visible" => 0, "xpath" => "//tic#id#/IINST3", "dashboard" => "line", "mobile" => "line", "order" => 8),
				"IMAX" => array("name" => __("Intensité maximum", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "A", "visible" => 0, "xpath" => "//tic#id#/IMAX", "dashboard" => "line", "mobile" => "line", "order" => 9),
				"IMAX1" => array("name" => __("Intensité maximum 1", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "A", "visible" => 0, "xpath" => "//tic#id#/IMAX1", "dashboard" => "line", "mobile" => "line", "order" => 10),
				"IMAX2" => array("name" => __("Intensité maximum 2", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "A", "visible" => 0, "xpath" => "//tic#id#/IMAX2", "dashboard" => "line", "mobile" => "line", "order" => 11),
				"IMAX3" => array("name" => __("Intensité maximum 3", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "A", "visible" => 0, "xpath" => "//tic#id#/IMAX3", "dashboard" => "line", "mobile" => "line", "order" => 12),
				"TENS1" => array("name" => __("Tension 1", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "V", "xpath" => "//tic#id#/TENSION1", "dashboard" => "line", "mobile" => "line", "order" => 13),
				"TENS2" => array("name" => __("Tension 2", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "V", "visible" => 0, "xpath" => "//tic#id#/TENSION2", "dashboard" => "line", "mobile" => "line", "order" => 14),
				"TENS3" => array("name" => __("Tension 3", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "V", "visible" => 0, "xpath" => "//tic#id#/TENSION3", "dashboard" => "line", "mobile" => "line", "order" => 15),
				"PEJP" => array("name" => __("Préavis EJP", __FILE__), "type" => "info", "subtype" => "binary", "filter" => ["tarification" => "EJP"], "xpath" => "//tic#id#/PEJP", "order" => 16),
				"DEMAIN" => array("name" => __("Couleur demain", __FILE__), "type" => "info", "subtype" => "string", "filter" => ["tarification" => "BBRH"], "xpath" => "//tic#id#/DEMAIN", "order" => 17),
				"BASE" => array("name" => __("Index (BASE)", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "filter" => ["tarification" => "BASE"], "calcul" => "#value#/1000", "dashboard" => "line", "mobile" => "line", "xpath" => "//tic#id#/BASE", "order" => 18),
				"HCHC" => array("name" => __("Index (HC)", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "filter" => ["tarification" => "HC"], "calcul" => "#value#/1000", "dashboard" => "line", "mobile" => "line", "xpath" => "//tic#id#/H_CREUSE", "order" => 19),
				"HCHP" => array("name" => __("Index (HP)", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "filter" => ["tarification" => "HC"], "calcul" => "#value#/1000", "dashboard" => "line", "mobile" => "line", "xpath" => "//tic#id#/H_PLEINE", "order" => 20),
				"EJPHN" => array("name" => __("Index (normal EJP)", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "filter" => ["tarification" => "EJP"], "calcul" => "#value#/1000", "dashboard" => "line", "mobile" => "line", "xpath" => "//tic#id#/EJPHN", "order" => 21),
				"EJPHPM" => array("name" => __("Index (pointe mobile EJP)", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "filter" => ["tarification" => "EJP"], "calcul" => "#value#/1000", "dashboard" => "line", "mobile" => "line", "xpath" => "//tic#id#/EJPHPM", "order" => 22),
				"BBRHCJB" => array("name" => __("Index (heures creuses jours bleus Tempo)", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "filter" => ["tarification" => "BBRH"], "calcul" => "#value#/1000", "dashboard" => "line", "mobile" => "line", "xpath" => "//tic#id#/BBRHCJB", "order" => 23),
				"BBRHPJB" => array("name" => __("Index (heures pleines jours bleus Tempo)", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "filter" => ["tarification" => "BBRH"], "calcul" => "#value#/1000", "dashboard" => "line", "mobile" => "line", "xpath" => "//tic#id#/BBRHPJB", "order" => 24),
				"BBRHCJW" => array("name" => __("Index (heures creuses jours blancs Tempo)", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "filter" => ["tarification" => "BBRH"], "calcul" => "#value#/1000", "dashboard" => "line", "mobile" => "line", "xpath" => "//tic#id#/BBRHCJW", "order" => 25),
				"BBRHPJW" => array("name" => __("Index (heures pleines jours blancs Tempo)", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "filter" => ["tarification" => "BBRH"], "calcul" => "#value#/1000", "dashboard" => "line", "mobile" => "line", "xpath" => "//tic#id#/BBRHPJW", "order" => 26),
				"BBRHCJR" => array("name" => __("Index (heures creuses jours rouges Tempo)", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "filter" => ["tarification" => "BBRH"], "calcul" => "#value#/1000", "dashboard" => "line", "mobile" => "line", "xpath" => "//tic#id#/BBRHCJR", "order" => 27),
				"BBRHPJR" => array("name" => __("Index (heures pleines jours rouges Tempo)", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "filter" => ["tarification" => "BBRH"], "calcul" => "#value#/1000", "dashboard" => "line", "mobile" => "line", "xpath" => "//tic#id#/BBRHPJR", "order" => 28),
				"CONSO_JOUR" => array("name" => __("Consommation jour", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//tic#id#/CONSO_JOUR", "filter" => ["usecustomcgx" => 1, "ticMeasure" => "consumption"], "dashboard" => "line", "mobile" => "line", "order" => 29),
				"COUT_JOUR" => array("name" => __("Coût jour", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//tic#id#/COUT_JOUR", "filter" => ["usecustomcgx" => 1, "ticMeasure" => "consumption"], "dashboard" => "line", "mobile" => "line", "order" => 30),
				"CONSO_MOIS" => array("name" => __("Consommation mois", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//tic#id#/CONSO_MOIS", "filter" => ["usecustomcgx" => 1, "ticMeasure" => "consumption"], "dashboard" => "line", "mobile" => "line", "order" => 31),
				"COUT_MOIS" => array("name" => __("Coût mois", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//tic#id#/COUT_MOIS", "filter" => ["usecustomcgx" => 1, "ticMeasure" => "consumption"], "dashboard" => "line", "mobile" => "line", "order" => 32),
				"CONSO_ANNEE" => array("name" => __("Consommation année", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//tic#id#/CONSO_ANNEE", "filter" => ["usecustomcgx" => 1, "ticMeasure" => "consumption"], "dashboard" => "line", "mobile" => "line", "order" => 33),
				"COUT_ANNEE" => array("name" => __("Coût année", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//tic#id#/COUT_ANNEE", "filter" => ["usecustomcgx" => 1, "ticMeasure" => "consumption"], "dashboard" => "line", "mobile" => "line", "order" => 34),
				"PROD_JOUR" => array("name" => __("Production jour", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//tic#id#/CONSO_JOUR", "filter" => ["usecustomcgx" => 1, "ticMeasure" => "production"], "dashboard" => "line", "mobile" => "line", "order" => 29),
				"GAIN_JOUR" => array("name" => __("Gain jour", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//tic#id#/COUT_JOUR", "filter" => ["usecustomcgx" => 1, "ticMeasure" => "production"], "dashboard" => "line", "mobile" => "line", "order" => 30),
				"PROD_MOIS" => array("name" => __("Production mois", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//tic#id#/CONSO_MOIS", "filter" => ["usecustomcgx" => 1, "ticMeasure" => "production"], "dashboard" => "line", "mobile" => "line", "order" => 31),
				"GAIN_MOIS" => array("name" => __("Gain mois", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//tic#id#/COUT_MOIS", "filter" => ["usecustomcgx" => 1, "ticMeasure" => "production"], "dashboard" => "line", "mobile" => "line", "order" => 32),
				"PROD_ANNEE" => array("name" => __("Production année", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//tic#id#/CONSO_ANNEE", "filter" => ["usecustomcgx" => 1, "ticMeasure" => "production"], "dashboard" => "line", "mobile" => "line", "order" => 33),
				"GAIN_ANNEE" => array("name" => __("Gain année", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//tic#id#/COUT_ANNEE", "filter" => ["usecustomcgx" => 1, "ticMeasure" => "production"], "dashboard" => "line", "mobile" => "line", "order" => 34)
			),
			"general" => array(
				"firmware" => array("name" => __("Firmware", __FILE__), "type" => "info", "subtype" => "string", "xpath" => "//info/firmware", "order" => 0),
				"serverversion" => array("name" => __("Version Serveur", __FILE__), "type" => "info", "subtype" => "string", "xpath" => "//info/serverversion", "filter" => ["usecustomcgx" => 1], "order" => 1),
				"status" => array("name" => __("Statut", __FILE__), "type" => "info", "subtype" => "binary", "order" => 2),
				"alarme" => array("name" => __("Alarme", __FILE__), "type" => "info", "subtype" => "binary", "visible" => 0, "xpath" => "//info/alarme", "dashboard" => "alert", "mobile" => "alert", "filter" => ["usecustomcgx" => 1, "screen" => 1], "order" => 3),
				"alarmeon" => array("name" => __("Alarme On", __FILE__), "type" => "action", "subtype" => "other", "value" => "alarme", "dashboard" => "alert", "mobile" => "alert", "filter" => ["usecustomcgx" => 1, "screen" => 1], "order" => 4, "url" => "AJAX.cgx?alarme=ON"),
				"alarmeoff" => array("name" => __("Alarme Off", __FILE__), "type" => "action", "subtype" => "other", "value" => "alarme", "dashboard" => "alert", "mobile" => "alert", "filter" => ["usecustomcgx" => 1, "screen" => 1], "order" => 5, "url" => "AJAX.cgx?alarme=OFF"),
				"tension" => array("name" => __("Tension", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "V", "minValue" => 200, "maxValue" => 260, "xpath" => "//pince/V", "filter" => ["9v" => 1], "order" => 6),
				"spaceleft" => array("name" => __("Espace libre", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "Go", "xpath" => "//info/spaceleft", "filter" => ["usecustomcgx" => 1], "order" => 7),
				"servercgxversion" => array("name" => __("Version CGX Serveur", __FILE__), "type" => "info", "subtype" => "string", "visible" => 0, "xpath" => "//jeedom/cgxversion", "filter" => ["usecustomcgx" => 1], "order" => 8),
				"cgxupdate" => array("name" => __("Mise à jour CGX", __FILE__), "type" => "info", "subtype" => "binary", "visible" => 0, "filter" => ["usecustomcgx" => 1], "order" => 9),
				"docgxupdate" => array("name" => __("Mettre à jour CGX", __FILE__), "type" => "action", "subtype" => "other", "visible" => 0, "filter" => ["usecustomcgx" => 1], "order" => 10)
			),
			"compteur" => array(
				"index" => array("name" => __("Index", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => ["default" => "l", "elec" => "Wh", "cal" => "Wh"], "xpath" => "//impulsion/INDEX#id#", "dashboard" => "tile", "mobile" => "tile", "order" => 0),
				"nbimpulsion" => array("name" => __("Impulsions", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "imp", "xpath" => "//impulsion/PULSE#id#", "dashboard" => "tile", "mobile" => "tile", "filter" => ["usecustomcgx" => 1, "typecompt" => true], "order" => 1),
				"debit" => array("name" => __("Débit", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => ["default" => "l/min", "elec" => "Wh/min", "cal" => "Wh/min"], "xpath" => "//impulsion/DEBIT#id#", "dashboard" => "tile", "mobile" => "tile", "filter" => ["usecustomcgx" => 1, "typecompt" => true], "order" => 2),
				"consoveille" => array("name" => __("Consommation J-1", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => ["default" => "l", "elec" => "Wh", "cal" => "Wh"], "xpath" => "//impulsion/CONSO_VEILLE#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "consumption", "typecompt" => true], "order" => 3),
				"consojour" => array("name" => __("Consommation jour", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => ["default" => "l", "elec" => "Wh", "cal" => "Wh"], "xpath" => "//impulsion/CONSO_JOUR#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "consumption", "typecompt" => true], "order" => 4),
				"coutjour" => array("name" => __("Coût jour", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//impulsion/COUT_JOUR#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "consumption"], "order" => 5),
				"consomois" => array("name" => __("Consommation mois", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => ["default" => "m3", "elec" => "kWh", "cal" => "kWh"], "xpath" => "//impulsion/CONSO_MOIS#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "consumption", "typecompt" => true], "order" => 6),
				"coutmois" => array("name" => __("Coût mois", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//impulsion/COUT_MOIS#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "consumption"], "order" => 7),
				"consoannee" => array("name" => __("Consommation année", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => ["default" => "m3", "elec" => "kWh", "cal" => "kWh"], "xpath" => "//impulsion/CONSO_ANNEE#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "consumption", "typecompt" => true], "order" => 8),
				"coutannee" => array("name" => __("Coût année", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//impulsion/COUT_ANNEE#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "consumption"], "order" => 9),
				"prodveille" => array("name" => __("Production J-1", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => ["default" => "l", "elec" => "Wh", "cal" => "Wh"], "xpath" => "//impulsion/CONSO_VEILLE#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "production", "typecompt" => true], "order" => 3),
				"prodjour" => array("name" => __("Production jour", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => ["default" => "l", "elec" => "Wh", "cal" => "Wh"], "xpath" => "//impulsion/CONSO_JOUR#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "production", "typecompt" => true], "order" => 4),
				"gainjour" => array("name" => __("Gain jour", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//impulsion/COUT_JOUR#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "production"], "order" => 5),
				"prodmois" => array("name" => __("Production mois", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => ["default" => "m3", "elec" => "kWh", "cal" => "kWh"], "xpath" => "//impulsion/CONSO_MOIS#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "production", "typecompt" => true], "order" => 6),
				"gainmois" => array("name" => __("Gain mois", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//impulsion/COUT_MOIS#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "production"], "order" => 7),
				"prodannee" => array("name" => __("Production année", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => ["default" => "m3", "elec" => "kWh", "cal" => "kWh"], "xpath" => "//impulsion/CONSO_ANNEE#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "production", "typecompt" => true], "order" => 8),
				"gainannee" => array("name" => __("Gain année", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//impulsion/COUT_ANNEE#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "comptMeasure" => "production"], "order" => 9)
			),
			"pince" => array(
				"index" => array("name" => __("Index consommation", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//pince/INDEX#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["pinceMeasure" => "consumption"], "order" => 0),
				"injection" => array("name" => __("Index production", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//pince/INJECT#id#", "dashboard" => "line", "mobile" => "line",  "filter" => ["pinceMeasure" => "production"], "order" => 0),
				"intensite" => array("name" => __("Intensité", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "A", "xpath" => "//pince/I#id#", "dashboard" => "line", "mobile" => "line", "order" => 1),
				"puissance" => array("name" => __("Puissance", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "VA", "xpath" => "//pince/PUISSANCE#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1], "order" => 2),
				"consojour" => array("name" => __("Consommation jour", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//pince/CONSO_JOUR#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "pinceMeasure" => "consumption"], "order" => 3),
				"coutjour" => array("name" => __("Coût jour", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//pince/COUT_JOUR#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "pinceMeasure" => "consumption"], "order" => 4),
				"consomois" => array("name" => __("Consommation mois", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//pince/CONSO_MOIS#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "pinceMeasure" => "consumption"], "order" => 5),
				"coutmois" => array("name" => __("Coût mois", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//pince/COUT_MOIS#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "pinceMeasure" => "consumption"], "order" => 6),
				"consoannee" => array("name" => __("Consommation année", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//pince/CONSO_ANNEE#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "pinceMeasure" => "consumption"], "order" => 7),
				"coutannee" => array("name" => __("Coût année", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//pince/COUT_ANNEE#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "pinceMeasure" => "consumption"], "order" => 8),
				"injecjour" => array("name" => __("Production jour", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//pince/INJEC_JOUR#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "pinceMeasure" => "production"], "order" => 3),
				"gainjour" => array("name" => __("Gain jour", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//pince/GAIN_JOUR#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "pinceMeasure" => "production"], "order" => 4),
				"injecmois" => array("name" => __("Production mois", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//pince/INJEC_MOIS#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "pinceMeasure" => "production"], "order" => 5),
				"gainmois" => array("name" => __("Gain mois", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//pince/GAIN_MOIS#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "pinceMeasure" => "production"], "order" => 6),
				"injecannee" => array("name" => __("Production année", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "kWh", "xpath" => "//pince/INJEC_ANNEE#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "pinceMeasure" => "production"], "order" => 7),
				"gainannee" => array("name" => __("Gain année", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "€", "xpath" => "//pince/GAIN_ANNEE#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1, "pinceMeasure" => "production"], "order" => 8),
				"maxjour" => array("name" => __("Puissance max jour", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "A", "xpath" => "//pince/MAX_JOUR#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1], "order" => 9),
				"maxmois" => array("name" => __("Puissance max mois", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "A", "xpath" => "//pince/MAX_MOIS#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1], "order" => 10),
				"maxannee" => array("name" => __("Puissance max année", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "A", "xpath" => "//pince/MAX_ANNEE#id#", "dashboard" => "line", "mobile" => "line", "filter" => ["usecustomcgx" => 1], "order" => 11)
			),
			"bouton" => array(
				"state" => array("name" => __("Etat", __FILE__), "type" => "info", "subtype" => "binary", "xpath" => "//entree/ENTREE#id#")
			),
			"relais" => array(
				"state" => array("name" => __("Etat", __FILE__), "type" => "info", "subtype" => "binary", "visible" => 0, "xpath" => "//relais/RELAIS#id#", "xpathcond" => "//relais1W/RELAIS#id#", "cond" => "#id#>=10", "dashboard" => "prise", "mobile" => "prise", "order" => 0),
				"btn_on" => array("name" => "On", "type" => "action", "subtype" => "other", "value" => "state", "dashboard" => "prise", "mobile" => "prise", "order" => 1, "url" => "RL.cgi?rl#typeId#=ON"),
				"btn_off" => array("name" => "Off", "type" => "action", "subtype" => "other", "value" => "state", "dashboard" => "prise", "mobile" => "prise", "order" => 2, "url" => "RL.cgi?rl#typeId#=OFF"),
				"commute" => array("name" => "Toggle", "type" => "action", "subtype" => "other", "order" => 3, "url" => "RL.cgi?frl=#typeId#")
			),
			"switch" => array(
				"state" => array("name" => __("Etat", __FILE__), "type" => "info", "subtype" => "binary", "visible" => 0, "xpath" => "//switch_virtuel/SWITCH#id#", "dashboard" => "circle", "mobile" => "circle", "order" => 0),
				"btn_on" => array("name" => "On", "type" => "action", "subtype" => "other", "value" => "state", "dashboard" => "circle", "mobile" => "circle", "order" => 1, "url" => "AJAX.cgx?vs#typeId#=ON"),
				"btn_off" => array("name" => "Off", "type" => "action", "subtype" => "other", "value" => "state", "dashboard" => "circle", "mobile" => "circle", "order" => 2, "url" => "AJAX.cgx?vs#typeId#=OFF"),
				"commute" => array("name" => "Toggle", "type" => "action", "subtype" => "other", "order" => 3, "url" => "AJAX.cgx?fvs=#typeId#")
			),
			"sonde" => array(
				"temperature" => array("name" => __("Température", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "°C", "xpath" => "//temp/SONDE#id#", "dashboard" => "tile", "mobile" => "tile", "filter" => ["sondeMeasure" => "temperature"]),
				"humidity" => array("name" => __("Humidité", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "%", "xpath" => "//temp/SONDE#id#", "dashboard" => "tile", "mobile" => "tile", "filter" => ["sondeMeasure" => "humidity"]),
				"luminosity" => array("name" => __("Luminosité", __FILE__), "type" => "info", "subtype" => "numeric", "unite" => "lm", "xpath" => "//temp/SONDE#id#", "dashboard" => "tile", "mobile" => "tile", "filter" => ["sondeMeasure" => "luminosity"])
			),
			"analogique" => array(
				"value" => array("name" => __("Valeur", __FILE__), "type" => "info", "subtype" => "numeric", "xpath" => "//analogique/AD#id#", "unite" => "V", "dashboard" => "tile", "mobile" => "tile")
			),
			"variable" => array(
				"value" => array("name" => __("Valeur", __FILE__), "type" => "info", "subtype" => "numeric", "xpath" => "//variables/VARIABLE#id#", "dashboard" => "tile", "mobile" => "tile")
			)
		);
		return $commands;
	}

	public static function getTypes() {
		$types = array(
			"general" => array("name" => __("Serveur Wes", __FILE__), "HTM" => "", "ignoreCreation" => 1, "alternateimg" => ["type" => "binary", "value" => "screen"]),
			"analogique" => array("name" => __("Capteurs", __FILE__), "logical" => "_N", "HTM" => "RELAIS.HTM", "category" => "automatism", "width" => "112px", "height" => "172px", "xpath" => "//analogique/AD#id#", "maxnumber" => 4, "type" => __("Tension", __FILE__)),
			"compteur" => array("name" => __("Compteurs impulsions", __FILE__), "logical" => "_C", "HTM" => "PULSES.HTM", "width" => "272px", "height" => "332px", "category" => "energy", "xpath" => "//impulsion/INDEX#id#", "maxnumber" => 6, "type" => __("Compteur", __FILE__), "alternateimg" => ["type" => "select", "value" => "typecompt"]),
			"bouton" => array("name" => __("Entrées", __FILE__), "logical" => "_B", "HTM" => "RELAIS.HTM", "category" => "automatism", "width" => "112px", "height" => "172px", "xpath" => "//entree/ENTREE#id#", "maxnumber" => 2, "type" => __("Entrée", __FILE__)),
			"pince" => array("name" => __("Pinces ampèremétriques", __FILE__), "logical" => "_P", "HTM" => "PCEVAL.HTM", "width" => "392px", "height" => "272px", "category" => "energy", "xpath" => "//pince/I#id#", "maxnumber" => 4, "type" => __("Pince", __FILE__), "alternateimg" => ["type" => "select", "value" => "typepince"]),
			"relais" => array("name" => __("Relais", __FILE__), "logical" => "_R", "HTM" => "RELAIS.HTM", "category" => "automatism", "width" => "112px", "height" => "172px", "xpath" => "//relais/RELAIS#id#", "maxnumber" => 2, "type" => __("Relais", __FILE__)),
			"sonde" => array("name" => __("Sondes", __FILE__), "logical" => "_A", "HTM" => "TMP.HTM", "category" => "heating", "width" => "112px", "height" => "172px", "xpath" => "//temp/SONDE#id#", "maxnumber" => 30, "type" => __("Sonde", __FILE__)),
			"switch" => array("name" => __("Switchs virtuels", __FILE__), "logical" => "_S", "HTM" => "RELAIS.HTM", "category" => "automatism", "width" => "112px", "height" => "172px", "xpath" => "//switch_virtuel/SWITCH#id#", "maxnumber" => 24, "type" => __("Switch", __FILE__)),
			"teleinfo" => array("name" => __("Téléinfo", __FILE__), "logical" => "_T", "HTM" => "TICVAL.HTM", "width" => "312px", "height" => "492px", "category" => "energy", "xpath" => "//tic#id#/ADCO", "maxnumber" => 3, "type" => __("TIC", __FILE__), "alternateimg" => ["type" => "select", "value" => "typetic"]),
			"variable" => array("name" => __("Variables", __FILE__), "logical" => "_V", "HTM" => "", "category" => "automatism", "width" => "112px", "height" => "172px", "xpath" => "//variables/VARIABLE#id#", "maxnumber" => 8, "type" => __("Variable", __FILE__)),
		);
		return $types;
	}

	public static function deamon_info() {
		$return = array();
		$return['log'] = '';
		$return['state'] = 'nok';
		$cron = cron::byClassAndFunction(__CLASS__, 'daemon');
		if (is_object($cron) && $cron->running()) {
			$return['state'] = 'ok';
		}
		$return['launchable'] = 'ok';
		return $return;
	}

	public static function deamon_start() {
		self::deamon_stop();
		$deamon_info = self::deamon_info();
		if ($deamon_info['launchable'] != 'ok') {
			throw new Exception(__('Veuillez vérifier la configuration', __FILE__));
		}
		$cron = cron::byClassAndFunction(__CLASS__, 'daemon');
		if (!is_object($cron)) {
			$cron = new cron();
			$cron->setClass(__CLASS__);
			$cron->setFunction('daemon');
			$cron->setEnable(1);
			$cron->setDeamon(1);
			$cron->setTimeout(1440);
			$cron->setSchedule('* * * * *');
			$cron->save();
		}
		$cron->run();
	}

	public static function deamon_stop() {
		$cron = cron::byClassAndFunction(__CLASS__, 'daemon');
		if (is_object($cron)) {
			$cron->halt();
		}
	}

	public static function daemon() {
		$starttime = microtime(true);
		foreach (self::byType(__CLASS__, true) as $eqLogic) {
			if ($eqLogic->getConfiguration('type') == "general") {
				$eqLogic->pull();
			}
		}
		$endtime = microtime(true);
		if ($endtime - $starttime < config::byKey('pollInterval', __CLASS__, 60, true)) {
			usleep(floor((config::byKey('pollInterval', __CLASS__) + $starttime - $endtime) * 1000000));
		}
	}

	public static function checkAndUpdateCGXVersion() {
		$file = dirname(__FILE__) . '/../../resources/DATA_JEEDOM.CGX';
		if (!is_file($file)) {
			throw new Exception(__('Fichier DATA_JEEDOM.CGX introuvable', __FILE__));
		}
		$text = file_get_contents($file);
		preg_match('/<cgxversion>(.*)<\/cgxversion>/', $text, $matches);
		if ($matches) {
			config::save('cgxversion', $matches[1], __CLASS__);
		}
	}

	public function sendFtp($ftpIp, $ftpUser, $ftpPass) {
		log::add(__CLASS__, 'debug', $this->getHumanName() . ' ' . __('Envoi du fichier CGX personnalisé au serveur Wes', __FILE__) . ' : V' . config::byKey('cgxversion', __CLASS__, ''));
		$local_file = dirname(__FILE__) . '/../../resources/DATA_JEEDOM.CGX';
		$connection = ftp_connect($ftpIp);
		if (@ftp_login($connection, $ftpUser, $ftpPass)) {
			log::add(__CLASS__, 'debug', $this->getHumanName() . ' ' . __('Connecté au serveur Wes en FTP', __FILE__));
		} else {
			ftp_close($connection);
			log::add(__CLASS__, 'error', $this->getHumanName() . ' ' . __('Échec de connexion au serveur Wes en FTP', __FILE__));
			return false;
		}
		ftp_pasv($connection, true);
		if (ftp_put($connection, '/DATA_JEEDOM.CGX',  $local_file, FTP_BINARY)) {
			log::add(__CLASS__, 'debug', $this->getHumanName()  . ' ' . __('Fichier CGX correctement transmis au serveur Wes', __FILE__));
			ftp_close($connection);
			return true;
		} else {
			log::add(__CLASS__, 'error', $this->getHumanName() . ' ' . __('Erreur lors de la transmission du fichier CGX au serveur Wes', __FILE__));
			ftp_close($connection);
			return false;
		}
	}

	public function doCGXUpdate() {
		$serverVersion = $this->getCmd('info', 'servercgxversion')->execCmd();
		$localVersion = config::byKey('cgxversion', __CLASS__, '');
		if (version_compare($serverVersion, $localVersion, '<')) {
			$ftpIp = $this->getConfiguration('ip', '');
			$ftpUser = $this->getConfiguration('ftpusername', '');
			$ftpPass = $this->getConfiguration('ftppassword', '');
			if (!empty($ftpIp) && !empty($ftpUser) && !empty($ftpPass)) {
				if ($this->sendFtp($ftpIp, $ftpUser, $ftpPass)) {
					$this->checkAndUpdateCmd('cgxupdate', 0);
				} else {
					$this->checkAndUpdateCmd('cgxupdate', 1);
					message::add(__CLASS__, $this->getHumanName()  . ' ' . __('Mise à jour du fichier CGX Jeedom disponible. Version actuelle', __FILE__) . ' : ' . $serverVersion . ' / ' .  __('Nouvelle version', __FILE__) . ' : ' . $localVersion, '', 'needsCgxUpdate' . $this->getId());
				}
			} else {
				log::add(__CLASS__, 'warning', $this->getHumanName() . ' ' . __('Mise à jour CGX impossible : informations de connexion FTP non renseignées', __FILE__));
				$this->checkAndUpdateCmd('cgxupdate', 1);
				message::add(__CLASS__, $this->getHumanName() . ' ' . __('Mise à jour du fichier CGX Jeedom disponible. Version actuelle', __FILE__) . ' : ' . $serverVersion . ' / ' .  __('Nouvelle version', __FILE__) . ' : ' . $localVersion, '', 'needsCgxUpdate' . $this->getId());
			}
		} else {
			log::add(__CLASS__, 'debug', $this->getHumanName() . ' ' . __('Le fichier CGX sur le serveur est déjà en dernière version', __FILE__));
		}
	}

	public function getReadUrl() {
		$url = 'http://' . $this->getConfiguration('username') . ":" . $this->getConfiguration('password') . '@';
		$url .= $this->getConfiguration('ip');
		if ($this->getConfiguration('port') != '') {
			$url .= ':' . $this->getConfiguration('port');
		}
		$file = 'data.cgx';
		if ($this->getConfiguration('usecustomcgx', 0) == 1) {
			$file = 'data_jeedom.cgx';
		}
		$url .= '/' . $file;
		log::add(__CLASS__, 'debug', $this->getHumanName() . ' http://'  . substr($url, strpos($url, "@") + 1));
		return $url;
	}

	public function execUrl($_logical, $_type, $_typeId = '') {
		$url = 'http://' . $this->getConfiguration('ip');
		if ($this->getConfiguration('port') != '') {
			$url .= ':' . $this->getConfiguration('port');
		}
		$path = '';
		if (isset($this->getListeCommandes()[$_type]) && isset($this->getListeCommandes()[$_type][$_logical])) {
			$cmdArray = $this->getListeCommandes()[$_type][$_logical];
			if (isset($cmdArray['url'])) {
				$path = str_replace('#typeId#', $_typeId, $cmdArray['url']);
			}
		}
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url . '/' . $path);
		curl_setopt($curl, CURLOPT_USERPWD, $this->getConfiguration('username') . ":" . $this->getConfiguration('password'));
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		log::add(__CLASS__, 'debug', $this->getHumanName() . ' ' . $url . '/' . $path);
		$return = curl_exec($curl);
		curl_close($curl);
		if ($return === false) {
			throw new Exception(__("Le serveur Wes n'est pas joignable.", __FILE__));
		}
		usleep(50);
		$this->pull();
		return;
	}

	public function preInsert() {
		$this->setIsEnable(0);
		$this->setIsVisible(0);
		if ($this->getConfiguration('type', '') == '') {
			$this->setConfiguration('type', 'general');
			$this->setCategory('energy', 1);
			$this->setDisplay('width', '232px');
			$this->setDisplay('height', '212px');
		}
	}

	public function postSave() {
		$type = $this->getConfiguration('type');
		foreach ($this->getListeCommandes()[$type] as $logicalId => $details) {
			if (isset($details['filter'])) {
				foreach ($details['filter'] as $param => $value) {
					if ($param == 'usecustomcgx' && $type != 'general') {
						if (eqLogic::byId(substr($this->getLogicalId(), 0, strpos($this->getLogicalId(), "_")))->getConfiguration($param) != $value) {
							continue 2;
						}
					} else if ($this->getConfiguration($param) != $value) {
						continue 2;
					}
				}
			}
			$cmd = $this->getCmd(null, $logicalId);
			if (!is_object($cmd)) {
				log::add(__CLASS__, 'debug', $this->getHumanName() . ' ' . __('Création de la commande', __FILE__) . ' ' . $details['name'] . ' : ' . $logicalId);
				$cmd = (new wescontrolCmd)
					->setName($details['name'])
					->setEqLogic_id($this->getId())
					->setType($details['type'])
					->setSubType($details['subtype'])
					->setLogicalId($logicalId);
				if (isset($details['visible'])) {
					$cmd->setIsVisible($details['visible']);
				}
				if (isset($details['order'])) {
					$cmd->setOrder($details['order']);
				}
				if (isset($details['history'])) {
					$cmd->setIsHistorized($details['history']);
				}
				if (isset($details['unite'])) {
					if (is_array($details['unite'])) {
						$alternateVal = self::getTypes()[$this->getConfiguration('type')]['alternateimg']['value'];
						if (isset($details['unite'][$this->getConfiguration($alternateVal)])) {
							$cmd->setUnite($details['unite'][$this->getConfiguration($alternateVal)]);
						} else {
							$cmd->setUnite($details['unite']['default']);
						}
					} else {
						$cmd->setUnite($details['unite']);
					}
				}
				if (isset($details['calcul'])) {
					$cmd->setConfiguration('calculValueOffset', $details['calcul']);
				}
				if (isset($details['value'])) {
					$cmd->setValue($this->getCmd('info', $details['value'])->getId());
				}
				if (isset($details['dashboard'])) {
					$cmd->setTemplate('dashboard', $details['dashboard']);
				}
				if (isset($details['mobile'])) {
					$cmd->setTemplate('mobile', $details['mobile']);
				}
				if (isset($details['minValue'])) {
					$cmd->setConfiguration('minValue', $details['minValue']);
				}
				if (isset($details['maxValue'])) {
					$cmd->setConfiguration('maxValue', $details['maxValue']);
				}
				$cmd->save();
			}
		}

		if ($type == "general") {
			if ($this->getIsEnable()) {
				if ($this->getConfiguration('ip', '') != '' && $this->getConfiguration('username', '') != '' && $this->getConfiguration('password', '') != '') {
					log::add(__CLASS__, 'debug', $this->getHumanName() . ' ' . __('Démarrage du démon', __FILE__));
					self::deamon_start();
				}
			} else {
				foreach (self::byType(__CLASS__) as $eqLogic) {
					if ($eqLogic->getConfiguration('type') != "general" && substr($eqLogic->getLogicalId(), 0, strpos($eqLogic->getLogicalId(), "_")) == $this->getId()) {
						$eqLogic->setIsEnable(0)->save();
					}
				}
			}
		}
	}

	public function postUpdate() {
		if ($this->getConfiguration('type') == "general") {
			if ($this->getConfiguration('ip', '') == '' || $this->getConfiguration('username', '') == '' || $this->getConfiguration('password', '') == '') {
				throw new Exception(__('Veuillez renseigner les informations de connexion HTTP pour accéder au serveur Wes.', __FILE__));
			}
			foreach (self::getTypes() as $type => $data) {
				if (!isset($data['ignoreCreation'])) {
					$id = 1;
					while ($id <= $data['maxnumber']) {
						if (!is_object(self::byLogicalId($this->getId() . $data['logical'] . $id, __CLASS__)) && $this->getConfiguration($type . $id, 0) == 1) {
							log::add(__CLASS__, 'debug', $this->getHumanName() . ' ' . __("Création de l'équipement", __FILE__) . ' ' . $data['type'] . ' ' . $id . ' : ' . $this->getId() . $data['logical'] . $id);
							$eqLogic = (new wescontrol)
								->setEqType_name(__CLASS__)
								->setLogicalId($this->getId() . $data['logical'] . $id)
								->setName($data['type'] . ' ' . $id . ' (' . $this->getName() . ')')
								->setConfiguration('type', $type)
								->setConfiguration('ip', $this->getConfiguration('ip'))
								->setConfiguration('username', $this->getConfiguration('username'))
								->setConfiguration('password', $this->getConfiguration('password'))
								->setConfiguration('port', $this->getConfiguration('port', ''))
								->setCategory($data['category'], 1);
							$eqLogic->setDisplay('width', $data['width']);
							$eqLogic->setDisplay('height', $data['height']);
							$eqLogic->save();
						} else if (is_object(self::byLogicalId($this->getId() . $data['logical'] . $id, __CLASS__))) {
							if ($this->getConfiguration($type . $id, 0) == 0) {
								$toRemove = self::byLogicalId($this->getId() . $data['logical'] . $id, __CLASS__);
								log::add(__CLASS__, 'debug', $this->getHumanName() . ' ' . __("Suppression automatique de l'équipement", __FILE__) . ' : ' . $toRemove->getName() . ' ' . $toRemove->getLogicalId());
								$toRemove->remove();
							} else {
								self::byLogicalId($this->getId() . $data['logical'] . $id, __CLASS__)
									->setConfiguration('ip', $this->getConfiguration('ip'))
									->setConfiguration('username', $this->getConfiguration('username'))
									->setConfiguration('password', $this->getConfiguration('password'))
									->save();
							}
						}
						$id++;
					}
				}
			}
		}
	}

	public function preRemove() {
		if ($this->getConfiguration('type') == "general") {
			log::add(__CLASS__, 'debug', $this->getHumanName() . ' ' . __('Suppression du serveur Wes', __FILE__));
			foreach (self::byType(__CLASS__) as $eqLogic) {
				if ($eqLogic->getConfiguration('type') != "general" && substr($eqLogic->getLogicalId(), 0, strpos($eqLogic->getLogicalId(), "_")) == $this->getId()) {
					log::add(__CLASS__, 'debug', $this->getHumanName() . ' ' . __("Suppression automatique de l'équipement", __FILE__) . ' : ' . $eqLogic->getName() . ' '  . $eqLogic->getLogicalId());
					$eqLogic->remove();
				}
			}
		} else {
			$generalEqLogic = eqLogic::byId(substr($this->getLogicalId(), 0, strpos($this->getLogicalId(), "_")));
			$typeId = substr($this->getLogicalId(), strpos($this->getLogicalId(), "_") + 2);
			$generalEqLogic->setConfiguration($this->getConfiguration('type') . $typeId, 0)->save(true);
		}
	}

	public function pull() {
		if ($this->getIsEnable() && $this->getConfiguration('type') == "general") {
			log::add(__CLASS__, 'debug', $this->getHumanName() . ' ' . __('Interrogation du serveur Wes', __FILE__));
			$url = $this->getReadUrl();
			$xml = simpleXML_load_file($url);
			$count = 0;
			while ($xml === false && $count < 3) {
				log::add(__CLASS__, 'warning', $this->getHumanName() . ' ' . __('Tentative échouée, nouvelle interrogation du serveur Wes', __FILE__));
				$xml = simpleXML_load_file($url);
				$count++;
			}
			if ($xml === false) {
				$this->checkAndUpdateCmd('status', 0);
				log::add(__CLASS__, 'error', $this->getHumanName() . ' ' . __("Le serveur Wes n'est pas joignable sur", __FILE__) . ' ' . $url);
				return false;
			}
			$this->checkAndUpdateCmd('status', 1);
			foreach (self::byType(__CLASS__) as $eqLogic) {
				if ($eqLogic->getIsEnable() && ($eqLogic->getId() == $this->getId() || substr($eqLogic->getLogicalId(), 0, strpos($eqLogic->getLogicalId(), "_")) == $this->getId())) {
					$typeId = substr($eqLogic->getLogicalId(), strpos($eqLogic->getLogicalId(), "_") + 2);
					foreach (self::getListeCommandes()[$eqLogic->getConfiguration('type', '')] as $logical => $details) {
						if (isset($details['xpath']) && $details['xpath'] != '') {
							$xpath = $details['xpath'];
							if (isset($details['cond'])) {
								$cond = str_replace('#id#', $typeId, $details['cond']);
								$test = eval("return " . $cond . ";");
								if ($test) {
									$xpath = $details['xpathcond'];
								}
							}
							$xpathModele = str_replace('#id#', $typeId, $xpath);
							$status = $xml->xpath($xpathModele);
							$value = (string) $status[0];
							if (count($status) != 0) {
								if ($eqLogic->getConfiguration('type', '') == 'relais' && $logical == 'state') {
									$value = ($value == 'ON') ? 1 : 0;
								}
								if ($eqLogic->getConfiguration('type', '') == 'general' && $logical == 'servercgxversion' && $eqLogic->getConfiguration('usecustomcgx', 0) == 1) {
									if (version_compare($value, config::byKey('cgxversion', __CLASS__, ''), '<')) {
										if ($eqLogic->getConfiguration('autoupdatecgx', 0) == 1) {
											log::add(__CLASS__, 'debug', $this->getHumanName() . ' ' . __('Tentative de mise à jour automatique du fichier CGX', __FILE__));
											$eqLogic->doCGXUpdate();
										} else {
											$eqLogic->checkAndUpdateCmd('cgxupdate', 1);
											message::add(__CLASS__, $eqLogic->getHumanName() . ' ' . __('Mise à jour du fichier CGX Jeedom disponible. Version actuelle', __FILE__) . ' : ' . $value . ' / ' .  __('Nouvelle version.', __FILE__) . ' : ' . config::byKey('cgxversion', __CLASS__, ''), '', 'needsCgxUpdate' . $eqLogic->getId());
										}
									} else {
										$eqLogic->checkAndUpdateCmd('cgxupdate', 0);
									}
								}
								$eqLogic->checkAndUpdateCmd($logical, $value);
							}
						}
					}
				}
			}
			log::add(__CLASS__, 'debug', $this->getHumanName() . ' ' . __("Fin d'interrogation du serveur Wes", __FILE__));
		}
	}
}

class wescontrolCmd extends cmd {

	public function execute($_options = null) {
		$eqLogic = $this->getEqLogic();
		if (!is_object($eqLogic) || $eqLogic->getIsEnable() != 1) {
			throw new Exception(__("Équipement désactivé, impossible d'exécuter la commande", __FILE__) . ' : ' . $this->getHumaName());
		}
		log::add('wescontrol', 'debug', $eqLogic->getHumanName() . ' ' . __('Exécution de la commande.', __FILE__) . ' ' . $this->getName());
		$wesEqLogic = eqLogic::byId(substr($eqLogic->getLogicalId(), 0, strpos($eqLogic->getLogicalId(), "_")));
		$typeId = substr($eqLogic->getLogicalId(), strpos($eqLogic->getLogicalId(), "_") + 2);
		if ($eqLogic->getConfiguration('type') == 'general') {
			if ($this->getLogicalId() == 'docgxupdate') {
				log::add('wescontrol', 'debug', $eqLogic->getHumanName() . ' ' . __('Tentative de mise à jour manuelle du fichier CGX', __FILE__));
				$eqLogic->doCGXUpdate();
			} else {
				$eqLogic->execUrl($this->getLogicalId(), 'general', $typeId);
			}
		} else {
			$wesEqLogic->execUrl($this->getLogicalId(), $eqLogic->getConfiguration('type'), $typeId);
		}
		return;
	}
}
