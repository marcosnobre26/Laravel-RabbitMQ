<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\MinhaFilaDeTrabalho;

class FilaController extends Controller
{
    public function enviarParaFila()
    {
        // Dispara a tarefa de enfileiramento
        dispatch(new MinhaFilaDeTrabalho());

        return 'Tarefa enfileirada com sucesso!';
    }
}