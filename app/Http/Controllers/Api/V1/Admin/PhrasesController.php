<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\Phrases\StorePhraseRequest;
use App\Http\Requests\Api\Phrases\UpdatePhraseRequest;
use App\Http\Resources\Admin\PhraseResource;
use App\Repositories\PhraseRepository;
use App\Services\Phrase\PhraseService;
use App\Services\Phrase\Models\PhrasePageableFilter;
use Illuminate\Http\Request;

class PhrasesController extends Controller
{
    private $_phraseRepository;
    private $_phraseService;

    public function __construct(
        PhraseRepository $phraseRepository,
        PhraseService $phraseService
        )
    {
        $this->_phraseRepository = $phraseRepository;
        $this->_phraseService = $phraseService;
    }

    /**
     * @OA\Get(
     *      path="/phrases",
     *      operationId="getPhrasesList",
     *      tags={"Phrases"},
     *      security={{"passport": {*}}},
     *      summary="Get list of phrases",
     *      description="Returns list of phrases",
     *      @OA\Parameter(
     *          name="skip",
     *          description="Number of item to skip",
     *          example=100,
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="limit",
     *          description="Number of item per page",
     *          example=20,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="sort",
     *          description="Column name to sort",
     *          example="id",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PhraseResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/ApiUnAuthException")
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Invalid scope(s) provided.",
     *          @OA\JsonContent(ref="#/components/schemas/ApiAccessDeniedException")
     *      ),
     * )
     */
    public function index(Request $request)
    {
        $filter = new phrasePageableFilter;

        if($request->input('skip'))
            $filter->skip = $request->input('skip');

        if($request->input('limit'))
            $filter->limit = $request->input('limit');

        if($request->input('sort'))
            $filter->sort = $request->input('sort');

        $phrases = $this->_phraseService->getAll($filter);

        return new PhraseResource($phrases);
    }

    /**
     * @OA\Post(
     *      path="/phrases",
     *      operationId="storePhrase",
     *      tags={"Phrases"},
     *      security={{"passport": {"*"}}},
     *      summary="Store new phrase",
     *      description="Returns phrase data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StorePhraseRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Phrase")
     *       ),
     *      @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *          @OA\JsonContent(ref="#/components/schemas/ApiRequestException")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/ApiUnAuthException")
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Invalid scope(s) provided.",
     *          @OA\JsonContent(ref="#/components/schemas/ApiAccessDeniedException")
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(ref="#/components/schemas/ApiUnprocessableEntityException")
     *      ),
     * )
     */
    public function store(StorePhraseRequest $request)
    {
        $phrase = $this->_phraseRepository->storeAsync($request->all());

        return (new PhraseResource($phrase))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Get(
     *      path="/phrases/{id}",
     *      operationId="getPhraseById",
     *      tags={"Phrases"},
     *      security={{"passport": {"*"}}},
     *      summary="Get phrase information",
     *      description="Returns phrase data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Phrase id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Phrase")
     *       ),
     *      @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *          @OA\JsonContent(ref="#/components/schemas/ApiRequestException")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/ApiUnAuthException")
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Invalid scope(s) provided.",
     *          @OA\JsonContent(ref="#/components/schemas/ApiAccessDeniedException")
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Resource Not Found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiNotFoundException")
     *      ),
     * )
     *
     */
    public function show($id)
    {
        $phrase = $this->_phraseRepository->viewAsync($id);

        return new PhraseResource($phrase);
    }

    /**
     * @OA\Put(
     *      path="/phrases/{id}",
     *      operationId="updatePhrase",
     *      tags={"Phrases"},
     *      security={{"passport": {"*"}}},
     *      summary="Update existing phrase",
     *      description="Returns updated phrase data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Phrase id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdatePhraseRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Phrase")
     *       ),
     *      @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *          @OA\JsonContent(ref="#/components/schemas/ApiRequestException")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/ApiUnAuthException")
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Invalid scope(s) provided.",
     *          @OA\JsonContent(ref="#/components/schemas/ApiAccessDeniedException")
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Resource Not Found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiNotFoundException")
     *      ),
     * )
     */
    public function update(UpdatePhraseRequest $request, $id)
    {
        $phrase = $this->_phraseRepository->updateAsync($id, $request->all());

        return (new PhraseResource($phrase))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *      path="/phrases/{id}",
     *      operationId="deletePhrase",
     *      tags={"Phrases"},
     *      security={{"passport": {"*"}}},
     *      summary="Delete existing phrase",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Phrase id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/ApiUnAuthException")
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Invalid scope(s) provided.",
     *          @OA\JsonContent(ref="#/components/schemas/ApiAccessDeniedException")
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Resource Not Found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiNotFoundException")
     *      ),
     * )
     */
    public function destroy($id)
    {
        $result = $this->_phraseRepository->deleteAsync($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
