<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * Get users as pagination.
     *
     * @param array $data
     * @return Paginator
     */
    public function getUserPaginate(?array $data): Paginator
    {
        if (!isset($data['perPage'])){$data['perPage']=20;}
        return $this->userRepository->getUserPaginate($data);
    }

    /**
     * Get a user by their ID.
     *
     * @param int $userId
     * @return User|null
     */
    public function getUserById(int $userId): ?User
    {
        return $this->userRepository->findById($userId);
    }

    /**
     * Get a user by their email address.
     *
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * Get a user by their mobile number.
     *
     * @param string $mobile
     * @return User|null
     */
    public function getUserByMobile(string $mobile): ?User
    {
        return $this->userRepository->findByMobile($mobile);
    }

    /**
     * Find a user randomly based on their role.
     *
     * @param string|null $role
     * @return User|null
     */
    public function findRandomly(?string $role): ?User
    {
        return $this->userRepository->findRandomly($role);
    }

    /**
     * Find a user by their ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return $this->userRepository->findById($id)->generate_token();
    }

    /**
     * Update a user's information.
     *
     * @param array $userData
     * @param int $userId
     * @return bool
     */
    public function updateUser(array $userData, int $userId): bool
    {
        return $this->userRepository->update($userData, $userId);
    }

    /**
     * Create a user's information.
     *
     * @param array $userData
     * @return User
     */
    public function createUser(array $userData): User
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->create($userData);
            DB::commit();
            return $user;

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    /**
     * Register a new User.
     *
     * @param array $userData
     * @return User
     */
    public function register(array $userData): User
    {
        return $this->userRepository->create($userData)->generate_token();
    }

    /**
     * Delete a user by their ID.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId): bool
    {
        return $this->userRepository->delete($userId);
    }
}
