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
}

