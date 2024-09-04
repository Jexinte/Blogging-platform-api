# Description

This project is an API allowing users to be able to CRUD posts. It has been made with php without framework the purpose of it was to improve my knowledge about php, THERE IS NO POINT TO FLEX THERE.

# Installation

1 - Clone the repo

2 - Use the package manager [composer](https://getcomposer.org/doc/00-intro.md) to install packages.
```
composer install
```

3 - When grumphp ask you to create a grumphp.yml file , say no and just rename the dist file by removing the keyword "dist". To run grumphp just use the following command :

```
composer g-run
```

4 - Usually phpstan should not ask you to create a file but if you want to just run it , rename the phpstan.neon dist file by removing the keyword "dist" and refer to [phpstan](https://phpstan.org/user-guide/getting-started) for more informations about how run checks 


# Documentation

1 - In order to see the API Documentation, just rename the openapi.dist.yaml by openapi.yaml

2 - A sample of the documentation, you can see it on the entry point 


![Screenshot 2024-09-04 200707](https://github.com/user-attachments/assets/464aa282-3f3f-429b-a619-e9d8824e0318)

# Tests

1 - To run all tests, use the following command :
```
composer all-tests
```

2 - To run a specific test, use this one :
```
./vendor/bin/phpunit tests --filter=nameOfTheTest
```


# PHP Version & Packages

- PHP 8.2
- Grumphp ^2.7
- Phpstan ^1.12
- Phpunit ^11.3
- Php-cs-fixer ^3.63
- Zircote/Swagger-Php ^4.10
- Twig/Twig - ^3.12
- Maria DB - 10.4.10