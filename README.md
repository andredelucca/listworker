<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Listworker</h1>
    <br>
</p>

Aplicação simples para organização de tarefas do dia-a-dia.


## Instalação

No SO Windows, garantir que o docker, o php e o composer estejam instalados, antes de rodar os códigos.

```bash
  composer create-project --prefer-dist yiisoft/yii2-app-basic listworker
```
Após instalação do Framework Yii2, criar as imagens e containers no Docker. No terminal, não esquece de estar dentro do diretório listworker e com o Docker iniciado. 

```bash
  docker-compose build
  docker-compose up
```
Pode acessar http://localhost:8000/ para abrir a aplicação.

Se necessário, o phpmyadmin está em http://localhost:8080/

Antes de utilizar, é necessário criar o banco de dados, utilizando migrations.

```bash
  docker-compose exec php ./yii migrate/create
```
Na sequência, criar o banco de dados de testes, para rodar os testes unitários. 

```bash
  docker-compose exec db mysql -uroot -pteste -e "CREATE DATABASE yii2_test;"
```
Acessar dentro do terminal das imagens no Docker, para fazer o migrations

```bash
  docker exec -it mysql_db /bin/bash
  export YII_ENV=test
  php yii migrate
```
## Rodando os testes

Para rodar os testes, rode o seguinte comando

```bash
  docker-compose exec -T php vendor/bin/codecept run unit tests/unit <diretório/arquivo>
```
Se quiser, pode rodar o CodeSniffer

```bash
  docker-compose exec -T php vendor/bin/phpcs --standard=PSR12 <diretório>
```
## Autores

- [@andredelucca](https://www.github.com/andredelucca)



