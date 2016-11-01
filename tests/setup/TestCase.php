<?php

use EscapeWork\LaraMedias\Providers\MediasServiceProvider;
use Illuminate\Http\UploadedFile;

class TestCase extends Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../../database/migrations'),
        ]);

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../../tests/migrations'),
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [MediasServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    public function getPicture($params = [])
    {
        $pic = __DIR__.'/../../tests/files/temp.jpg';
        $params = array_merge([
            'name' => 'picture.jpg',
        ], $params);

        if (!is_file($pic)) {
            File::copy(__DIR__.'/../../tests/files/chrysanthemum.jpg', $pic);
        }

        return new UploadedFile(
            $pic,
            $params['name'],
            'image/jpeg',
            null,
            null,
            true
        );
    }
}
