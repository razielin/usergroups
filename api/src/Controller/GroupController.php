<?php
namespace App\Controller;

use App\Exceptions\BaseException;
use App\Service\GroupService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends BaseController
{
    private GroupService $groupsService;

    public function __construct(GroupService $groupsService)
    {
        $this->groupsService = $groupsService;
    }

    /**
     * @Route("/groups")
     */
    public function groups(): Response
    {
        $res = $this->groupsService->allGroups();
        return $this->toOkJsonResponse($res);
    }

    /**
     * @Route("/groups/add")
     */
    public function addGroup(Request $request): Response
    {
        try {
            $data = $this->parseJsonRequest($request);
            $group = $this->groupsService->addGroup($data['group_name']);
            return $this->toOkJsonResponse($group);
        } catch (BaseException $e) {
            return $this->toFailJsonResponse([$e->getMessage()]);
        }
    }

    /**
     * @Route("/groups/edit")
     */
    public function editGroup(Request $request): Response
    {
        try {
            $data = $this->parseJsonRequest($request);
            $group = $this->groupsService->editGroup($data['group_id'], $data['group_name']);
            return $this->toOkJsonResponse($group);
        } catch (BaseException $e) {
            return $this->toFailJsonResponse([$e->getMessage()]);
        }
    }

    /**
     * @Route("/groups/delete")
     */
    public function deleteGroup(Request $request): Response
    {
        try {
            $data = $this->parseJsonRequest($request);
            $this->groupsService->deleteGroup($data['group_id']);
            return $this->toOkJsonResponse(true);
        } catch (BaseException $e) {
            return $this->toFailJsonResponse([$e->getMessage()]);
        }
    }

    /**
     * @Route("/groups/report")
     */
    public function getUsersWithGroups(): Response
    {
        $res = $this->groupsService->getGroupsWithUsers();
        return $this->toOkJsonResponse($res);
    }
}
