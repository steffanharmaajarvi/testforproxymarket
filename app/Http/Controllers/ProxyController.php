<?php

namespace App\Http\Controllers;

use App\Service\Providers\AbstractProviderService;
use App\Service\ProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProxyController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        private ProxyService $proxyService,
        private AbstractProviderService $abstractProviderService
    )
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a list of proxies
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(): JsonResponse
    {
        try {
            $list = $this->abstractProviderService->getList();

            return response()->json([
                'status' => true,
                'list' => $list
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'status' => false,
                'message' => $throwable->getMessage()
            ]);
        }
    }

    /**
     * Export a list of proxies
     *
     * @return Response
     */
    public function export(Request $request): Response
    {
        try {

            $validator = Validator::make($request->all(), [
                'format' => [
                    'required',
                    'string',
                    Rule::in(ProxyService::ALLOWED_FORMATS)
                ]
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ], 400);
            }

            $format = $request->get('format');

            $list = $this->abstractProviderService->getList();

            $list = $this->proxyService->export($list, $format);

            return response()->make($list, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="exported.csv'
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'status' => false,
                'message' => $throwable->getMessage()
            ]);
        }
    }
}
