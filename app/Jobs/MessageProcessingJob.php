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
use App\Models\SuaModel; // Substitua pelo modelo que você está usando
use Illuminate\Support\Facades\Log;
use App\Models\Contato;
use App\Models\DispatchEmail;

class MessageProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
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
        $callback = function ($message) {
            // Processar a mensagem e salvar no banco de dados
            $mensagem = json_decode($message->body, true);

            DispatchEmail::create([
                'status' => 2,
                'email' => $mensagem['email'],
                'template_id' => $mensagem['event']
            ]);

            // Confirma o recebimento da mensagem
            $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
        };

        // Configura o consumo da fila
        $channel->basic_consume('shot_emails', '', false, false, false, false, $callback);

        // Mantém o processo rodando para consumir mensagens
        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
