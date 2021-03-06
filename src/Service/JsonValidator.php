<?php

namespace App\Service;

use JsonSchema\Constraints\Constraint;

/**
 * Class JsonValidator
 * @package App\Service
 */
final class JsonValidator
{
    /**
     * @var string
     */
    private $rootDir;

    /**
     * JsonValidator constructor.
     * @param string $rootDir
     */
    public function __construct(string $rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * @param string $schemaFile
     * @param array $json
     * @return bool
     */
    public function validateByFile(string $schemaFile, array $json)
    {
        $path = $this->rootDir . '/JsonSchema/' . $schemaFile;

        $validator = new \JsonSchema\Validator();
        $validator->validate(
            $json,
            (object)['$ref' => 'file://' . $path],
            Constraint::CHECK_MODE_TYPE_CAST + Constraint::CHECK_MODE_COERCE_TYPES
        );

        if (false === $validator->isValid()) {
            $validationMessage = "JSON does not validate. Violations:\n";
            foreach ($validator->getErrors() as $error) {
                $validationMessage .= sprintf("[%s] %s\n", $error['property'], $error['message']);
            }
            echo $validationMessage;
        }

        return $validator->isValid();
    }
}
