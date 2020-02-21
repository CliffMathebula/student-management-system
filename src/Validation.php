<?php

namespace ManagementSystem;

class Validation
{
    const IsString = 'isString';

    const IsNumeric = 'isNumeric';

    /**
     * Check if value is numeric
     *
     * @param string $value
     * @return bool
     */
    public function isString(string $value) : bool
    {
        return is_string($value);
    }

    /**
     * Check if value is numeric
     *
     * @param string $value
     * @return bool
     */
    public function isNumeric(string $value) : bool
    {
        return is_numeric($value);
    }
}

