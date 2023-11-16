<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Template;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Template::create([
            'template' => '<html><body>Pagina de Boas Vindas</body></html>',
        ]);

        Template::create([
            'template' => '<html><body>Pagina de Atraso de Pagamento</body></html>',
        ]);

        Template::create([
            'template' => '<html><body>Pagina de Assinatura expirada</body></html>',
        ]);

        Template::create([
            'template' => '<html><body>Pagina de Assinatura Cancelada</body></html>',
        ]);

        Template::create([
            'template' => '<html><body>Pagina de Assinatura Ativada</body></html>',
        ]);


        // Você pode adicionar mais usuários conforme necessário
    }
}