<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // use CreatesApplication;

    // protected function setUp(): void
    // {
    //     parent::setUp();

    //     // Confirmar que estamos no ambiente de teste
    //     if (app()->environment() !== 'testing') {
    //         throw new \Exception('Não estamos no ambiente de teste');
    //     }

    //     // Definir a configuração do banco de dados para testes
    //     config()->set('database.default', 'sqlite');
    //     config()->set('database.connections.sqlite.database', ':memory:');

    //     // Rodar as migrações
    //     $this->artisan('migrate')->run();
    // }
}
