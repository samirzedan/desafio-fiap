<?php

namespace App\Utils;

use App\Exceptions\ValidationException;

class Validator
{
    public static function validate(array $fields, array $rules)
    {
        $result = [];
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $fields[$field] ?? null;
            $isNullable = in_array('nullable', $fieldRules, true);

            if ($isNullable && (is_null($value) || (is_string($value) && trim($value) === ''))) {
                $result[$field] = $value;
                continue;
            }

            foreach ($fieldRules as $rule) {
                switch ($rule) {
                    case 'required':
                        if (is_null($value) || (is_string($value) && trim($value) === '')) {
                            $errors[$field][] = "The field '$field' is required.";
                        }
                        break;

                    case 'nullable':
                        break;

                    case 'string':
                        if (!is_string($value)) {
                            $errors[$field][] = "The field '$field' must be a string.";
                        }
                        break;

                    case 'numeric':
                        if (!is_numeric($value)) {
                            $errors[$field][] = "The field '$field' must be numeric.";
                        }
                        break;

                    case 'integer':
                        if (!is_int($value)) {
                            $errors[$field][] = "The field '$field' must be an integer.";
                        }
                        break;

                    case 'boolean':
                        if (!is_bool($value) && !in_array($value, [0,1,'0','1'], true)) {
                            $errors[$field][] = "The field '$field' must be a boolean.";
                        }
                        break;

                    case 'date':
                        if (!is_string($value) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) || !checkdate((int)substr($value, 5, 2), (int)substr($value, 8, 2), (int)substr($value, 0, 4))) {
                            $errors[$field][] = "The field '$field' must be a valid date in YYYY-MM-DD format.";
                        }
                        break;

                    case 'email':
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $errors[$field][] = "The field '$field' must be a valid email address.";
                        }
                        break;

                    case 'cpf':
                        if (!is_null($value) && !self::validateCPF($value)) {
                            $errors[$field][] = "The field '$field' must be a valid CPF.";
                        }
                        break;

                    case (preg_match('/^min:(\d+)$/', $rule, $matches) ? true : false):
                        $min = (int) $matches[1];
                        if (is_string($value) && mb_strlen($value) < $min) {
                            $errors[$field][] = "The field '$field' must be at least $min characters long.";
                        } elseif (is_numeric($value) && $value < $min) {
                            $errors[$field][] = "The field '$field' must be at least $min.";
                        }
                        break;

                    case (preg_match('/^max:(\d+)$/', $rule, $matches) ? true : false):
                        $max = (int) $matches[1];
                        if (is_string($value) && mb_strlen($value) > $max) {
                            $errors[$field][] = "The field '$field' must be at most $max characters long.";
                        } elseif (is_numeric($value) && $value > $max) {
                            $errors[$field][] = "The field '$field' must be at most $max.";
                        }
                        break;

                    case 'strong_password':
                        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
                        if (!is_string($value) || !preg_match($pattern, $value)) {
                            $errors[$field][] = "The field '$field' must be a strong password (at least 8 characters, including uppercase, lowercase, number, and symbol).";
                        }
                        break;

                    default:
                        $errors[$field][] = "Validation rule '$rule' for field '$field' is not supported.";
                        break;
                }
            }

            $result[$field] = $value;
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }

        return $result;
    }

    private static function validateCPF(string $cpf): bool
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) !== 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $sum = 0;
            for ($i = 0; $i < $t; $i++) {
                $sum += (int) $cpf[$i] * (($t + 1) - $i);
            }
            $digit = ((10 * $sum) % 11) % 10;
            if ((int) $cpf[$t] !== $digit) {
                return false;
            }
        }

        return true;
    }
}
