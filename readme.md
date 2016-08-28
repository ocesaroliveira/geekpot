# GeekPot IT - Teste
Esse repositório é para a avaliação da vaga de desenvolvedor PHP da empresa GeekPot IT.

## Requisitos
Construir uma API RESTful com os seguintes casos:
1. Como visitante eu devo conseguir criar uma conta utilizando meu email e uma senha, e ao concluir com sucesso meu cadastro devo receber um email de confirmação.
2. Como cliente da API eu devo conseguir autenticar utilizando uma API Key e uma Secret Key geradas automaticamente no momento do meu cadastro.
3. Como cliente da API meu token de acesso deve se renovar a cada 5 minutos, e expirar após 15 minutos de inatividade.
4. Como cliente da API eu devo ter um método de lookup, onde posso requisitar a lista de todos os resources e métodos aos quais tenho permissão de acessar.
5. Como cliente da API eu não posso ter acesso a nenhum registro que não seja de minha propriedade.
6. Como administrador da API eu devo poder listar e visualizar detalhes de todos os usuários registrados.
7. Como administrador da API eu devo poder alterar, suspender o acesso e deletar qualquer usuário registrado.
8. Como administrador da API eu devo poder listar todos os usuários deletados.

## O que foi utilizado
Com a experiência de anos que eu tenho com [Laravel](https://laravel.com/), decidi usa-lo para agilizar o desenvolvimento. Vale lembrar que o Laravel é um dos frameworks mais utilizados atualmente.

Além disso, utilizei o conceito de OAuth2 para tratar a autenticação e autorização dos requests na API. Para isso, utilizei uma [biblioteca](https://github.com/lucadegasperi/oauth2-server-laravel/) para o Laravel feito pelo user [lucadegasperi](https://github.com/lucadegasperi/).

Para enviar o e-mail transacional, eu utilizei a plataforma do [Sendgrid](http://sendgrid.com/). A integração já é feita junto com o Laravel, que utiliza o [Guzzle HTTP](https://github.com/guzzle/guzzle) para fazer os requests para o Sendgrid.

Utilizei o [Homestead](https://laravel.com/docs/5.2/homestead) como ambiente de desenvolvimento.

## O que eu achei
Um teste muito bom, pensando em conceitos modernos, como o OAuth2 e eu tenho experiência com essa teoria utilizado. Foi um teste desafiador e, principalemente, longo. Gastei muito tempo procurando uma plataforma de envio de e-mail sem verificação de domínio e com a ativação da conta.

Como o prazo é de apenas um dia, não deu para fazer testes unitários com os serviços dos usuários.

## Instalação
Você deve clonar esse repositório em uma pasta que fique confortável para você conseguir executá-lo. Recomendo o Homestead, já citado anteriormente.

Após clonar o repositório, você vai precisar do [Composer](https://getcomposer.org). Você deve ir até a raiz do repositório e rodar o comando:

```
$ composer install
```

Esse comando irá baixar as dependências do projeto e executar os scripts de instalação. Você verá que foi criado um arquivo .env na raiz do projeto. Esse arquivo guarda váriaveis de ambiente. Você irá precisar preencher algumas dessas váriaveis ao seu gosto. Uma delas é a seção de conexão com banco de dados. Veja um exemplo abaixo de como ficaria:

```
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:d5EY/EMxwdYE8EKfN/hLo9Lzung4Cdtt0qP5vnqPkbE=
APP_URL=http://api.geekpot.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=geekpot
DB_USERNAME=homestead
DB_PASSWORD=secret
```

## Sobre a API
As rotas da API podem ser vistas [aqui](api.md).
