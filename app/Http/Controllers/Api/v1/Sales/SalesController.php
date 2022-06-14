<?php namespace App\Http\Controllers\Api\v1\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\SalesRequest;
use App\Http\Resources\SaleResource;
use App\Models\Person;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class SalesController extends Controller
{
    private Person $person;

    public function __construct(Person $person)
    {
        $this->person =  $person;
    }

    public function getSale(): JsonResponse
    {
        return SaleResource::collection(auth()->user()->people)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function store(SalesRequest $request): JsonResponse
    {
        $person = $this->person->create($request->all());
        $person->user()->associate(auth()->user());
        $person->save();

        return response()->json(['status' => 'success','message' => 'The record was created.'])->setStatusCode(Response::HTTP_CREATED);
    }
}
