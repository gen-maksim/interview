# Tic-Tac-toe suicide game
### Description

Tic-Tac-Toe is a bad game. It’s so horrible you want to lose. Write a Tic-Tac-Toe that forces your opponent to win. No need for a GUI. Command line interface and ASCII is enough, like
```
X| |
|O|X
O| |
```
You can take moves from input using a board layout as follows:
```
1|2|3
4|5|6
7|8|9
```
Can you write this atrocious Tic-Tac-Toe?
### How it works
Use artisan commands to play   
Available commands:
* `php artisan game:new` - refreshes all games (to finish old game);
* `php artisan game:play {row} {column}` - input row and column to make a move. You will get a result field (system will make a move too);
* `php artisan game:status` - to see if there is a game. You will see a current field.

logic is at [GameService](https://github.com/gen-maksim/interview/blob/master/app/Service/GameService.php) and in app\Console\Commands folder.

## Requirements
* PHP 7.3 (Laravel framework)
* node js, npm
* mysql \ pgsql

## Installation steps
* Clone repository
* Create database
* Create .env from .env.example and update variables
* Run following commands:
  * composer install
  * npm install
  * npm run dev
  * php artisan key:generate
  * php artisan migrate
  * php artisan db:seed
