<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ViaCepService
{
    /**
     * Consulta um CEP usando a API ViaCEP.
     *
     * @param string $cep
     * @return array|null
     */
    public function consultarCep(string $cep): ?array
    {
        $url = "https://viacep.com.br/ws/{$cep}/json/";

        try {
            $response = Http::get($url);

            if ($response->successful() && !$response->json('erro')) {
                return $response->json();
            }

            return null; // Retorna null caso o CEP seja inválido.
        } catch (\Exception $e) {
            // Loga o erro ou executa outra ação conforme necessário
            logger()->error("Erro ao consultar o CEP: {$e->getMessage()}");
            return null;
        }
    }
}
