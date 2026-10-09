<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    /**
     * Generate fresh math challenge for anti-bot validation.
     */
    public function refresh(Request $request)
    {
        $scope = $request->query('scope', 'chat');
        $validScopes = ['chat', 'comment', 'contact'];
        if (!in_array($scope, $validScopes)) {
            $scope = 'chat';
        }

        $n1 = rand(2, 9);
        $n2 = rand(1, 9);
        $sum = $n1 + $n2;

        session(["captcha_{$scope}" => $sum]);

        return response()->json([
            'success' => true,
            'question' => "{$n1} + {$n2}",
            'scope' => $scope,
        ]);
    }
}
