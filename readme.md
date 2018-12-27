# Task Manager

Task manager developed with Laravel framework.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See running for to know how to run the project on your machine.

### Prerequisites

To run this application, you will need to have [Docker](https://www.docker.com/) installed on your machine. Make sure that ports **80** and **3306** are **not being used** the moment the containers are uploaded.

### Running

With Docker installed on your machine, clone the GitHub project:

```
git clone https://github.com/rafaelfilholm/task-manager-laravel
```

Access the project folder via the terminal:

```
cd task-manager-laravel/
```

Grant execution permission to the script that will upload the containers, create the databases and migrate the tables:

```
sudo chmod +x ./linux-run.sh
```

Finally, run the script:

```
./linux-run.sh
```

Great! If everything is running fine, the application will already be running at [http://localhost/](http://localhost/).

## Api Documentation

To view the api documentation, with the active containers, go to [http://localhost/api/documentation](http://localhost/api/documentation).

## Running the tests

To run the automated tests written for this application, you will use the command:

```
docker exec -it task-manager-app ./vendor/bin/phpunit --color
```

or

```
./docker-phpunit.sh
```

Remember to grant execute permission also for this script.


## Built With

* [Docker](https://www.docker.com/) - Used to automatize the running and deploy
* [Laravel](https://laravel.com) - The web framework used
* [MySQL](https://www.mysql.com/) - DBMS used
* [Swagger](https://swagger.io/) - Dependency used to generate the API documentation

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## Authors

* **Rafael Laurindo** - [Website](https://rafaellaurindo.com.br/)

## License

This project is licensed under the MIT License.

## Acknowledgments

* The commits used pattern can be seen in more detail in [this link](https://github.com/rafaelfilholm/fluxo-trabalho/blob/master/desenvolvimento/git-flow.md).