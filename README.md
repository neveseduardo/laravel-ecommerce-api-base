# Laravel template api

- Um template dedicado para apis usando laravel

## Instalação

### Para execução do projeto
- Atualize as depedências do composer

```sh
composer install
```
- Migre os dados do banco, logo após editar os dados no arquivo .env

```sh
php artisan migrate
```
- Intale as chaves de acesso com o laravel passport

```sh
php artisan passport:install
```

- Execute o servidor e teste no postman ou insomnia
```sh
yarn serve
```
## Licença

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
