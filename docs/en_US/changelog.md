# Changelog Wes Control

>**IMPORTANT**
>
>As a reminder, if there is no information on the update, it is because it only concerns the update of documentation, translation or text.

# 05/06/2026

- Prise en charge des images personnalisées pour les tuiles d'équipements
- Version Jeedom minimale requise : **4.4**

# 01/06/2026

- Correction de la gestion des messages de mise à jour CGX : création, mise à jour et suppression automatique selon l'état réel du serveur Wes

# 25/05/2026

- Nouvelle version du fichier CGX V1.0.6
- Ajout de la prise en charge des variables Modbus *(firmware WES >= V0.9b05)*

# 22/05/2026

- Version de firmware Wes minimale requise : **V0.84A10** *(passer sur la branche less-than-V0.84A10 pour les versions inférieures)*
- Diverses corrections pour Debian 12/PHP 8

# 10/01/2024

- New version of CGX file V1.0.5

- Ajout de "Consommation/Production" à la liste TIC
- Ajout d'une commande "Producteur" *(1 si production activée par Enedis, 0 sinon)*
- Ajout de l'index d'injection *(non remonté si producteur à 0)*
- Ajout de puissance apparente injectée *(non remontée si producteur à 0)*

# 12/13/2022

- Verification of the full compatibility of the plugin according to its version and that of the firmware of the Wes *(``< V0.84A10`` = stable-plugin/ ``>= V0.84A10`` = beta-plugin)*
- Addition of the display in table layout of child equipment.

# 06/13/2022

- New CGX File Version V1.0.3

# 05/10/2021

- New version of CGX file V1.0.2
- Addition of the "Type of measurement" parameter for meters and TIC
- Addition of counter types **Calories, Electricity and Fuel**
- Addition of an automatic update option and a command to update the CGX file as well as a button allowing the update of all active servers
- Interface optimization.

# 04/28/2021

- Provision of the plugin
