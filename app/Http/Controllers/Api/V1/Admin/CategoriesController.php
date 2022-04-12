<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\Categories\StoreCategoryRequest;
use App\Http\Requests\Api\Categories\UpdateCategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Repositories\CategoryRepository;
use App\Services\Base\Mapper;
use App\Services\Category\CategoryService;
use App\Services\Category\Models\CategoryPageableFilter;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private $_categoryRepository;
    private $_categoryService;
    private $_mapper;

    public function __construct(
        CategoryRepository $categoryRepository,
        CategoryService $categoryService,
        Mapper $mapper
        )
    {
        $this->_categoryRepository = $categoryRepository;
        $this->_categoryService = $categoryService;
        $this->_mapper = $mapper;
    }

    /**
     * @OA\Get(
     *      path="/categories",
     *      operationId="getCategoriesList",
     *      tags={"Categories"},
     *      security={{"passport": {*}}},
     *      summary="Get list of categories",
     *      description="Returns list of categories",
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
     *          name="category",
     *          description="Category name",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="project",
     *          description="Project name",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResource")
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

        $filter = new categoryPageableFilter();

        foreach ($filterObject as $key => $value)
        {
            if(!$value)
                continue;

            $filter->$key = $value;

            if($key == "sortDesc" && $value == "false")
                $filter->$key = False;
        }

        $categories = $this->_categoryService->getAll($filter, ['project']);
        $categoriesTotal = $this->_categoryService->getCount($filter);

        return new CategoryResource([ 'data' => $categories, 'total' => $categoriesTotal]);
    }

    /**
     * @OA\Post(
     *      path="/categories",
     *      operationId="storeCategory",
     *      tags={"Categories"},
     *      security={{"passport": {"*"}}},
     *      summary="Store new category",
     *      description="Returns category data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreCategoryRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryOut")
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
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->_categoryRepository->storeAsync($request->all());

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Get(
     *      path="/categories/{name}",
     *      operationId="getCategoryByName",
     *      tags={"Categories"},
     *      security={{"passport": {"*"}}},
     *      summary="Get category information",
     *      description="Returns category data",
     *      @OA\Parameter(
     *          name="name",
     *          description="Category name",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryOut")
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
        $category = $this->_categoryRepository->viewAsync($id);

        return new CategoryResource($category);
    }

    /**
     * @OA\Put(
     *      path="/categories/{name}",
     *      operationId="updateCategory",
     *      tags={"Categories"},
     *      security={{"passport": {"*"}}},
     *      summary="Update existing category",
     *      description="Returns updated category data",
     *      @OA\Parameter(
     *          name="name",
     *          description="Category name",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateCategoryRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryOut")
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
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->_categoryRepository->updateAsync($id, $request->all());

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *      path="/categories/{name}",
     *      operationId="deleteCategory",
     *      tags={"Categories"},
     *      security={{"passport": {"*"}}},
     *      summary="Delete existing category",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="name",
     *          description="Category name",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
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
        $result = $this->_categoryRepository->deleteAsync($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
