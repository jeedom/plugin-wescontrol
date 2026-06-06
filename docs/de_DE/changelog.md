# Changelog Wes Control

>**WICHTIG**
>
>Zur Erinnerung: Wenn keine Informationen zum Update vorhanden sind, handelt es sich nur um die Aktualisierung von Dokumentation, Übersetzung oder Text.

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

# 01.10.2024

- Neue Version der CGX-Datei V1.0.5

- Ajout de "Consommation/Production" à la liste TIC
- Ajout d'une commande "Producteur" *(1 si production activée par Enedis, 0 sinon)*
- Ajout de l'index d'injection *(non remonté si producteur à 0)*
- Ajout de puissance apparente injectée *(non remontée si producteur à 0)*

# 13.12.2022

- Überprüfung der vollen Kompatibilität des Plugins gemäß seiner Version und der Firmware des Wes *(``< V0.84A10`` = Stable-Plugin/ ``>= V0.84A10`` = Beta-Plugin)*
- Ergänzung der Anzeige im Tabellenlayout von Kindergeräten.

# 13.06.2022

- Neue CGX-Dateiversion V1.0.3

# 10.05.2021

- Neue Version der CGX-Datei V1.0.2
- Hinzufügung des Parameters "Art der Messung" für Zähler und TIC
- Hinzufügen von Zählertypen **Kalorien, Strom und Kraftstoff**
- Hinzufügen einer automatischen Aktualisierungsoption und eines Befehls zum Aktualisieren der CGX-Datei sowie einer Schaltfläche zum Aktualisieren aller aktiven Server
- Schnittstellenoptimierung.

# 28.04.2021

- Bereitstellung des Plugins
