<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class HandlePutFormData
{
    /**
     * Middleware untuk mem-parse multipart/form-data pada PUT/PATCH request.
     * PHP secara bawaan tidak mem-parse body multipart pada selain POST.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->method(), ['PUT', 'PATCH'])) {
            $contentType = $request->header('Content-Type', '');

            if (str_contains($contentType, 'multipart/form-data')) {
                $this->parseMultipartFormData($request);
            }
        }

        return $next($request);
    }

    /**
     * Parse raw multipart/form-data dari php://input
     */
    private function parseMultipartFormData(Request $request): void
    {
        $rawInput = file_get_contents('php://input');

        // Ambil boundary dari Content-Type header
        $contentType = $request->header('Content-Type');
        if (!preg_match('/boundary=(?:"?)(.+?)(?:"?\s*$)/', $contentType, $matches)) {
            return;
        }

        $boundary = $matches[1];
        $blocks = preg_split('/-+' . preg_quote($boundary, '/') . '/', $rawInput);

        // Hapus block pertama (kosong) dan terakhir (--)
        array_pop($blocks);
        array_shift($blocks);

        $data = [];
        $files = [];

        foreach ($blocks as $block) {
            if (empty(trim($block))) {
                continue;
            }

            // Parse nama field
            if (!preg_match('/name="([^"]+)"/', $block, $nameMatch)) {
                continue;
            }

            $name = $nameMatch[1];

            // Cek apakah ini file upload
            if (preg_match('/filename="([^"]*)"/', $block, $fileMatch)) {
                $filename = $fileMatch[1];
                if (empty($filename)) {
                    continue;
                }

                // Ambil MIME type
                preg_match('/Content-Type:\s*(.+?)(?:\r\n|\n)/i', $block, $typeMatch);
                $mimeType = isset($typeMatch[1]) ? trim($typeMatch[1]) : 'application/octet-stream';

                // Ambil isi file (setelah double newline)
                $parts = preg_split('/\r\n\r\n|\n\n/', $block, 2);
                $fileContent = isset($parts[1]) ? rtrim($parts[1], "\r\n") : '';

                // Simpan ke temporary file
                $tmpPath = tempnam(sys_get_temp_dir(), 'php_put_');
                file_put_contents($tmpPath, $fileContent);

                $files[$name] = new UploadedFile(
                    $tmpPath,
                    $filename,
                    $mimeType,
                    null,
                    true // test mode: skip is_uploaded_file() check
                );
            } else {
                // Regular text field
                $parts = preg_split('/\r\n\r\n|\n\n/', $block, 2);
                $value = isset($parts[1]) ? rtrim($parts[1], "\r\n") : '';
                $data[$name] = $value;
            }
        }

        // Merge data dan files ke dalam request
        $request->merge($data);
        $request->files->add($files);
    }
}
