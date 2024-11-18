<?php

namespace App\Http\Controllers;

use App\Services\ViaCepService;
use Illuminate\Http\Request;

class CepController extends Controller
{
    protected $viaCepService;

    /**
     * Injeta o serviço ViaCepService na Controller.
     *
     * @param ViaCepService $viaCepService
     */
    public function __construct(ViaCepService $viaCepService)
    {
        $this->viaCepService = $viaCepService;
    }

    /**
     * Consulta um CEP e retorna os dados.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function consultarCep(Request $request)
    {
        $request->validate([
            'cep' => 'required|size:8',
        ]);

        $cep = $request->input('cep');
        $dadosCep = $this->viaCepService->consultarCep($cep);

        if (!$dadosCep) {
            return response()->json(['message' => 'CEP inválido ou não encontrado.'], 404);
        }

        return response()->json($dadosCep);
    }
}
