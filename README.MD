# Web App TOUTATIX

## Table des matières

1. **Contexte**
2. **La demande : API "Astérix VS Obélix"**
3. **Livrables**
    - Maquettes
4. **Les contraintes**
5. **Les ressources**
    - Effectifs
    - Bibliothèques / Frameworks
    - IDE / Softs

---

## Contexte

Dans le cadre du dernier module web, et en anticipation du module de Machine Learning, nous vous proposons la réalisation d'un projet de groupe mettant en œuvre les compétences acquises tout au long de l'année. Ce projet consistera en une application web cliente de l'API "Toutatix", dont les spécifications ont été définies précédemment.

## La demande : API "Astérix VS Obélix"

L'objectif est de réaliser une application web cliente de l'API "Toutatix". Cette API, développée en PHP, utilise un modèle de "Machine-Learning" sur TensorFlow pour distinguer des images entre Astérix et Obélix. L'API propose plusieurs cas d'utilisation :

### API publique

#### Use Case 1: Faire une prédiction (guess) + Feedback
- Un utilisateur public peut poster une image à l'API.
- L'API retourne la prédiction (Astérix / Obélix) et un ID pour cette prédiction.
- L'utilisateur peut fournir un feedback sur la prédiction.

#### Use Case 2: Connexion
- Pour accéder aux méthodes protégées, l'utilisateur doit se connecter et récupérer un token via la méthode de login.

### API protégée

#### Use Case 2 : Historique & Extraction
- Récupération de l'historique de toutes les prédictions avec les feedbacks.
- Possibilité de télécharger toutes les images des prédictions classées par sujet et par validité de prédiction.

#### Use Case 3 : Réinitialisation
- Route accessible uniquement à l'administrateur pour supprimer tout l'historique et toutes les images postées.

## Livrables

Pour ce mini-projet, vous devrez fournir deux livrables :
- Des maquettes d'écran (Mockup)
- Le client web déployé (pages HTML/CSS/JS)

## Les contraintes

### Délais
- Maquettes attendues pour le 21 mai (Groupe 1) et 28 mai (Groupe 2)
- Présentation du projet le 18 juin.

### Contraintes techniques
- Compatibilité multi-support (Responsive)
- Fonctionnement asynchrone
- Fonctionnalité sur navigateur web (Desktop et Mobile)
- Utilisation de la caméra du périphérique mobile.

## Les ressources

### Effectifs
Les groupes de travail seront constitués de 4 personnes, répartissant les tâches en fonction des compétences et des groupes TP.

### Bibliothèques / Frameworks
Outre les technologies de base (HTML/CSS/JS), l'utilisation de Frameworks et Bibliothèques est libre. Bootstrap, WebcamJS pour la capture photo, et Chart.JS pour les graphes sont recommandés.

### IDE / Softs
L'utilisation d'IDE est libre, mais VSCode est recommandé. Postman ou des outils similaires sont conseillés pour tester les requêtes sur l'API.

---

*Auteur: Emilien MICARD*
*Projet WEB 3 : Application Web Avancée*
*Cahier Des Charges : Web App TOUTATIX*
*2024*