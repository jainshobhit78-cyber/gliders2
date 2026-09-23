<?php

namespace App\Http\Controllers;

use App\Support\VisualCaptcha;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityCaptchaController extends Controller
{
    public function show(Request $request, string $context): Response
    {
        $png = VisualCaptcha::renderPng(VisualCaptcha::issue($request, $context));

        return response($png, 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
