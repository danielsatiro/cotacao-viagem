<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\OpenApi(
     *     @OA\Info(
     *          version="1.0.0",
     *          title="Cotação de Viagens API",
     *          description="API para cotação de viagens",
     *          @OA\Contact(
     *              email="danielsatiro2003@yahoo.com.br"
     *          ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     *  )
     * )
    */
}
