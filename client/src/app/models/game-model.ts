import { BoardModel } from './board-model';

export class GameModel {
  public id: number;
  public id_user: number;
  public rows: number;
  public cols: number;
  public mines: number;
  public board: BoardModel;
  public ended: boolean;
  public won: boolean;
  public start_datetime: Date;
  public end_datetime: Date;
}