<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

interface UserRepositoryInterface
{

    /**
     * Get users as pagination.
     *
     * @param array $data
     * @return Paginator
     */
    public function getUserPaginate(?array $data): Paginator;

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * Find a user by their ID.
     *
     * @param int $userId
     * @return User|null
     */
    public function findById(int $userId): ?User;

    /**
     * Find a user randomly based on their role.
     *
     * @param string|null $role
     * @return User|null
     */
    public function findRandomly(?string $role): ?User;

    /**
     * Find a user by their email address.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * Find a user by their mobile number.
     *
     * @param string $mobile
     * @return User|null
     */
    public function findByMobile(string $mobile): ?User;

    /**
     * Update a user's information.
     *
     * @param array $data
     * @param int $userId
     * @return User|null
     */
    public function update(array $data, int $userId): ?User;

    /**
     * Delete a user by their ID.
     *
     * @param int $userId
     * @return bool
     */
    public function delete(int $userId): bool;
}
