<?php

namespace Modules\Article\App\Services\Article;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Modules\Article\App\Models\Article;
use Modules\Article\App\Repositories\Article\ArticleRepositoryInterface;

class ArticleService implements ArticleServiceInterface
{
    /**
     * @var ArticleRepositoryInterface
     */
    protected $articleRepository;


    /**
     * ArticleService constructor.
     *
     * @param ArticleRepositoryInterface $articleRepository
     *
     */
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }


    /**
     * Get articles as pagination.
     *
     * @param array $data
     * @return Paginator
     */
    public function getArticlePaginate(?array $data): Paginator
    {
        if (!isset($data['perPage'])) {
            $data['perPage'] = 20;
        }
        return $this->articleRepository->paginator($data['perPage']);
    }

    /**
     * Paginate the articles.
     *
     * @param int $per_page The number of articles per page. Default is 50.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getArticelsByUserID(?array $data): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        if (!isset($data['perPage'])) {
            $data['perPage'] = 20;
        }
        $userID=Auth::id();
        return $this->articleRepository->getArticelsByUserID($data['perPage'],$userID);
    }

    /**
     * Create a new Article with the provided data.
     *
     * @param array $data The data for the new Article.
     *
     * @return Article The created Article instance.
     *
     * @throws \Exception If there is an error while creating the Article.
     */
    public function create(array $data): Article
    {
        $data["user_id"]=Auth::id();
        return $this->articleRepository->create($data);
    }

    /**
     * Find an Article by its ID.
     *
     * @param int $id The ID of the Article to find.
     *
     * @return Article|null The found Article instance or null if not found.
     */
    public function findById(int $id): ?Article
    {
        return $this->articleRepository->find($id);
    }

    /**
     * Update an article in the repository.
     *
     * @param int $id The ID of the article to update.
     * @param array $data The data to update the article with.
     *
     * @return bool True if the update was successful, false otherwise.
     */
    public function update(int $id, array $data): bool
    {
        return $this->articleRepository->update($id, $data);
    }

    /**
     * Change the status of an article.
     *
     * This method updates the status of the article with the given ID using the provided data.
     * The status can be either "draft" or "publish".
     * It delegates the update operation to the underlying article repository.
     *
     * @param int $id The ID of the article to update.
     * @param array $data The data containing the new status information. Status can be "draft" or "publish".
     * @return bool Returns true if the article status was successfully updated, false otherwise.
     */
    public function changeStatusArticle(int $id, array $data): bool
    {
        return $this->articleRepository->update($id, $data);
    }

    /**
     * Delete an article by its ID.
     *
     * This method deletes the article with the specified ID from the storage via the article repository.
     *
     * @param int $id The ID of the article to delete.
     * @return bool Returns true if the article was successfully deleted, false otherwise.
     */
    public function deleteById(int $id): bool
    {
        return $this->articleRepository->deleteById($id);
    }
}
