<?php

namespace ManagementSystem;

class Table
{
    /**
     * Make table
     *
     * @param array $data
     * @param array $columns
     * @param string $table
     */
    public static function make(array $data, array $columns = [], string $table = '')
    {
        foreach ($data as $rowKey => $row) {
            foreach ($row as $cellKey => $cell) {
                $length = strlen($cell);
                if (empty($columns[$cellKey]) || $columns[$cellKey] > $length) {
                    $columns[$cellKey] = $length;
                }
            }
        }

        foreach ($data as $rowKey => $row) {
            foreach ($row as $cellKey => $cell) {
                $table .= str_pad($cell, $columns[$cellKey]) . '   ';
            }

            $table .= PHP_EOL;
        }

        return $table;
    }
}

