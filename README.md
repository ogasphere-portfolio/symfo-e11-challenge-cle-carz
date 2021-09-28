# Challenge Entité/Form

> :hand: Commandes du Maker autorisées : `make:controller`, `make:entity`, `make:form`.
> 
> :hand: Mais vous pouvez choisir de le faire sans le Maker :wink: (Documentation Symfony autorisée).

## 1. Entité Voiture

- Créer une entité `Car` avec quelques propriétés (`string $model`, `int $year`).
- Créer une page qui affiche la liste des voitures, avec ses propriétés.
- Créer un formulaire pour ajouter une voiture.
  - Ajouter les contraintes de validation, les tester.
  - Rediriger vers la liste.
- Ajouter quelques modèles de voiture.

## 2. Entité Marque

> :bulb: Attention ici au piège de la migration avec le _non null_ sur la relation, avec des données existantes => autoriser le NULL pour plus de facilité.

- Créer une entité `Brand`
- Relier les entités `Car` et `Brand`.
  - Une voiture n'appartient qu'à une seule marque.
  - Une marque peut avoir plusieurs voitures.
- Ajouter la relation au formulaire de création de voiture.
- Afficher la marque dans la liste des voitures.

> :hand: Si Adminer ou Symfony vous crie dessus à cause des contraintes de clés étrangères à l'ajout de la relation Car/Brand, supprimez-les données de votre table `car`. Mais vous devrez enlever à la main ce que la migration a effectué.

Si tout est OK et si nécessaire, faire en sorte qu'une voiture ne puisse pas exister sans marque associée.

## 3. Bonus au choix (pas de panique si vous ne les faites pas)

- Créer le formulaire d'édition de voiture.
- Suppression d'une voiture en méthode HTTP DELETE.
- Afficher les voitures par marque (lien sur une marque de voiture => affiche toutes les voitures de cette marque).
- Créer une requête custom avec jointure pour optimiser les requêtes de la liste des voitures.
- Créer des fixtures.
