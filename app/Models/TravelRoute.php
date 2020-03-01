<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TravelRoute
 *
 * @package App\Models
 *
 * @author  Daniel Satiro <danielsatiro2003@yahoo.com.br>
 * @OA\Schema(
 *     title="TravelRoute model",
 *     description="TravelRoute model",
 * )
 */
class TravelRoute extends Model
{
    /**
     * @OA\Property(
     *     description="From",
     *     title="from"
     * )
     *
     * @var string
     */
    public $from;
    /**
     * @OA\Property(
     *     description="To",
     *     title="to"
     * )
     *
     * @var string
     */
    public $to;
    /**
     * @OA\Property(
     *     description="Price",
     *     title="price",
     *     format="int64"
     * )
     *
     * @var integer
     */
    public $price;

    protected $table = 'travel_routes';
    protected $fillable = [
        'from', 'to', 'price',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function validator(array $data) : \Illuminate\Validation\Validator
    {
        $rules = [
            'from' => ['required', 'string', 'max:10'],
            'to' => ['required', 'string', 'max:10'],
            'price' => ['required', 'numeric'],
        ];

        return Validator::make($data, $rules);
    }

    private function findPaths(Collection $list, string $from, string $to) : array
    {
        $paths = [];
        foreach($list as $path) {
            if ($path['from'] == $from && $path['to'] == $to) {
                $paths[] = [$path];
            } elseif ($path['from'] == $from && $path['to'] != $to) {
                $paths[] = array_merge([$path], $this->findPaths($list, $path['to'], $to)[0] ?? [false]);
            }
        }
        return $paths;
    }

    public function findCheapestRoute(string $from, string $to) : array
    {
        $cheapestValue = PHP_INT_MAX;
        $cheapestRoute = '';
        $paths = $this->findPaths($this->all(), $from, $to);

        foreach ($paths as $path) {
            if (empty(end($path))) {
                continue;
            }
            $strRoute = $from;
            $sumPrice = 0;
            foreach ($path as $value) {
                $strRoute .= ",{$value['to']}";
                $sumPrice += $value['price'];
            }
            if ($sumPrice < $cheapestValue) {
                $cheapestValue = $sumPrice;
                $cheapestRoute = $strRoute;
            }
        }

        return [
            'route' => $cheapestRoute,
            'price' => $cheapestValue
        ];
    }
}
