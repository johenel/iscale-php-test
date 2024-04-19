# Refactor Details

## Configurations
- Added Config file to contain config data.

## Trait
- Added "Instanceable" trait that seemed to be frequently used in different classes

## Services
- Added a database service class that handles database connection and operations

## Models
- Added model interface and model class to handle different resources.
- Model class is also integrated with DatabaseService class in order to easily access and manipulate records of a specific resource.

## Utilities / Repositories
- Added a Manager class (parent) that is integrated with Model class which basically handles the business logic of the application.