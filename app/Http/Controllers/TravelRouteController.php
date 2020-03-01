<?php

namespace App\Http\Controllers;

use App\Models\TravelRoute;
use Illuminate\Http\Request;

class TravelRouteController extends Controller
{
    private $travelRoute;

    public function __construct(TravelRoute $travelRoute)
    {
        $this->travelRoute = $travelRoute;
    }

    /**
     * @OA\Get(
     *      path="/api/quote/{from}/{to}",
     *      operationId="quote",
     *      tags={"route"},
     *      summary="Travel quote",
     *      @OA\Parameter(
     *          name="from",
     *          in="path",
     *          description="From",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="to",
     *          in="path",
     *          description="To",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     )
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function quote(string $from, string $to)
    {
        $cheapestRoute = $this->travelRoute->findCheapestRoute($from, $to);

        if (empty($cheapestRoute['route'])) {
            return response()->json([], 404);
        }
        return response()->json($cheapestRoute, 200);
    }

    /**
     * @OA\Post(
     *      path="/api/route",
     *      operationId="store",
     *      tags={"route"},
     *      summary="Register route",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation exception"
     *     ),
     *      @OA\RequestBody(
     *         description="Register Route",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TravelRoute"),
     *     )
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
        $data = $request->all();

        $this->travelRoute->validator($data)->validate();

        $travel = TravelRoute::updateOrCreate([
            'from' => $data['from'],
            'to' => $data['to'],
        ], $data);

        return response()->json($travel);
    }
}
