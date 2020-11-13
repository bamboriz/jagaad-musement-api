# JAGAAD MUSEMENT API
This is an API design test for JAGAAD. Code is build with PHP 7.4 and powered by Symfony 5.1.
## Running locally:
To run this locally, you just need Docker installed.
- cd into project directory and run "docker-compose up -d" to spin up a container
- Access Container CLI via Docker app or by running "docker-exec -it"
- Start up local server by running "symfony server:start -d"
```sh
$ docker-compose up -d"
$ docker-exec -it
$ symfony server:start -d
```
## Step 1 | Development
The objective here was to build a service that gets the list of the cities from Musement's API
for each city gets the forecast for the next 2 days using http://api.weatherapi.com
```sh
$ php bin/console city:daily-forecasts
```
Sample Output:
Processed city Flagstaff | Partly cloudy - Partly cloudy
Processed city Denver | Partly cloudy - Patchy rain possible
Processed city Dallas | Patchy rain possible - Patchy rain possible
Processed city Charleston | Patchy rain possible - Partly cloudy

## Step 2 | API design
In designing the endpoint, my objective was to keep the number of enpoints as minimal as possible to development and maintenance fairly easy.

Assumption: Only Forecasts for 7 days are available (includes current day)
### Endpoint to set the forecast for a specific city

> PUT: api/v3/cities/{id}/forecasts/{day}
```json
"summary": "set the forecast for a specific city and specific day",
"possible_responses": {
             "204": {"description": "Returned when successful"},
             "403": {"description": "Returned when day value is not permitted"},
             "404": {"description": "Returned when city resoure is not found"}
            }
```
> GET api/v3/cities/{id}/forecasts?day={day}
```json
"summary": "set the forecast for a specific city and specific day",
"possible_responses": {
             "200": {"description": "Returned when successful"},
             "403": {"description": "Returned when day value is not permitted"},
             "404": {"description": "Returned when city resoure is not found"}
            }
```
### Sample API calls
> Weather in Amsterdam today (Friday) : api/v3/cities/{57}/forecasts?day=1
> Weather in Paris tomorrow (Saturday) : api/v3/cities/{57}/forecasts?day=1
> Weather in Paris on Sunday: api/v3/cities/{57}/forecasts?day=3

## Running Tests
Tests wriiten with help of php-unit and can be run with the following command.
```sh
$ php bin/phpunit -v
```
