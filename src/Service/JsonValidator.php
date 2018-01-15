<?php

namespace App\Service;

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
        $validator->coerce($json, (object)['$ref' => 'file://' . $path]);

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