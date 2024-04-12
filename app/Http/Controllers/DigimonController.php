<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class DigimonController extends Controller
{

    public function viewListDigimon(Request $request)
    {
        $currentPage = isset($request->page) ? $request->page : 0;

        $url = "https://digi-api.com/api/v1/digimon?pageSize=10&page={$currentPage}";
        try {
            $response = Http::timeout(10)->get($url);
            if ($response->getStatusCode() >= 400) {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
            $digimons = $response->json()['content'];
            $paginacion = $response->json()['pageable'];
            return Inertia::render('Digimons/digimon', ['digimonslist' =>  $digimons, 'paginacion' => $paginacion]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDetailDigimon($id)
    {
        try {
            $baseUrl = 'https://www.digi-api.com/api/v1/digimon/';
            $url = $baseUrl . $id;
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->timeout(10)
                ->get($url);

            if ($response->getStatusCode() >= 400) {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
            $digimonDetail = $response->json();
            return Inertia::render('Digimons/digimon', ['data' =>   $digimonDetail]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
