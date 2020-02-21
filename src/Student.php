<?php

namespace ManagementSystem;

use Exception;

class Student
{
    /**
     * Find student
     *
     * @param string $id
     * @throws Exception
     * @return object
     */
    public static function find(string $id) : object
    {
        if (self::exists($id)) {
            return json_decode(file_get_contents(self::getPath($id, "{$id}.json")));
        }

        throw new Exception("Could not find student with the ID \"{$id}\"");
    }

    /**
     * Check if student exists
     *
     * @param string $id
     * @return bool
     */
    public static function exists(string $id) : bool
    {
        return file_exists(self::getPath($id, "{$id}.json"));
    }

    /**
     * Get student(s) path
     *
     * @param string $id
     * @param string $path
     * @return string
     */
    public static function getPath(string $id, string $path = '') : string
    {
        $folder   = substr($id, 0, 2);
        $students = __DIR__ . "/../students/{$folder}";

        if (!is_dir($students)) mkdir($students, 0777, true);

        return '/' . trim($students, '/') . '/' . trim($path, '/');
    }
}

