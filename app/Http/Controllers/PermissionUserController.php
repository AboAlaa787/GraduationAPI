<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Permission_user;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use App\Traits\CRUDTrait;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

/**
 * @group Permissions_Users management
 */
class PermissionUserController extends Controller
{
    use ApiResponseTrait;
    use CRUDTrait;

    /**
     * @param Request $request
     * @queryParam with string To query related data. No-example
     * @queryParam orderBy To sort data. No-example
     * @queryParam dir To determine the direction of the sort, default is asc. Example:[asc,desc]
     * @queryParam page integer To specify the page number to be retrieved, Default is 1. Example:1
     * @queryParam per_page integer To specify the number of records per page, Default is 20. Example:10
     * @queryParam all_data integer To ignore pagination process, Default is 0, Allowed values is 0,1. No-example
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Permission_user(), $request, str($request->with));
    }

    /**
     * @param $id
     * @param Request $request
     * @urlParam  id  integer required The ID of the Permission_User.
     * @queryParam with string To query related data. No-example
     * @return JsonResponse
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Permission_user(), $id, str($request->with));
    }

    /**
     * @param Request $request
     * @bodyParam permissions_ids integer[] permissions numbers to be added to the user.
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), ['permissions_ids' => 'required|array'
            , 'user_id' => 'required|exists:users,id'
        ]);
        if ($validation->fails()) {
            return $this->apiResponse($validation->messages(), 422, 'Failed');
        }
        try {
            $this->authorize('create', Permission_user::class);
            $permissionsIds = $request->get('permissions_ids', []);
            $userId = $request->get('user_id');
            if (empty($permissionsIds)) {
                return $this->apiResponse(null, 422, 'Error: At least one of permissions_ids is required.');
            }

            return DB::transaction(function () use ($permissionsIds, $userId) {
                $user = User::findOrFail($userId);
                $this->attachPermissionsToClient($permissionsIds, $user);
                $user->load(['permissions']);
                return $this->apiResponse($user);
            });
        } catch (InvalidArgumentException $exception) {
            return $this->apiResponse(null, 400, 'Error: ' . $exception->getMessage());

        } catch (ModelNotFoundException $exception) {
            $model = explode('\\', $exception->getModel());
            $model = end($model);
            $id = $exception->getIds()[0];
            return $this->apiResponse(null, 404, "Error: $model with ID $id not found.");

        } catch (AuthorizationException $exception) {
            return $this->apiResponse(null, 403, 'Error: ' . $exception->getMessage());
        }
    }

    protected function attachPermissionsToClient($permissionsIds, $user): void
    {
        if (!is_array($permissionsIds)) {
            throw new InvalidArgumentException('permissions_ids must be an array.');
        }
        foreach ($permissionsIds as $permissionId) {
            $permission = Permission::findOrFail($permissionId);
            if ($user->Permissions->contains($permission->id)) {
                throw new InvalidArgumentException('Error: id ' . $permissionId . ' in permissions_ids is already attached to the user.');
            }
            $user->Permissions()->attach($permissionId);
        }
    }

    /**
     * @param $id
     * @urlParam  id  integer required The ID of the Permission_User.
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Permission_user());
    }

    public function delete($userId, $permissionId): JsonResponse
    {
        try {
            $this->authorize('delete', Permission_user::class);
            $permissionUser = Permission_user::where('user_id', $userId)->where('permission_id', $permissionId)->firstOrFail();
            $permissionUser->delete();
            return $this->apiResponse(null, 200, 'Delete successfuly');
        } catch (ModelNotFoundException $exception) {
            return $this->apiResponse(null, 404, 'Not Found');
        } catch (AuthorizationException $exception) {
            return $this->apiResponse(null, 403, 'Error: ' . $exception->getMessage());
        } catch (Exception $exception) {
            return $this->apiResponse(null, 500, 'Server Error');
        }
    }
}
