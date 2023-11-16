# Gerenciamento de Filas de Assinatura

## Descrição

Projeto de Sistema de assinaturas e Disparo de Emails utilizando Sistema de Filas com RabbitMQ. Tambem utilizei Laravel Horizon para o sistema de gerenciamento de Jobs e JWT para um sistema de autenticação simples.
No momento o solid ainda não esta implementado tambem, pois o foco são nas filas com o RabbitMQ e os Jobs que os gerenciam.

No contexto de um serviço de assinatura de streaming, ao assinar um streaming, um registro é guardado na fila do RabbitMQ ("shot_emails") e para a leitura em tempo real, criei um Cron para escutar dentro da aplicação toda vez que alguma fila estivesse disponivel no R.MQ. Este Cron roda de 1 em 1 minuto. Não realizei configurações SMTP, mas a ideia é que ele funcione como disparador de emails. Mais uma vez, como o foco são as filas, eu sigo o fluxo armazenando no banco de dados todos o email disparado para determinado usuario correspondendo a seu evento.

## Instalação

Primeiramente vamos executar o comando docker para visualizar o rabbitMQ:

```bash
docker run -d --name rabbitmq -p 15672:15672 -p 5672:5672 rabbitmq:management
```
Depois disso, coloque no seu arquivo .env estas credenciais:

```console
RABBITMQ_HOST=localhost
RABBITMQ_PORT=5672
RABBITMQ_VHOST=/
RABBITMQ_LOGIN=guest
RABBITMQ_PASSWORD=guest
```

Depois de executado, você podera acessar o painel do RabbitMQ pelo link: http://localhost:15672/. O usuario e senha serão "guest". Crie uma queue com o nome "shot_emails".

Feito isto, crie um banco de dados com o nome "agenda" no PHPMyAdmin ou em um banco de sua escolha, e configure as credenciais corretas no seu arquivo .env.
Após isto, execute:

```bash
composer install
php artisan serve
php artisan migrate
php artisan db:seed --class=StreamingSeeder
php artisan db:seed --class=TemplateSeeder
php artisan queue:work
php artisan schedule:run
```

depois disso, seeds foram adicionadas nas respectivas tabelas de template de email e de streams. Agora pode executar as rotas.