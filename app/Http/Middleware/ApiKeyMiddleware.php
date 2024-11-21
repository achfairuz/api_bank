<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (isset($_GET['apiKey'])) {
            $result = ApiKey::where('api_key', $_GET['apiKey'])->get();
            if ($result->isNotEmpty()) {
                return $next($request);
            }
            $response = [
                'success' => false,
                'message' => "Api Key Invalid",
            ];
            return response()->json($response, 403);
        }
        $response = [
            'success' => false,
            'message' => "Api Key Invalid",
        ];
        return response()->json($response, 403);
    }
}
