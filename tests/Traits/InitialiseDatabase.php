<?php

namespace Tests\Traits;

use DatabaseSeeder;

trait InitialiseDatabase
{
    protected static $backupExtension = '.dusk.bak';
    
    /**
     * Creates an empty database for testing, but backups the current dev one first.
     */
    public function backupDatabase()
    {
        if (!$this->app) {
            $this->refreshApplication();
        }

        $db = $this->app->make('db')->connection();
        if (!file_exists($db->getDatabaseName())) {
            touch($db->getDatabaseName());
        }

        copy($db->getDatabaseName(), $db->getDatabaseName().static::$backupExtension);
        unlink($db->getDatabaseName());
        touch($db->getDatabaseName());

        $this->artisan('migrate');
        $this->seed(DatabaseSeeder::class);
        $this->beforeApplicationDestroyed([$this, 'restoreDatabase']);
    }

    /**
     * Paired with backupDatabase to restore the dev database to its original form.
     */
    public function restoreDatabase()
    {
        // restore the test db file
        if (!$this->app) {
            $this->refreshApplication();
        }
        $db = $this->app->make('db')->connection();
        copy($db->getDatabaseName().static::$backupExtension,
            $db->getDatabaseName());
        unlink($db->getDatabaseName().static::$backupExtension);
    }
}
