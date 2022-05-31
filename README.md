# Suspicious Reading Detector

This code is the technical assessment solution for a backend position at Acme Electric Inc. This code is no longer maintained. 
This README tries to explain the work that has been done.

## Run or test something

This will give you a docker container up and running:
```
docker compose up -d --build
```

Execute the tests inside the running container:
```
docker compose exec srd vendor/bin/phpunit
```

Execute the command inside the container detecting suspicious readings in CSV file:
```
docker compose exec srd src/Application.php app:detect-suspicious-readings data/2016-readings.csv
```

```
Suspicious Reading Detector
===========================

Client | Month | Suspicious | Median
583ef6329d7b9 | Sep | 3564 | 42997
583ef6329d89b | Sep | 162078 | 38951
583ef6329d89b | Oct | 7759 | 38951
583ef6329d89b | Nov | 60952 | 38951
583ef6329d916 | Jul | 40223 | 21798
583ef6329d916 | Aug | 41512 | 21798
583ef6329d916 | Sep | 2479 | 21798
583ef6329d916 | Oct | 41334 | 21798
583ef6329d916 | Nov | 42664 | 21798
583ef6329d916 | Dec | 40179 | 21798
583ef6329d954 | Jan | 43968 | 21668
583ef6329d954 | Feb | 40389 | 21668
583ef6329d954 | Mar | 42994 | 21668
583ef6329d954 | Apr | 42569 | 21668

=======================================
Resource URI: data/2016-readings.csv
Suspicious readings Total: 14
```

Execute the command inside the container detecting suspicious readings in XML file:
```
docker compose exec srd src/Application.php app:detect-suspicious-readings data/2016-readings.xml
```

```
Suspicious Reading Detector
===========================

Client | Month | Suspicious | Median
583ef6329e237 | Nov | 1379 | 21590
583ef6329e271 | Oct | 121208 | 30807
583ef6329e2e2 | Aug | 52394 | 31260
583ef6329e2e2 | Sep | 55005 | 31260
583ef6329e2e2 | Oct | 56055 | 31260
583ef6329e2e2 | Nov | 55453 | 31260
583ef6329e2e2 | Dec | 53315 | 31260
583ef6329e3ab | Nov | 6440 | 27899
583ef6329e3ab | Jan | 50902 | 27899
583ef6329e3ab | Feb | 53606 | 27899
583ef6329e3ab | Mar | 52789 | 27899

=======================================
Resource URI: data/2016-readings.xml
Suspicious readings Total: 11
```

## Assessment Requirements

The literal instructions about the assessment are included in the last section of this README. This is a list with the 
details of the main requirements:

1. CLI application
2. Hexagonal Architecture
3. Automated tests
4. Git
5. Docker
6. Languages: **PHP**, Python or Java

## Language

I have chosen PHP, using some symfony components.

## Architecture (Hexagonal)

Although I wouldn't choose that architecture for an application of this nature I had implemented it as Hexagonal due 
to the requirements.
There are the following layers:

- domain
- application
- infrastructure

![Diagram](doc/img/diagram.png "Diagram")

The idea was to implement the logic in the domain layer. The Client Entity/Model has the method detectSuspiciousReadings 
which detects the suspicious readings in himself. There are several port Interfaces to "interact" with the domain layer:

1. *InputPortInterface* to setParams and launch the execution of the use case.
2. *ClientRepositoryInterface* to obtain data from the infrastructure layer
3. *ClientRepositoryFactoryInterface* to obtain an instance of ClientRepositoryInterface

For the application layer the idea was to use the symfony/console component which has 
injected the inputPortInterface.

The infrastructure layer implements two ClientRepositoryInterface, one of them to obtain data from CSV files and another 
to obtain data from XML files. This layer also implements the factory ClientRepositoryFactoryInterface which knows the 
repository implementations and provides the proper repository instance based on file extension (.csv or .xml) in the uri
passed to the factory.

## About Docker

This project uses a two stages Dockerfile.

## About Git

Normally I use Gitflow as strategy, Conventional commit messages and atomic commits. You can check another projects in 
my public GitHub profiles if you are looking for examples. ~~Due to the lack of time this is going to be committed as an 
only commit.~~ Additional commits has been made to have a functional project.

## About tests

This project has implemented the following Unit Tests

```
Client (GonzaloRodriguez\SuspiciousReadingDetector\Tests\Client)
 ✔ Client with one suspicious lower reading
 ✔ Client without suspicious readings
 ✔ Client with two suspicious readings higher and lower

Detect Suspicious Readings From Resource Use Case
 ✔ Detect suspicious readings in two clients

Median Calculator (GonzaloRodriguez\SuspiciousReadingDetector\Tests\MedianCalculator)
 ✔ Calculate median for array with odd elements number
 ✔ Calculate median for array with even elements number

```


## Instructions

```
At Acme Electric Inc. we are worried about fraud in electricity readings and we have decided to implement a suspicious reading detector. 

Some clients have phoned us suspecting some squatters have been tapping into their electricity lines and this is why you may find some extremely high readings compared to their regular usage.
At the same time, we suspect some clients are tapping their building electricity lines and you may also find extremely low readings.

As we all know, many systems in Spain are a bit old fashioned and get some readings in XML and some others in CSV, so we need to be able to implement adaptors for both inputs.

For this first iteration, we will try to identify readings that are either higher or lower than the annual median ± 50%.

Please write a command line application that takes a file name as an argument (such as 2016-readings.xml or 2016-readings.csv) and outputs a table with the suspicious readings:

| Client              | Month              | Suspicious         | Median
 -------------------------------------------------------------------------------
| <clientid>          | <month>            | <reading>          | <median>

You can assume there are no tricks in the XML and CSV files. Each client will have 12 readings and you get all 12 consecutively. Please don't spend time trying to validate all this although it happens in real life sometimes!

In this exercise, we are looking for things like:

   - Hexagonal architecture to handle different inputs (CSV and XML in this case, but it could be a database or even a txt file in a remote FTP! True story...)

 Bonus points if you use:
   - Idiomatic features of the language
   - Automated tests
   - Git
   - Docker or similar

The solution can be written in any of our stack languages: PHP, Python or Java.

You can use any external library or language version :)
```