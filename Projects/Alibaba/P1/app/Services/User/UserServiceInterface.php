<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

interface UserServiceInterface
{

    /**
     * Get users as pagination.
     *
     * @param array $data
     * @return Paginator
     */
    public function getUserPaginate(?array $data): Paginator;

    /**
     * Get a user by their ID.
     *
     * @param int $userId
     * @return User|null
     */
    public function getUserById(int $userId): ?User;

    /**
     * Get a user by their email address.
     *
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User;

    /**
     * Get a user by their mobile number.
     *
     * @param string $mobile
     * @return User|null
     */
    public function getUserByMobile(string $mobile): ?User;

    /**
     * Find a user randomly based on their role.
     *
     * @param string|null $role
     * @return User|null
     */
    public function findRandomly(?string $role): ?User;

    /**
     * Find a user by their ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * Update a user's information.
     *
     * @param array $userData
     * @param int $userId
     * @return bool
     */
    public function updateUser(array $userData, int $userId): bool;


    /**
     * Create a user's information.
     *
     * @param array $userData
     * @return User
     */
    public function createUser(array $userData): User;


    /**
     * Register a new User.
     *
     * @param array $userData
     * @return User
     */
    public function register(array $userData): User;


    /**
     * Delete a user by their ID.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId): bool;
}
