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

# Usage
Type `help` or press Enter to list all available commands