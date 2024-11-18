<?php

namespace App\Http\Controllers;

use App\Http\Requests\Forum\ActivateForumUserRequest;
use App\Http\Requests\Forum\DeactivateForumUserRequest;
use App\Http\Requests\User\SearchUserForumRequest;
use App\Http\Requests\User\SearchUserRequest;
use App\Http\Requests\PaginationRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private UserService $userService;

    /**
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param SearchUserRequest $request
     * @param PaginationRequest $pagination
     * @return JsonResponse
     */
    public function index(SearchUserRequest $request, PaginationRequest $pagination): JsonResponse
    {
        $paginator = $this->userService->findByFilter(
            $request->validated(),
            $pagination->validated()
        );

        return $this->responseForPaginator($paginator);
    }

    public function getUsersByForum(SearchUserForumRequest $request, PaginationRequest $pagination): JsonResponse
    {
        $paginator = $this->userService->findByFilter(
            $request->validated(),
            $pagination->validated()
        );

        return $this->responseForPaginator($paginator);
    }

    public function getAllUsersByForum(SearchUserForumRequest $request): JsonResponse
    {
        $paginator = $this->userService->findByFilter(
            $request->validated(),
        );

        return $this->responseForFind($paginator);
    }

    public function activateForum(ActivateForumUserRequest $request, int $id): Response
    {
        $this->userService->activate($id);

        return $this->responseForUpdate();
    }

    public function deactivateForum(DeactivateForumUserRequest $request, int $id): Response
    {
        $this->userService->deactivate($id);

        return $this->responseForUpdate();
    }
}
