<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\Projects\StoreProjectRequest;
use App\Http\Requests\Api\Projects\UpdateProjectRequest;
use App\Http\Resources\Admin\ProjectResource;
use App\Repositories\ProjectRepository;

class ProjectsController extends Controller
{
    private $_projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->_projectRepository = $projectRepository;
    }

    /**
     * @OA\Get(
     *      path="/projects",
     *      operationId="getProjectsList",
     *      tags={"Projects"},
     *      security={{"passport": {*}}},
     *      summary="Get list of projects",
     *      description="Returns list of projects",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ProjectResource")
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
    public function index()
    {
        $projects = $this->_projectRepository->getAllData();

        return new ProjectResource($projects);
    }

    /**
     * @OA\Post(
     *      path="/projects",
     *      operationId="storeProject",
     *      tags={"Projects"},
     *      security={{"passport": {"*"}}},
     *      summary="Store new project",
     *      description="Returns project data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreProjectRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Project")
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
    public function store(StoreProjectRequest $request)
    {
        $project = $this->_projectRepository->store($request->all());

        return (new ProjectResource($project))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Get(
     *      path="/projects/{id}",
     *      operationId="getProjectById",
     *      tags={"Projects"},
     *      security={{"passport": {"*"}}},
     *      summary="Get project information",
     *      description="Returns project data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Project id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Project")
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
        $project = $this->_projectRepository->view($id);

        return new ProjectResource($project);
    }

    /**
     * @OA\Put(
     *      path="/projects/{id}",
     *      operationId="updateProject",
     *      tags={"Projects"},
     *      security={{"passport": {"*"}}},
     *      summary="Update existing project",
     *      description="Returns updated project data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Project id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateProjectRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Project")
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
    public function update(UpdateProjectRequest $request, $id)
    {
        $project = $this->_projectRepository->update($id, $request->all());

        return (new ProjectResource($project))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *      path="/projects/{id}",
     *      operationId="deleteProject",
     *      tags={"Projects"},
     *      security={{"passport": {"*"}}},
     *      summary="Delete existing project",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Project id",
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
        $project = $this->_projectRepository->delete($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
