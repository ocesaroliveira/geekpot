# API

Esse arquivo irá documentar toda a parte técnica da API Restful.

## Rotas
Segue a lista com as rotas da API, junto com o método da rota, o nome, o código utilizado e o scope do OAuth2 necessário:

| Method | URI                        | Name                             | Action                                                   | Scope              |
| ------ | -------------------------- | -------------------------------- | -------------------------------------------------------- | ------------------ |
| GET    | /                          |                                  | Closure                                                  |                    |
| POST   | v1/oauth/access_token      |                                  | Closure                                                  |                    |
| POST   | v1/user                    | v1.user.create                   | \App\Http\Controllers\UserController@create              |                    |
| GET    | v1/user/inverso            | v1.user.revert                   | \App\Http\Controllers\UserController@revert              | read               |
| GET    | v1/user                    | v1.user.get                      | \App\Http\Controllers\UserController@get                 | read               |
| PUT    | v1/user                    | v1.user.update                   | \App\Http\Controllers\UserController@update              | update             |
| DELETE | v1/user                    | v1.user.delete                   | \App\Http\Controllers\UserController@delete              | delete             |
| GET    | v1/user/admin/list         | v1.user.admin.list_users         | \App\Http\Controllers\AdminController@list_users         | admin_list         |
| GET    | v1/user/admin/list/deleted | v1.user.admin.list_users_deleted | \App\Http\Controllers\AdminController@list_users_deleted | admin_list_deleted |
| PUT    | v1/user/admin/manage/{id}  | v1.user.admin.manage.update      | \App\Http\Controllers\AdminController@manage_update      | admin_manage       |
| DELETE | v1/user/admin/manage/{id}  | v1.user.admin.manage.delete      | \App\Http\Controllers\AdminController@manage_delete      | admin_manage       |

Na instalação do projeto, são criados esses scopes. Existem dois tipos de clientes básicamente. Um admin e um cliente que se cadastra pela rota `POST v1/user/`. Além disso, é criado um usuário de admin para acessar as rotas protegidas. Seu e-mail é o `admin@geekpot.com.br` com a senha `654321`. Seu client_id é o `admin@geekpot.com.br` e o seu client_secret é o `020105d25d9ff015368be6bc2988b2cc7b89cfe2`.

## Adquirindo um access_token
Como foi utilizado o OAuth2 para a autenticação e autorização da API, as rotas são protegidas por um access_token e um scope. Caso não saiba, você pode dar uma olhada [aqui](https://oauth.net/2/).

Para adquirir um access token, existem duas maneiras:
* Com e-mail e senha do cliente
* Com um refresh token, que é um token gerado junto com o access token

Para conseguir seu access token com e-mail e senha, você irá precisar fazer um POST para a rota `v1/oauth/access_token` com os seguintes campos e valores:

* grant_type: password
* client_id: _SEU_CLIENT_ID_
* client_secret: _SEU_CLIENT_SECRET_
* username: _EMAIL_CADASTRADO_
* password: _SENHA_CADASTRADA_
* scope: [read, update, delete, admin_list, admin_list_deleted, admin_manage]

Após isso, você irá receber seu access_token. Com esse access_token, você deverá informar um header `Authorization` nas rotas protegidas, com o valor Bearer, que é o tipo de access_token utilizado mais o access_token. Por exemplo:

```
Authorization: Bearer RZZD2e9BOvuFBJQucZbQ3jML3m1efK7xAr1Tkias
```
