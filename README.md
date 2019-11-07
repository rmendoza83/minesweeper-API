# minesweeper-API
Minesweeper Game using PHP framework Laravel/Lumen as backend and Angular 8 as frontend

[Testing server](https://minesweeper.sophie-ware.com/)

## The Game
Develop the classic game of [Minesweeper](https://en.wikipedia.org/wiki/Minesweeper_(video_game))

## API Routes Definition
Related to the game
* POST /api/game      - Create a new game.
* GET  /api/game/{id} - Get an existing game {id}.
* POST /api/game/{id} - Process a play on existing game {id}.
* PUT  /api/game/{id} - Process a flag play on existing game {id}.

Related to the user
* POST /api/user      - Get or Create a new user.
* PUT  /api/user/{id} - Update an existing user {id}.


## Decisions taken
* SQLite is the database used for this application.
* I used recursion on the logic to reveal the cells.
* I used my own server to deploy the test application.
* I had to enabled CORS on the backend to give support to angular on the frontend.

## Notes:
* The backend is working 100%, also the frontend doesn't.
* The logic applied to reveal cells is not working properly, maybe needs more review to fix it.
* The frontend don't have all the conditions implemented, you can load, create and play using the angular client but maybe the UI is not too much intuitive.
* The documentation inside the code is not full completed, so in the commits you can see more descriptions about the classes and all the code related.

## Contact:
* Reinaldo Mendoza - rmendoza83@gmail.com