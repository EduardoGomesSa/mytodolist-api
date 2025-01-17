# Api do Sistema MyToDoList

## Sobre o projeto:

Api desenvolvida para ser o backend de uma aplicação mobile em Flutter. Ela é a responsável por executar validações, conversões e manipulação da base de dados MySQL.

## Tecnologias utilizadas: 
- ``Laravel 11``
- ``Eloquent ORM``
- ``MySQL``
- ``MVC``

## Comandos para inicialização
Instala as dependências e pacotes do projeto
```bash
  composer install
```
Renomeie o arquivo .env.example para ``.env`` e gere uma nova chave da API
```bash
  php artisan key:generate
```
Executa as migrations, criando ou atualizando o banco e tabelas no banco de dados 
```bash
  php artisan migrate
```
Executa o projeto, tornando-o acessível
```bash
  php artisan serve
```

## Endpoints
get ``/api/tasks`` Realiza a busca de todas as tarefas

post ``/api/tasks`` Realiza a criação de uma nova tarefa
```bash
{
	"name":"Repository com Items já criados no repository",
	"description":"Criou com os items da task",
	"status":"ativo",
	"start_date":"2024-06-05 12:30:45",
	"end_date":null,
	"items":[
		{
            "name": "1 item",
            "description": "Eu vou conseguir",
            "status":"ativo"
		}
	]
}
```

ℹ️ o campo ``items`` é opcional

put ``/api/tasks`` Realiza a atualização de tarefas
```bash
{
	"id":33,
	"name":"Atualizou Tudo",
	"description":"Atualizou Tudo",
	"status":"Pendente"
}
```

put ``/api/tasks/status`` Realiza a atualização do status de uma tarefa
```bash
{
	"id":333,
	"status":"pendente"
}
```

delete ``/api/tasks`` Realiza a exclusão de uma tarefa
```bash
{
	"id":323
}
```

get ``/api/tasks`` Realiza a busca de todos os items

post ``/api/items`` Realiza a criação de um novo item em uma tarefa
```bash
{
	"name":"Mais 10km, eu possooooo",
	"description":null,
	"status":"ativo",
	"task_id":4
}
```

put ``/api/items`` Realiza a atualização de um item em uma tarefa
```bash
{
	"id":6,
	"name":"+18km",
	"description":"Eu POSSO",
	"status":"ativo"
}
```

put ``/api/items/status`` Realiza a atualização do status de um item em uma tarefa
```bash
{
	"id":6,
	"status":"pausado"
}
```

delete ``/api/items`` Realiza a exclusão de um item em uma tarefa
```bash
{
	"id":7
}
```

## 

<p align='center'>🚧 Api em construção 🚧
