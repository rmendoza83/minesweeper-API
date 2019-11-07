import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { UserModel } from '../models/user-model';

import { NewGameModel } from '../models/newgame-model';
import { CONSTANTS } from '../constants/constants';
import { IAPIResponse } from '../models/interfaces/api-response-interface';
import { API_RESPONSE } from '../constants/api-response';
import { GameModel } from '../models/game-model';
import { PlayModel } from '../models/play-model';

@Component({
  selector: 'app-game',
  templateUrl: './game.component.html',
  styleUrls: ['./game.component.css']
})
export class GameComponent {
  private userModel: UserModel = null;
  private newGameModel: NewGameModel = null;
  private playModel: PlayModel = null;
  rows: number = 8;
  cols: number = 8;
  mines: number = 10;
  gameId: number = null;
  game: GameModel = null;
  gameLoaded: boolean = false;

  constructor (
    private http: HttpClient,
    private router: Router
  ) {
    this.userModel = JSON.parse(localStorage.getItem('User'));
    this.newGameModel = new NewGameModel();
    this.playModel = new PlayModel();
  }

  onNewGame() {
    this.newGameModel.id_user = this.userModel.id;
    this.newGameModel.rows = this.rows;
    this.newGameModel.cols = this.cols;
    this.newGameModel.mines = this.mines;
    this.http.post(CONSTANTS.SERVER_URL + 'game', this.newGameModel)
      .subscribe((response: IAPIResponse) => {
        if (response.statusCode == API_RESPONSE.OK) {
          this.game = response.data as GameModel;
          this.game.board = JSON.parse(response.data.board);
          this.gameLoaded = true;
        } else {
          this.gameLoaded = false;
        }
      });
  }

  onLoadGame() {
    this.http.get(CONSTANTS.SERVER_URL + 'game/' + this.gameId)
      .subscribe((response: IAPIResponse) => {
        if (response.statusCode == API_RESPONSE.OK) {
          this.game = response.data as GameModel;
          this.game.board = JSON.parse(response.data.board);
          this.gameLoaded = true;
        } else {
          this.gameLoaded = false;
        }
      });
  }

  onCellClick(row, col) {
    this.playModel.row = row;
    this.playModel.col = col;
    this.http.post(CONSTANTS.SERVER_URL + 'game/' + this.game.id, this.playModel)
      .subscribe((response: IAPIResponse) => {
        if (response.statusCode == API_RESPONSE.OK) {
          this.game = response.data as GameModel;
          this.game.board = JSON.parse(response.data.board);
          console.log(this.game);
          // Checking If the User Lost or Win
        }
      });
  }

}
