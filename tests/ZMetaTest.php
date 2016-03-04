<?php
/**
 * meta test - to run code linter
 *
 * Matt Smith changes, Feb 2016
 *
 * (1) hard code shell command to: "php php-cs-fixer.phar"
 * (just have to assume this file is sitting in project folder next to composer.json)
 *
 * (2) hard code location of "index.php" to be "./public/index.php"
 * (might be 'web' in some projects, such as Symfony)
 *
 * adaapted from: J. P. Stacey website
 * http://www.jpstacey.info/blog/2015-07-08/phpunit-can-check-your-code-against-psr-2-and-other-coding-standards
 *
 * start with letter 'Z' so this test run last ...
 */

namespace ItbTest;

/**
 * @class
 * Test properties of our codebase rather than our actual code.
 */
class ZMetaTest extends \PHPUnit_Framework_TestCase
{

    /**
     * /src
     */
    public function testPSR2DirectorySrc()
    {
        // hard code for php-cs-fixer.phar
        $command = 'php php-cs-fixer.phar';

        // hard code directory
        $path = './src';

        // If we can't find the command-line tool, we mark the test as skipped
        // so it shows as a warning to the developer rather than passing silently.
        if (!$command) {
            $this->markTestSkipped(
                'Needs linter to check PSR-2 compliance'
            );
        }

        // Run linter in dry-run mode so it changes nothing.
        $fullCLIComment = "$command fix --level=psr2 --dry-run $path";
        exec(
            $fullCLIComment,
            $output,
            $return_var
        );

        // If we've got output, pop its first item ("Fixed all files...")
        // and trim whitespace from the rest so the below makes sense.
        if ($output) {
            array_pop($output);
            $output = array_map("trim", $output);
        }

        // Check shell return code: if nonzero, report the output as a failure.
        $this->assertEquals(
            0,
            $return_var,

            "PSR-2 linter reported errors in $path/: " . join('; ', $output)
        );
    }

    /**
     * /tests - yes we should have tidy code in our Test classes too !
     */
    public function testPSR2DirectoryTests()
    {
        // hard code for php-cs-fixer.phar
        $command = 'php php-cs-fixer.phar';

        // hard code directory
        $path = './tests';

        // If we can't find the command-line tool, we mark the test as skipped
        // so it shows as a warning to the developer rather than passing silently.
        if (!$command) {
            $this->markTestSkipped(
                'Needs linter to check PSR-2 compliance'
            );
        }

        // Run linter in dry-run mode so it changes nothing.
        $fullCLIComment = "$command fix --level=psr2 --dry-run $path";
        exec(
            $fullCLIComment,
            $output,
            $return_var
        );

        // If we've got output, pop its first item ("Fixed all files...")
        // and trim whitespace from the rest so the below makes sense.
        if ($output) {
            array_pop($output);
            $output = array_map("trim", $output);
        }

        // Check shell return code: if nonzero, report the output as a failure.
        $this->assertEquals(
            0,
            $return_var,

            "PSR-2 linter reported errors in $path/: " . join('; ', $output)
        );
    }

    /**
     * /public - yes we should have tidy code in 'index.php' too!
     */
    public function testPSR2DirectoryPublic()
    {
        // hard code for php-cs-fixer.phar
        $command = 'php php-cs-fixer.phar';

        // hard code directory
        $path = './public';

        // If we can't find the command-line tool, we mark the test as skipped
        // so it shows as a warning to the developer rather than passing silently.
        if (!$command) {
            $this->markTestSkipped(
                'Needs linter to check PSR-2 compliance'
            );
        }

        // Run linter in dry-run mode so it changes nothing.
        $fullCLIComment = "$command fix --level=psr2 --dry-run $path";
        exec(
            $fullCLIComment,
            $output,
            $return_var
        );

        // If we've got output, pop its first item ("Fixed all files...")
        // and trim whitespace from the rest so the below makes sense.
        if ($output) {
            array_pop($output);
            $output = array_map("trim", $output);
        }

        // Check shell return code: if nonzero, report the output as a failure.
        $this->assertEquals(
            0,
            $return_var,

            "PSR-2 linter reported errors in $path/: " . join('; ', $output)
        );
    }
}
