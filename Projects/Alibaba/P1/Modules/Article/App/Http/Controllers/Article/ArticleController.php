<?php

namespace Modules\Article\App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Article\App\Http\Requests\Article\ChangeStatusArticleRequest;
use Modules\Article\App\Http\Requests\Article\DeleteArticleRequest;
use Modules\Article\App\Http\Requests\Article\FindByIdRequest;
use Modules\Article\App\Http\Requests\Article\GetArticleByUserPaginateRequest;
use Modules\Article\App\Http\Requests\Article\GetArticlePaginateRequest;
use Modules\Article\App\Http\Requests\Article\UpdateArticleRequest;
use Modules\Article\App\Services\Article\ArticleService;
use Modules\Article\App\Http\Requests\Article\CreateArticleRequest;

class ArticleController extends Controller
{
    private $articleService;

    /**
     * ArticleController constructor.
     *
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Get articles as pagination.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getArticlePaginate(GetArticlePaginateRequest $request):JsonResponse
    {
        $articles= $this->articleService->getArticlePaginate($request->all());
        return response()->json($articles);
    }

    /**
     * Create a new Article.
     *
     * @param CreateArticleRequest $request
     * @return mixed
     */
    public function store(CreateArticleRequest $request)
    {
        return $this->articleService->create($request->all());
    }

    /**
     * Paginate the articles.
     *
     * @param GetArticleByUserPaginateRequest $request
     * @return mixed
     */
    public function getArticelsByUserID(GetArticleByUserPaginateRequest $request)
    {
        return $this->articleService->getArticelsByUserID($request->all());
    }

    /**
     * Find an Article by ID.
     *
     * @param FindByIdRequest $request
     * @return mixed
     */
    public function findById(FindByIdRequest $request,$id)
    {
        return $this->articleService->findById($id);
    }

    /**
     * Update the article with the given ID using the data from the update article request.
     *
     * @param UpdateArticleRequest $request The update article request containing the validation rules and data.
     * @param int $id The ID of the article to update.
     *
     * @return mixed Returns the result of the update operation handled by the article service.
     */
    public function update(UpdateArticleRequest $request,$id)
    {
        return $this->articleService->update($id,$request->all());
    }

    /**
     * Change the status of an article.
     *
     * This method updates the status of the article with the given ID using the provided data.
     * The status can be either "draft" or "publish".
     * It delegates the update operation to the underlying article repository.
     *
     * @param int $id The ID of the article to update.
     * @param FindByIdRequest $request
     * @return bool Returns true if the article status was successfully updated, false otherwise.
     */
    public function changeStatusArticle(ChangeStatusArticleRequest $request,int $id): bool
    {
        return $this->articleService->changeStatusArticle($id,$request->all());
    }

    /**
     * Delete the article with the given ID using the delete article request.
     *
     * @param DeleteArticleRequest $request The delete article request.
     * @param int $id The ID of the article to delete.
     *
     * @return bool Returns true if the article is successfully deleted; otherwise, returns false.
     */
    public function delete(DeleteArticleRequest $request,$id)
    {
        return $this->articleService->deleteById($id);
    }
}
