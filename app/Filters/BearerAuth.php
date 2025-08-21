<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class BearerAuth implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

                if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                    return service('response')->setStatusCode(401)
                        ->setJSON([
                            'status' => 'error',
                            'message' => 'Authorization header with Bearer token required.'
                        ]);
                }

                $token = $matches[1];

                // Contoh validasi token (ganti sesuai kebutuhan)
                if ($token !== 'aquatic') {
                    return service('response')->setStatusCode(403)
                        ->setJSON([
                            'status' => 'error',
                            'message' => 'Invalid token.'
                        ]);
                }

                // Jika valid, lanjut request
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
