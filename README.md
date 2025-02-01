Contributeurs :

- Louis BORRONI -> Louis BORRONI sur github
- Léo Limousin -> Léo limousin

Mise en place de l'application:
Prérequis : - docker d'installé sur la machine - php avec les extienstions : pdo_mysql, openssl, mbstring, - node

    1 - Base de données
        - cd docker
        - docker compose up -d
        - vérifier la connexion au phpMyAdmin sur http://localhost:8895/ utilisateur: root, password: mysqltests

    2 - back
        - cd back
        - composer install
        - php bin/console lexik:jwt:generate-keypair
        - php bin/console d:d:c
        - php bin/console d:m:m 
        - php bin/console doctrine:fixtures:load
    3 - front
        - cd front
        - npm i

Démarrer l'application :
1 - démarrer la base de données :
avoir docker en marche sur son ordi
cd docker
docker compose up -d

    2 - démarrer le back
        cd back
        symfony serve

    3 - démarer le front
        cd front
        ng serve ou npm start
        se créer un compte ou utiliser un compte existant ("user1@example.com" "password123!")

Pour les tests unitaires :
1 - créer une base de tests
avoir docker qui tourne

        dans le .env.test  ajouter la var d'environnement si c'est pas déjà fait : DATABASE_URL="mysql://root:mysqltests@127.0.0.1:3640/recipe_app?serverVersion=9.1.0&charset=utf8mb4"

        php bin/console doctrine:database:create --env=test
        php bin/console doctrine:migrations:migrate --env=test

        dans le fichier phpunit.xml.dist vérifier si  <server name="DATABASE_URL" value="mysql://root:mysqltests@127.0.0.1:3640/recipe_app?serverVersion=9.1.0&amp;charset=utf8mb4" />

    2- Lancer les tests
        php bin/phpunit


Notes pratiques d'utilisation :
    - Lors de la création d'une recette, il est nécessaire d’actualiser la page (F5) pour la voir apparaître. En effet, la mise à jour automatique du store n’a pas encore été implémentée. Cela s’applique également à la mise à jour des recettes. Cependant, le traitement côté back-end fonctionne correctement.
    - Concernant les tests unitaires, je n'ai pas pu en réaliser autant que prévu. J'ai rencontré plusieurs difficultés avec la classe RecipeControllerTest, notamment en raison de la gestion des tokens JWT et de l’incrémentation automatique des IDs des recettes. J’ai tout de même laissé en commentaires les tests partiellement réalisés, bien qu’ils ne soient pas pleinement aboutis.

Ce qu'on aurai aimé faire en plus :
    - Gestion des événements : actuellement, les erreurs sont simplement affichées dans la console avec peu de détails. J’aurais aimé intégrer des notifications (toasts) côté front pour signaler les erreurs ou les succès, en particulier sur les pages d’inscription et de connexion où le retour d’informations est limité. Par manque de temps je n'ai pas pu
    - Fonctionnalité de tri par catégories.
    - Recherche par nom des recettes.
    - Système de "likes" sur les catégories : l’idée était de créer une table de jonction entre les utilisateurs et les recettes, contenant les IDs des deux entités afin de savoir quel utilisateur a liké quelle recette.
