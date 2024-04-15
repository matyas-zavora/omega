<?php

use PHPUnit\Framework\TestCase;

require_once '../functions.php';

/**
 * Class FileProcessingTest
 * PHPUnit test class for testing file processing functions.
 */
class FileProcessingTest extends TestCase
{
    /**
     * Test the readFileContents function.
     *
     * This test checks if the readFileContents function reads the content of a file correctly.
     * It creates a test file, reads its content, and asserts that the content matches the expected value.
     * After testing, it removes the test file.
     */
    public function testReadFileContents()
    {
        $uploadDir = '../input/';
        $targetFile = 'test_file';
        $testContent = 'Testing content for the file.';

        // Create a test file
        file_put_contents($uploadDir . $targetFile, $testContent);

        // Call the readFileContents function
        $result = readFileContents($targetFile, $uploadDir);

        // Check if the content matches the expected value
        $this->assertEquals($testContent, $result);

        // Remove the test file after testing
        unlink($uploadDir . $targetFile);
    }

    /**
     * Test the shortenFile function.
     *
     * This test checks if the shortenFile function shortens the content of a file correctly.
     * It creates a test file, calls the shortenFile function with specific replacements,
     * reads the modified content, and asserts that the content matches the expected value.
     * After testing, it removes the test file.
     */
    public function testShortenFile()
    {
        $uploadDir = '../input/';
        $targetFile = 'test_file_shorten';
        $input1 = ['replace1', 'replace2'];
        $input2 = ['with1', 'with2'];
        $testContent = 'This is some content to replace1 and replace2.';

        // Create a test file
        file_put_contents($uploadDir . $targetFile, $testContent);

        // Call shortenFile function
        shortenFile($targetFile, $uploadDir, $input1, $input2);

        // Read the modified content
        $result = readFileContents($targetFile, $uploadDir);

        // Check if the content matches the expected value after replacements
        $this->assertEquals('This is some content to with1 and with2.', $result);

        // Remove the test file after testing
        unlink($uploadDir . $targetFile);
    }
}
