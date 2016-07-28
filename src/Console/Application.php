<?php

namespace Castor\Console;

use Castor\Console\Commands\Convert;
use Symfony\Component\Console\Application as ConsoleApplication;

/**
 * Castor Application Class.
 *
 * Used to boot castor commands and configuration
 */
class Application extends ConsoleApplication
{
    /**
     * @var string Application Name
     */
    protected $name = 'Castor';

    /**
     * @var string Application Version
     */
    protected $version = '1.2.0';

    /**
     * Castor application constructor.
     */
    public function __construct()
    {
        // Init the application (Symfony/Console).
        parent::__construct($this->name, $this->version);

        // Register commands
        $this->registerCommands();
    }

    protected function registerCommands()
    {
        // Convert command.
        $this->add(new Convert());
    }
}
