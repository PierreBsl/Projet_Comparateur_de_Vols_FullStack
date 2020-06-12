# Projet CIR2 Groupe 10
Membres du groupe : Eloi ANSELMET, Pierre BOISLEVE, Hugo MERLE, Tristan ROUX

# Cadre du projet :
- Projet de fin d'année 2019/2020 de la formation CIR de la deuxième promotion de l'ISEN Yncrea Ouest - Site de Nantes - Carquefou 44470
- Objectif du projet : créer / simuler un site de réservation de billets d'avion
- Version des outils utilisés:
    - Serveur : RedHat (AWS)
    - Postgresql : 9.2.24
    - Apache2 : 2.4.43

# Architecture du système :
- Présence d'une base de données regroupant les vols, les villes, les taxes, les prix, les commandes et les clients
- Le projet a été entièrement développé en PHP et SQL pour la partie serveur et en HTML, CSS (Utilisation de Bootstrap) et JS pour la partie client.
# Liste des fonctionnalitées : 
- Depuis la page index (page de recherche de vol): 
    - Entrer les paramètres de sa recherche 
    - Si l'aéroport de départ ou d'arrivée n'existe pas, retourne une erreur à l'utilisateur
    - Si il n'y a pas de vol disponible pour cette route, retourne une erreur à l'utilisateur
    - Si l'utilisateur inscrit plus de 9 personnes, retourne une erreur à l'utilisateur
    - Enfin, si tout les paramètres sont bons, et qu'il y a des vols, renvoie l'utilisateur sur la page d'affichage des vols 
- Depuis la page affichageVol (page d'affichage des résultats de la recherche) :
    - Classer cette liste des vols en ordre croissant ou décroissant.
    - Choisir le prix maximum à afficher à l'aide de la réglette.
    - Voir les vols disponibles les jours suivants et précédents à l'aide des flèches
    - Revenir à la page de recherche breadcrumb
    - Sélectionner un vol parmi la liste afin de passer à la confirmation
- Depuis la page confirmationVol (page de confirmation du vol choisi dans la page précédente)
    - Entrer le nom, prénom, adresse mail, date de naissance et nombre de bagages en soute pour chaque passager adulte
    - Entrer le nom, prénom, date de naissance et nombre de bagages en soute pour chaque passager enfant
    - Affichage dynamique du trajet sur une carte
    - Possibilité de revenir à la liste des vols précédents
    - Valider son choix avec le bouton valider
- Après avoir validé ces choix : 
    - Récapitulatif de la commande personne par personne
    - Prix total du billet et prix par enfant et adulte
    - Possibilité de valider ou d'annuler la commande avec 2 boutons
    - Si la commande est validée, elle ira dans la base de donnée des vols et l'utilisateur sera renvoyé à l'index
- Menu utilisateur : 
    - L'utilisateur peut se connecter avec son adresse mail et sa date de naissance,
    - Il verra toutes les commandes qu'il a effectué 
    - L'utilisateur peut annuler ses réservations et celles de ces enfants 
- Menu administrateur : 
    - L'administrateur peut voir la liste de tout les vols ayant été réservé sur le site, voir les mails et les dates de naissances des utilisateurs
    - L'administrateur peut annuler n'importe quel billet
    