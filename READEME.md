# ToDoApp - TP Noté du 05/03/2025

## Consigne du TP

[Consigne du projet](documents/TpNote2.pdf)

Ce projet consiste à créer une application de gestion de tâches (To-Do) en utilisant le framework Symfony.

---

## Installation et configuration

1. Clonez le dépôt :

   ```bash
   git clone https://github.com/Alzower/ToDoApp
   ```

2. Accédez au dossier du projet :

   ```bash
   cd ToDoApp
   ```

3. Installez les dépendances :

   ```bash
   composer install
   ```

4. Ouvrez votre serveur MySQL/PostgreSQL et configurez le fichier `.env` en renseignant vos informations de base de données.

5. Exécutez les commandes suivantes pour créer et migrer la base de données :

   ```bash
    php bin/console doctrine:database:create
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
   ```

6. Démarrez le serveur Symfony :
   ```bash
   symfony server:start
   ```

Le projet sera accessible à l'adresse suivante : [http://localhost:8000/task](http://localhost:8000/task)

---
