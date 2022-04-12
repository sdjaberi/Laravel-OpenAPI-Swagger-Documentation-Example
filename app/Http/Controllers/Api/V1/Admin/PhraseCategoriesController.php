<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\PhraseCategories\StorePhraseCategoryRequest;
use App\Http\Requests\Api\PhraseCategories\UpdatePhraseCategoryRequest;
use App\Http\Resources\Admin\PhraseCategoryResource;
use App\Repositories\PhraseCategoryRepository;
use App\Services\Base\Mapper;
use App\Services\PhraseCategory\PhraseCategoryService;
use App\Services\PhraseCategory\Models\PhraseCategoryPageableFilter;
use Illuminate\Http\Request;

class PhraseCategoriesController extends Controller
{
    private $_phraseCategoryRepository;
    private $_phraseCategoryService;
    private $_mapper;

    public function __construct(
        PhraseCategoryRepository $phraseCategoryRepository,
        PhraseCategoryService $phraseCategoryService,
        Mapper $mapper
        )
    {
        $this->_phraseCategoryRepository = $phraseCategoryRepository;
        $this->_phraseCategoryService = $phraseCategoryService;
        $this->_mapper = $mapper;
    }

    /**
     * @OA\Get(
     *      path="/phrase-categories",
     *      operationId="getPhraseCategoriesList",
     *      tags={"Phrase Categories"},
     *      security={{"passport": {*}}},
     *      summary="Get list of phraseCategories",
     *      description="Returns list of phraseCategories",
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
     *          example="name",
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
     *          name="phraseCategory",
     *          description="Phrase Category Name",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PhraseCategoryResource")
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

        $filter = new phraseCategoryPageableFilter();

        foreach ($filterObject as $key => $value)
        {
            if(!$value)
                continue;

            $filter->$key = $value;

            if($key == "sortDesc" && $value == "false")
                $filter->$key = False;
        }

        $phraseCategories = $this->_phraseCategoryService->getAll($filter, ['phrases']);
        $phraseCategoriesTotal = $this->_phraseCategoryService->getCount($filter);

        return new PhraseCategoryResource([ 'data' => $phraseCategories, 'total' => $phraseCategoriesTotal]);
    }

    /**
     * @OA\Post(
     *      path="/phrase-categories",
     *      operationId="storePhraseCategory",
     *      tags={"Phrase Categories"},
     *      security={{"passport": {"*"}}},
     *      summary="Store new phraseCategory",
     *      description="Returns phraseCategory data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StorePhraseCategoryRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PhraseCategoryOut")
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
    public function store(StorePhraseCategoryRequest $request)
    {
        $phraseCategory = $this->_phraseCategoryRepository->storeAsync($request->all());

        return (new PhraseCategoryResource($phraseCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Get(
     *      path="/phrase-categories/{id}",
     *      operationId="getPhraseCategoryById",
     *      tags={"Phrase Categories"},
     *      security={{"passport": {"*"}}},
     *      summary="Get phraseCategory information",
     *      description="Returns phraseCategory data",
     *      @OA\Parameter(
     *          name="id",
     *          description="PhraseCategory id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PhraseCategoryOut")
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
        $phraseCategory = $this->_phraseCategoryRepository->viewAsync($id);

        return new PhraseCategoryResource($phraseCategory);
    }

    /**
     * @OA\Put(
     *      path="/phrase-categories/{id}",
     *      operationId="updatePhraseCategory",
     *      tags={"Phrase Categories"},
     *      security={{"passport": {"*"}}},
     *      summary="Update existing phraseCategory",
     *      description="Returns updated phraseCategory data",
     *      @OA\Parameter(
     *          name="id",
     *          description="PhraseCategory id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdatePhraseCategoryRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PhraseCategoryOut")
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
    public function update(UpdatePhraseCategoryRequest $request, $id)
    {
        $phraseCategory = $this->_phraseCategoryRepository->updateAsync($id, $request->all());

        return (new PhraseCategoryResource($phraseCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *      path="/phrase-categories/{id}",
     *      operationId="deletePhraseCategory",
     *      tags={"Phrase Categories"},
     *      security={{"passport": {"*"}}},
     *      summary="Delete existing phraseCategory",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="PhraseCategory id",
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
        $result = $this->_phraseCategoryRepository->deleteAsync($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
