<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Set security headers
        $this->setSecurityHeaders($response);

        return $response;
    }

    /**
     * Set security headers on the response
     */
    private function setSecurityHeaders(Response $response): void
    {
        // Basic security headers
        $headers = [
            'X-Frame-Options' => 'DENY',
            'X-Content-Type-Options' => 'nosniff',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'geolocation=(), microphone=(), camera=()',
        ];

        // HSTS - hanya di production
        if (app()->environment('production')) {
            $headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains; preload';
        }

        // CSP berdasarkan environment
        $headers['Content-Security-Policy'] = $this->getCSPHeader();

        // Set semua headers
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }
    }

    /**
     * Generate Content Security Policy header berdasarkan environment
     */
    private function getCSPHeader(): string
    {
        // Default CSP untuk development
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval'",
            "style-src 'self' 'unsafe-inline'",
            "img-src 'self' data: https:",
            "font-src 'self' data:",
            "connect-src 'self'",
            "frame-ancestors 'none'",
            "base-uri 'self'",
            "form-action 'self'",
        ];

        // Tambahkan external resources jika diperlukan
        $externalScripts = [
            'https://cdn.tailwindcss.com',
            'https://cdnjs.cloudflare.com',
            'https://code.jquery.com',
        ];

        $externalStyles = [
            'https://cdn.tailwindcss.com',
            'https://cdnjs.cloudflare.com',
            'https://fonts.googleapis.com',
        ];

        $externalFonts = [
            'https://cdnjs.cloudflare.com',
            'https://fonts.gstatic.com',
        ];

        // Untuk production, batasi lebih ketat
        if (app()->environment('production')) {
            $csp = [
                "default-src 'self'",
                "script-src 'self'",
                "style-src 'self'",
                "img-src 'self' data:",
                "font-src 'self'",
                "connect-src 'self'",
                "frame-ancestors 'none'",
                "base-uri 'self'",
                "form-action 'self'",
            ];
            
            // Tambahkan nonce untuk inline scripts/styles jika menggunakan Vite/Webpack
            // $csp[1] = "script-src 'self' 'nonce-" . $this->generateNonce() . "'";
            // $csp[2] = "style-src 'self' 'nonce-" . $this->generateNonce() . "'";
        }

        return implode('; ', $csp);
    }

    /**
     * Generate nonce untuk CSP (jika diperlukan)
     */
    private function generateNonce(): string
    {
        return bin2hex(random_bytes(16));
    }
}