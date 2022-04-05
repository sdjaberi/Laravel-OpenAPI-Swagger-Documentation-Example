<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\Phrases\StorePhraseRequest;
use App\Http\Requests\Api\Phrases\UpdatePhraseRequest;
use App\Http\Resources\Admin\PhraseResource;
use App\Repositories\PhraseRepository;
use App\Services\Base\Mapper;
use App\Services\Phrase\PhraseService;
use App\Services\Phrase\Models\PhrasePageableFilter;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\False_;
use phpDocumentor\Reflection\PseudoTypes\True_;

class PhrasesController extends Controller
{
    private $_phraseRepository;
    private $_phraseService;
    private $_mapper;

    public function __construct(
        PhraseRepository $phraseRepository,
        PhraseService $phraseService,
        Mapper $mapper
        )
    {
        $this->_phraseRepository = $phraseRepository;
        $this->_phraseService = $phraseService;
        $this->_mapper = $mapper;
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
     *          name="page",
     *          description="Page number",
     *          example=1,
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="perPage",
     *          description="Number of item per page",
     *          example=20,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="sortBy",
     *          description="Column name to sort by",
     *          example="id",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="sortDesc",
     *          description="Column name to sort descending",
     *          example="true",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="boolean",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="phrase",
     *          description="Phrase",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="category",
     *          description="Category name",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="phraseCategory",
     *          description="Phrase category name",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
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
        $filterObject = json_decode(json_encode($request->all()), false);

        $filter = new phrasePageableFilter();

        foreach ($filterObject as $key => $value)
            $filter->$key = $value;

        if($filterObject->sortDesc == 'true')
            $filter->$key = True;
        else
            $filter->$key = False;

        $phrases = $this->_phraseService->getAll($filter, ['translations']);
        $phrasesTotal = $this->_phraseService->getCount($filter);

        return new PhraseResource([ 'data' => $phrases, 'total' => $phrasesTotal]);
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
