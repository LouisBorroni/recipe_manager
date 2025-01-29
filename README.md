Contributeurs :

- Louis BORRONI -> Louis BORRONI sur github
- Léo Limousin -> Léo limousin

Mise en place de l'application:
    Prérequis :
        - docker d'installé sur la machine
        - php avec les extienstions : pdo_mysql, openssl, mbstring,
        - node
    
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
        - (fixtures)
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
        ng serve
