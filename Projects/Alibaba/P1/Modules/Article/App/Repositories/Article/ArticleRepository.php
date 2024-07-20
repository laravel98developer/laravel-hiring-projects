<?php

namespace Modules\Article\App\Repositories\Article;

use Illuminate\Support\Facades\Auth;
use Modules\Article\App\Models\Article;

/**
 * Class ArticleRepository
 *
 * @package App\Repositories
 */
class ArticleRepository implements ArticleRepositoryInterface
{

    /**
     * Paginate the articles.
     *
     * @param int $per_page The number of articles per page. Default is 50.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginator(int $per_page = 50): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Article::query()->paginate($per_page);
    }


    /**
     * Retrieve articles by user ID.
     *
     * Retrieves a paginated list of articles authored by the specified user ID.
     *
     * @param int $per_page The number of articles per page to retrieve. Default is 50.
     * @param int $userID The ID of the user whose articles are to be retrieved.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Paginated list of articles.
     */
    public function getArticelsByUserID(int $per_page = 50, int $userID): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Article::query()->where("user_id", $userID)->paginate($per_page);
    }


    /**
     * Find an Article by ID.
     *
     * @param int $id
     * @return Article|null
     */
    public function find(int $id):Article|null
    {
        return Article::with(["user"])->find($id);
    }

    /**
     * Create a new Article.
     *
     * @param array $data
     * @return Article
     */
    public function create(array $data):Article
    {
        return Article::create($data);
    }

    /**
     * Update an Article by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool Returns true if the Article has been processed successfully, false otherwise.
     */
    public function update(int $id, array $data):bool
    {
        $article = Article::where("id", $id)->update($data);
        if ($article) {
            return true;
        }
        return false;
    }

    /**
     * Delete an Article by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id):bool
    {
        $article = Article::where("id", $id)->delete();
        if ($article) {
            return true;
        }
        return false;
    }

}
