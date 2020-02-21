<?php

namespace ManagementSystem;

class Question
{
    /**
     * Ask a new question
     *
     * @param string $question
     * @param string $rule
     * @return string $answer
     */
    public static function ask(string $question, string $rule)
    {
        echo $question . PHP_EOL;

        $handle = fopen("php://stdin","r");
        $answer = trim(fgets($handle));

        fclose($handle);

        if (Validation::run($rule, $answer)) return $answer;

        return self::ask('Please enter a valid answer!', $rule);
    }
}

