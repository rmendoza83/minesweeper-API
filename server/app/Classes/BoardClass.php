<?php

namespace Classes;

use DavidHoeck\LaravelJsonMapper\JsonMapper as JsonMapper;
use Classes\CellClass;

class BoardClass
{
  public $rows;
  public $cols;
  public $mines;
  public $board;

  private function insideBounds($row, $col)
  {
    return ($row >= 0 && $row < $this->rows && $col >= 0 && $col < $this->cols);
  }

  private function revealZeros($row, $col)
  {
    // Checking bounds
    if (!$this->insideBounds($row, $col))
    {
      return;
    }
    // Checking cell and edges
    if (($this->board[$row][$col]->value != '*') && (!$this->board[$row][$col]->revealed))
    {
      $this->board[$row][$col]->revealed = true;
      $this->board[$row][$col]->value = $this->getValue($row, $col);
      for ($i = -1; $i <= 1; $i++)
      {
        for ($j = -1; $j <= 1; $j++)
        {
          $this->revealZeros($row + $i, $col + $j);
        }
      }
    }
  }

  private function getValue($row, $col)
  {
    $c = 0; 
    for ($i = -1; $i <= 1; $i++)
    {
      for ($j = -1; $j <= 1; $j++)
      {
        if ($this->insideBounds($row + $i, $col + $j))
        {
          if ($this->board[$row + $i][$col + $j]->value != '*')
          {
            $c++;
          }
        }
      }
    }
    if ($c == 0)
    {
      return ' ';
    }
    return "$c";
  }

  public function new($prows, $pcols, $pmines)
  {
    $this->rows = $prows;
    $this->cols = $pcols;
    $this->mines = $pmines;
    $this->board = array();
    for ($i = 0; $i < $prows; $i++)
    {
      $this->board[$i] = array();
      for ($j = 0; $j < $pcols; $j++)
      {
        $this->board[$i][$j] = new CellClass;
        $this->board[$i][$j]->row = $i;
        $this->board[$i][$j]->col = $j;
        $this->board[$i][$j]->value = ' ';
        $this->board[$i][$j]->revealed = false;
        $this->board[$i][$j]->isFlag = false;
      }
    }
    //Assigning Mines on random position
    $m = 0;
    while ($m < $pmines)
    {
      $rrow = rand(1, $prows) - 1;
      $rcol = rand(1, $pcols) - 1;
      if ($this->board[$rrow][$rcol]->value != '*')
      {
        $this->board[$rrow][$rcol]->value = '*';
        $m++;
      }
    }
  }

  public function fromJSON($raw)
  {
    $json = json_decode($raw);
    $mapper = new JsonMapper();
    $board = $mapper->map($json, new BoardClass());
    $this->rows = $board->rows;
    $this->cols = $board->cols;
    $this->mines = $board->mines;
    $this->board = $board->board;
  }

  public function play($row, $col)
  {
    if ($this->board[$row][$col]->value != '*')
    {
      if ($this->board[$row][$col]->value != 'f')
      {
        $this->revealZeros($row, $col);
      }
      return true;
    }
    return false;
  }

  public function flag($row, $col)
  {
    if ($this->board[$row][$col]->value != '*')
    {
      if ($this->board[$row][$col]->value != 'f')
      {
        $this->board[$row][$col]->value = 'f';
      }
      else
      {
        $this->board[$row][$col]->value = ' ';
      }
    }
  }

  public function won()
  {
    return false;
  }
}
