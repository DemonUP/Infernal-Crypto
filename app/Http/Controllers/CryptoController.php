<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CryptoController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getCryptos()
    {
        try {
            // Tiempo de caché en segundos (60s)
            $cacheTime = 60;
            $cacheKey = 'cryptos_data';

            // Intentamos obtener los datos desde la caché
            $cachedData = Cache::get($cacheKey);

            if ($cachedData) {
                $timeRemaining = max(0, $cacheTime - Carbon::now()->diffInSeconds(Carbon::parse($cachedData['last_update'])));

                // Log de acceso a datos cacheados
                Log::info("✅ Datos obtenidos de caché. Próxima actualización en {$timeRemaining} segundos.");

                return response()->json([
                    'cryptos' => $cachedData['cryptos'],
                    'last_update' => $cachedData['last_update'],
                    'time_remaining' => $timeRemaining
                ]);
            }

            Log::info("🔄 Solicitando datos a CoinCap...");

            // Realizar la solicitud a CoinCap API
            $response = Http::get('https://api.coincap.io/v2/assets?limit=10');

            if ($response->failed()) {
                Log::error("❌ Error en la API de CoinCap: " . $response->status(), [
                    'body' => $response->body()
                ]);
                return response()->json(['error' => 'API error'], 500);
            }

            $data = $response->json();
            $data = isset($data['data']) ? $data['data'] : [];

            // Guardar en caché con timestamp de última actualización
            $lastUpdate = Carbon::now();
            $result = [
                'cryptos' => $data,
                'last_update' => $lastUpdate->toISOString(),
                'time_remaining' => $cacheTime
            ];

            Cache::put($cacheKey, $result, $cacheTime);

            Log::info("✅ Datos actualizados y guardados en caché. Próxima actualización en {$cacheTime} segundos.");

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error("🚨 Excepción al obtener datos de CoinCap", [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Exception occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
