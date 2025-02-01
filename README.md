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
