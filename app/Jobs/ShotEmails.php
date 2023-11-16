<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ShotEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $event;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, int $event)
    {
        // Defina a fila desejada usando o método onQueue
        $this->user = $user;
        $this->event = $event;
        $this->onQueue('shot_emails');
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.login'),
            config('rabbitmq.password'),
            config('rabbitmq.vhost')
        );

        $channel = $connection->channel();

        // Declare a queue
        $channel->queue_declare('shot_emails', false, true, false, false);

        // Adicione aqui a lógica de processamento da fila

        // Exemplo de envio de mensagem para a fila
        $messageBody = json_encode(['name' => $this->user->name, 'email' => $this->user->email, 'event' => $this->event]);
        $message = new AMQPMessage($messageBody);

        $channel->basic_publish($message, '', 'shot_emails');

        $channel->close();
        $connection->close();
    }
}
