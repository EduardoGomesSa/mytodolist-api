<?php

namespace Tests\Unit;

use App\Http\Controllers\TaskController;
use App\Http\Requests\TaskByIdRequest;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Mockery;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

it('teste rapido', function () {
    expect(true)->toBeTrue();
});

use Illuminate\Http\JsonResponse;
use Mockery;
use App\Services\TaskService;
use App\Http\Controllers\TaskController;
use App\Http\Requests\TaskByIdRequest;
use App\Models\Task;

it('returns a task successfully', function () {
    // Criando um mock do serviço
    $serviceMock = Mockery::mock(TaskService::class);

    // Configurando o mock para retornar uma task
    $task = new Task([
        'id' => 1,
        'title' => 'Tarefa Teste'
    ]);

    $serviceMock->shouldReceive('getById')
        ->once()
        ->andReturn($task);

    // Informando ao Laravel para usar esse mock ao invés da implementação real
    app()->instance(TaskService::class, $serviceMock);

    // Criando um mock da Request
    $requestMock = Mockery::mock(TaskByIdRequest::class);

    // Criando o Controller com injeção de dependência pelo container do Laravel
    $controller = app(TaskController::class);

    // Chamando o método do controller
    $response = $controller->getById($requestMock);

    // Convertendo a resposta para JSON
    $responseData = json_decode($response->getContent(), true);

    // Assertions
    expect($response)->toBeInstanceOf(JsonResponse::class);
    expect($response->getStatusCode())->toBe(200);
    expect($responseData)->toMatchArray([
        'id' => 1,
        'title' => 'Tarefa Teste',
    ]);
});


// it('returns a task successfully', function () {
//     $serviceMock = Mockery::mock(TaskService::class);

//     $task = Task::factory()->make([
//         'id'=>1,
//         'title'=>'Tarefa Teste'
//     ]);

//     $serviceMock->shouldReceive('getById')
//     ->once()
//     ->andReturn($task);

//     $requestMock = Mockery::mock(TaskByIdRequest::class);

//     app()->instance(\Illuminate\Contracts\Routing\ResponseFactory::class, app('response'));

//     app()->singleton(ResponseFactory::class, function ($app) {
//         return new \Illuminate\Routing\ResponseFactory(
//             $app['api'], $app[Response::class]
//         );
//     });


//     // $controller = new TaskController($serviceMock);
//     $controller = app()->make(TaskController::class, ['service'=>$serviceMock]);

//     $response = $controller->getById($requestMock);

//     $responseData = json_decode($response->getContent(), true);

//     expect($response->getStatusCode())->toBe(200);
//     expect($responseData)->toMatchArray($task);
//     // expect($responseData)->toMatchArray([
//     //     'id' => 1,
//     //     'title' => 'Tarefa Teste',
//     // ]);
// });
