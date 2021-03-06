<?php


namespace App\Service;


class GameService
{
    /**
     * Main method for the game. Records moves and checks for a win
     *
     * @param $coordinates
     * @param $ticField
     * @param int $is_system
     *
     * @return array
     */
    public function recordMove($coordinates, $ticField, $is_system = 0): array
    {
        $field = $ticField->field;
        [$r, $c] = $coordinates;

        if ($field[$r][$c] !== '') {
            return [
                'message' => 'cell is not empty',
                'status' => false,
                'tic' => $ticField,
            ];
        }

        $field[$r][$c] = $is_system ? '-' : '+';
        $ticField->field = $field;

        if ($this->isWinningMove($field, $coordinates, $is_system)) {
            $ticField->save();

            return [
                'message' => 'Game over)',
                'status' => true,
                'tic' => $ticField,
            ];
        }

        if (!$is_system) {
            $this->calcSystemMove($ticField);
        }

        $ticField->save();

        return [
            'message' => 'move was recorded',
            'status' => true,
            'tic' => $ticField,
        ];
    }

    /**
     * Calculates coordinates for a system move.
     *
     * @param $ticField
     * @return bool
     */
    public function calcSystemMove($ticField): bool
    {
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($this->isWinningMove($ticField->field, [$i, $j], 1)) {
                    continue;
                }
                $result = $this->recordMove([$i, $j], $ticField, 1);

                if ($result['status'] === true) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Checks if move leads to win
     *
     * @param $field
     * @param $coordinates
     * @param $is_system
     *
     * @return bool
     */
    public function isWinningMove($field, $coordinates, $is_system): bool
    {
        [$r, $c] = $coordinates;

        $field[$r][$c] = $is_system ? '-' : '+';

        // rows
        foreach ($field as $row) {
            if ($row[0] !== '' and $row[0] === $row[1] and $row[1] === $row[2]) {
                return true;
            }
        }

        //columns
        for ($i = 0; $i < 3; $i++) {
            if ($field[0][$i] !== '' and $field[0][$i] === $field[1][$i] and $field[1][$i] === $field[2][$i]) {
                return true;
            }
        }

        //diagonals
        if ($field[1][1] !== '') {
            if ($field[0][0] === $field[1][1] and $field[1][1] === $field[2][2]) {
                return true;
            }
            if ($field[0][2] === $field[1][1] and $field[1][1] === $field[2][0]) {
                return true;
            }
        }

        return false;
    }
}
