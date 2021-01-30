<?php

if (! function_exists('json_response')) {
    /**
     * Format json response.
     *
     * @param mixed|null $body
     * @param int $status
     * @return \Illuminate\Http\JsonResponse $response
     */
    function json_response($body, $status) {
        $response = response()->json([
            'body' => $body
        ], $status);

        return $response;
    }
}
