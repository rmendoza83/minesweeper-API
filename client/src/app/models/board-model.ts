import { CellModel } from './cell-model';

export class BoardModel {
  public rows: number;
  public cols: number;
  public mines: number;
  public board: CellModel[][];
}