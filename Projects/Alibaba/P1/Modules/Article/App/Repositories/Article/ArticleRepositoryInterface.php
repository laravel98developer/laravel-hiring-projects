<?php

namespace  Modules\Article\App\Repositories\Article;


use Modules\Article\App\Models\Article;

interface ArticleRepositoryInterface
{

    /**
     * Paginate the articles.
     *
     * @param int $per_page The number of articles per page. Default is 50.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginator():\Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * Retrieve articles by user ID.
     *
     * Retrieves a paginated list of articles authored by the specified user ID.
     *
     * @param int $per_page The number of articles per page to retrieve. Default is 50.
     * @param int $userID The ID of the user whose articles are to be retrieved.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Paginated list of articles.
     */
    public function getArticelsByUserID(int $per_page = 50, int $userID): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * Find an Article by ID.
     *
     * @param int $id
     * @return Article|null
     */
    public function find(int $id):Article|null;


    /**
     * Create a new Article.
     *
     * @param array $data
     * @return Article
     */
    public function create(array $data):Article;

    /**
     * Update an Article by ID.
     *
     * @param int $id
     * @param array $data
     * @return Article|null
     */
    public function update(int $id, array $data):bool;


    /**
     * Delete an Article by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id):bool;
}
