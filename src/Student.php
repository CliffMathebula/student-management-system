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
     * Create new student
     *
     * @param array $data
     * @return object|null
     */
    public static function create(array $data)
    {
        if (!self::exists($data['id'])) {
            file_put_contents(self::getPath($data['id'], "{$data['id']}.json"), json_encode([
                'id' => $data['id'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'age' => $data['age'],
                'curriculm' => $data['curriculm']
            ]));

            return self::find($data['id']);
        }

        return null;
    }

    /**
     * Update user
     *
     * @param array $data
     * @return object|null
     */
    public static function update(array $data)
    {
        if (self::exists($data['id'])) {
            self::delete($data['id']);
            return self::create($data);
        }

        return null;
    }

    /**
     * Delete student using id
     *
     * @param string $id
     * @return bool
     */
    public static function delete(string $id)
    {
        if (self::exists($id)) {
            return unlink(self::getPath($id, "{$id}.json"));
        }

        return false;
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

