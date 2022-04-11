<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\Translations\StoreTranslationRequest;
use App\Http\Requests\Api\Translations\UpdateTranslationRequest;
use App\Http\Resources\Admin\TranslationResource;
use App\Repositories\TranslationRepository;
use App\Services\Base\Mapper;
use App\Services\Translation\TranslationService;
use App\Services\Translation\Models\TranslationPageableFilter;
use Illuminate\Http\Request;

class TranslationsController extends Controller
{
    private $_translationRepository;
    private $_translationService;
    private $_mapper;

    public function __construct(
        TranslationRepository $translationRepository,
        TranslationService $translationService,
        Mapper $mapper
        )
    {
        $this->_translationRepository = $translationRepository;
        $this->_translationService = $translationService;
        $this->_mapper = $mapper;
    }

    /**
     * @OA\Get(
     *      path="/translations",
     *      operationId="getTranslationsList",
     *      tags={"Translations"},
     *      security={{"passport": {*}}},
     *      summary="Get list of translations",
     *      description="Returns list of translations",
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
     *          example=true,
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="boolean",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="q",
     *          description="Search Query",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="translation",
     *          description="Translation",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
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
     *          name="phraseId",
     *          description="Phrase Id",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="language",
     *          description="Language Title",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="languageId",
     *          description="Language Id",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="user",
     *          description="User Name",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="userId",
     *          description="User Id",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TranslationResource")
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

        $filter = new translationPageableFilter();

        foreach ($filterObject as $key => $value)
        {
            if(!$value)
                continue;

            $filter->$key = $value;

            if($key == "sortDesc" && $value == "false")
                $filter->$key = False;
        }

        $translations = $this->_translationService->getAll($filter, ['phrase', 'language', 'author']);
        $translationsTotal = $this->_translationService->getCount($filter);

        return new TranslationResource([ 'data' => $translations, 'total' => $translationsTotal]);
    }

    /**
     * @OA\Post(
     *      path="/translations",
     *      operationId="storeTranslation",
     *      tags={"Translations"},
     *      security={{"passport": {"*"}}},
     *      summary="Store new translation",
     *      description="Returns translation data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreTranslationRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TranslationOut")
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
    public function store(StoreTranslationRequest $request)
    {
        $translation = $this->_translationRepository->storeAsync($request->all());

        return (new TranslationResource($translation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Get(
     *      path="/translations/{id}",
     *      operationId="getTranslationById",
     *      tags={"Translations"},
     *      security={{"passport": {"*"}}},
     *      summary="Get translation information",
     *      description="Returns translation data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Translation id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TranslationOut")
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
        $translation = $this->_translationRepository->viewAsync($id);

        return new TranslationResource($translation);
    }

    /**
     * @OA\Put(
     *      path="/translations/{id}",
     *      operationId="updateTranslation",
     *      tags={"Translations"},
     *      security={{"passport": {"*"}}},
     *      summary="Update existing translation",
     *      description="Returns updated translation data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Translation id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateTranslationRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TranslationOut")
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
    public function update(UpdateTranslationRequest $request, $id)
    {
        $translation = $this->_translationRepository->updateAsync($id, $request->all());

        return (new TranslationResource($translation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *      path="/translations/{id}",
     *      operationId="deleteTranslation",
     *      tags={"Translations"},
     *      security={{"passport": {"*"}}},
     *      summary="Delete existing translation",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Translation id",
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
        $result = $this->_translationRepository->deleteAsync($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
