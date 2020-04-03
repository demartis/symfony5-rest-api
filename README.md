# Symfony 5 REST API skeleton
Symfony 5 + FOSRestBundle + JSON Standard responses + working example


## Table of Contents
+ [About](#about)
+ [Getting Started](#getting_started)
+ [Contributing](#contributing)



## About <a name = "about"></a>
Symfony 5 skeleton to build REST APIs, inclusive of:

- FOSRestBundle (friendsofsymfony/rest-bundle) to simplify the entire process
- Hateoas Bundle (willdurand/hateoas-bundle) that specifies relation types for Web links


This project is compliant with:
- [Symfony Best Practices](https://symfony.com/doc/current/best_practices.html)
- [HATEOAS](https://restfulapi.net/hateoas/), [RFC5988 (web links)](https://tools.ietf.org/html/rfc5988), [JSON HAL Model](http://stateless.co/hal_specification.html)


## Getting Started <a name = "getting_started"></a>

These instructions will get you a copy of the project up and running on your local machine 
for development and testing purposes. See [deployment](#deployment) for notes on how to deploy
the project on a live system.

### Prerequisites

What things you need to install the software and how to install them.
- PHP 7.2.5+
- [composer](https://getcomposer.org/download/)
- [symfony](https://symfony.com/doc/current/setup.html)

### Installing

```bash
git clone https://github.com/demartis/symfony5-rest-api/
cd symfony5-rest-api
cp .env.dist .env
>> edit .env if needed
composer install
symfony server:start
```

### Running the example

#### Install database
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

#### Get with Curl

```bash
curl -H 'content-type: application/json' -v -X GET http://127.0.0.1:8000/books
curl -H 'content-type: application/json' -v -X GET http://127.0.0.1:8000/books/2 
```


## Contributing <a name = "contributing"></a>

1. Fork it (<https://github.com/demartis/symfony5-rest-api/fork>)
2. Create your feature branch (`git checkout -b feature/fooBar`)
3. Commit your changes (`git commit -am 'Add some fooBar'`)
4. Push to the branch (`git push origin feature/fooBar`)
5. Create a new Pull Request

