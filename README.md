# Krylov Commission task

## Running:

- If you have `docker` and `docker-compose` installed. Start application in container with command `docker-compose up -d` 
- If you have php installed you can skip this step

## Usage 
- To use application you should put `input.csv` file into root folder of project
- and run `docker exec krylov-test-app php script.php input.csv` to get fee
- If you have php installed use command `php script.php input.csv`

## Testing 
- To tun phpunit tests use command `docker exec krylov-test-app composer run test`
- Or with installed php and composer `composer run test`

