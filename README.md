# Installation

1. clone this repository via git
```shell
git clone https://github.com/razielin/usergroups
```
2. Then install the application via docker-compose
```shell
cd usergroups
docker-compose up -d --build
```
3. Run the application via its CLI interface
```shell
docker exec -it usergroups_user_groups_cli_1 php bin/console app:cli
```
For the first run, MySQL database requires about 20 seconds to initialize.
So if you get an API error, try again after few seconds.

# Usage
Type `help` or press Enter to list all available command names.
Type a command name and follow instructions.