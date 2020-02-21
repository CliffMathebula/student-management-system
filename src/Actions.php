<?php

namespace ManagementSystem;

class Actions
{
    /**
     * Add student
     *
     * @param string $question
     * @return void
     */
    public static function add(string $question = "Please enter a 7 digit value. This will be the student's ID.")
    {
        $studentID = Question::ask($question ?? "Please enter a 7 digit value. This will be the student's ID.", Validation::IsNumeric);

        if (strlen($studentID) !== 7) return self::add('The ID must be 7 digit long!');
        if (file_exists(__DIR__ . "/../students/{$studentID}.json")) return self::add('The ID is already in use. Please use a diffent one!');

        $firstName = Question::ask("Please enter the student's first name.", Validation::IsString);
        $lastName  = Question::ask("Please enter the student's last name.", Validation::IsString);
        $age       = Question::ask("Please enter the student's age.", Validation::IsNumeric);
        $curriculm = Question::ask("Please enter the student's curriculm.", Validation::IsString);

        $student = Student::create([
            'id' => $studentID,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'age' => $age,
            'curriculm' => $curriculm
        ]);

        echo ($student ? "Successfully added student {$studentID}" : 'Could not add student 😔') . PHP_EOL;
    }

    /**
     * Edit student
     *
     * @param string $studentID
     * @return void
     */
    public static function edit(string $studentID, string $type)
    {
        if (!in_array($type, ['first_name', 'last_name', 'age', 'curriculm'])) {
            echo "\"{$type}\" is not valid. These are the supported types: 'first_name', 'last_name', 'age', 'curriculm'";

            return;
        }

        if (Student::exists($studentID)) {
            $data = (array)Student::find($studentID);

            if (in_array($type, ['first_name', 'last_name', 'curriculm'])) {
                $cleanedType = str_replace('_', ' ', $type);
                $data[$type] = Question::ask("Please enter the student's {$cleanedType}.", Validation::IsString);

                Student::update($data);

                echo "Successfully updated student: {$data['id']}" . PHP_EOL;

                return;
            }

            $data[$type] = Question::ask("Please enter the student's age.", Validation::IsNumeric);

            Student::update($data);

            echo "Successfully updated student: {$data['id']}" . PHP_EOL;

            return;
        }

        echo "Student \"{$studentID}\" does not exist." . PHP_EOL;
    }

    /**
     * Delete student
     *
     * @param string $id
     * @return void
     */
    public static function delete(string $id)
    {
        if (Student::exists($id)) {
            $answer = Question::ask('Are you sure you want to remove this student? Y/n', Validation::IsString);

            if (in_array(strtolower($answer), ['y', 'yes'])) {
                Student::delete($id);

                echo "Student has been deleted!" . PHP_EOL;

                return;
            }

            echo "Student has not been deleted." . PHP_EOL;

            return;
        }

        echo "Student does not exist." . PHP_EOL;
    }

    /**
     * Search students using keywords
     *
     * @param string $keyword
     * @param array $data
     * @return void
     */
    public static function search(string $keyword, array $data = [])
    {
        $data[] = ['ID', 'First Name', 'Last Name', 'Age', 'Curriculm'];

        foreach (Student::all() as $student) {
            if (
                strpos(strtolower($student['id']), $keyword) !== false ||
                strpos(strtolower($student['first_name']), $keyword) !== false ||
                strpos(strtolower($student['last_name']), $keyword) !== false ||
                strpos(strtolower($student['age']), $keyword) !== false ||
                strpos(strtolower($student['curriculm']), $keyword) !== false
            ) {
                $data[] = array_values($student);
            }
        }

        echo Table::make($data);
    }
}

