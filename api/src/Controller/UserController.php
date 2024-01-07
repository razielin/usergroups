<?php
namespace App\Controller;

use App\Exceptions\BaseException;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends BaseController
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/users")
     */
    public function users(): Response
    {
        $res = $this->userService->allUsers();
        return $this->toOkJsonResponse($res);
    }

    /**
     * @Route("/users/add")
     */
    public function addUser(Request $request): Response
    {
        try {
            $data = $this->parseJsonRequest($request);
            $user = $this->userService->addUser($data['name'], $data['email']);
            return $this->toOkJsonResponse($user);
        } catch (BaseException $e) {
            return $this->toFailJsonResponse([$e->getMessage()]);
        }
    }

    /**
     * @Route("/users/edit")
     */
    public function editUser(Request $request): Response
    {
        try {
            $data = $this->parseJsonRequest($request);
            $user = $this->userService->editUser($data['user_id'], $data['name'], $data['email']);
            return $this->toOkJsonResponse($user);
        } catch (BaseException $e) {
            return $this->toFailJsonResponse([$e->getMessage()]);
        }
    }

    /**
     * @Route("/users/delete")
     */
    public function deleteUser(Request $request): Response
    {
        try {
            $data = $this->parseJsonRequest($request);
            $this->userService->deleteUser($data['user_id']);
            return $this->toOkJsonResponse(true);
        } catch (BaseException $e) {
            return $this->toFailJsonResponse([$e->getMessage()]);
        }
    }

    /**
     * @Route("/users/report")
     */
    public function getUsersWithGroups(): Response
    {
        $res = $this->userService->getUsersWithGroups();
        return $this->toOkJsonResponse($res);
    }

    /**
     * @Route("/users/groups/add")
     */
    public function addUserGroup(Request $request): Response
    {
        try {
            $data = $this->parseJsonRequest($request);
            $res = $this->userService->addUserGroup($data['user_id'], $data['group_id']);
            return $this->toOkJsonResponse($res);
        } catch (BaseException $e) {
            return $this->toFailJsonResponse([$e->getMessage()]);
        }
    }

    /**
     * @Route("/users/groups/delete")
     */
    public function deleteUserGroup(Request $request): Response
    {
        try {
            $data = $this->parseJsonRequest($request);
            $res = $this->userService->deleteUserGroup($data['user_id'], $data['group_id']);
            return $this->toOkJsonResponse($res);
        } catch (BaseException $e) {
            return $this->toFailJsonResponse([$e->getMessage()]);
        }
    }
}
