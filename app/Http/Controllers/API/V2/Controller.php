<?php

namespace App\Http\Controllers\API\V2;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Store the pagesize.
     *
     * @var int
     */
    protected $pageSize;

    /**
     * The constructor checks for a "page" parameter.
     *
     * @see https://laravel.com/docs/5.2/pagination#paginating-eloquent-results
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        // set the page size
        $this->pageSize = $request->has('per_page') ? $request->input('per_page') : $request->input('size', 20);

        if (!$request->has('page') && $request->has('offset')) {
            // if no "page" parameter is set, but we have an "offset" parameter,
            // calculate and set a "page" parameter, since the paginator expects it
            $offset = $request->input('offset', 0);
            $request->offsetSet('page', floor(($offset / $this->pageSize) + 1));
        }
    }

    /**
     * Get filtered and ordered results.
     * Only fillable fields are used in filters.
     * Order can be prefixed with "-" for descending order.
     *
     * @see https://laravel.com/docs/5.2/queries
     *
     * @param Request $request
     * @param Model   $model
     *
     * @return Builder
     */
    protected function filteredAndOrdered(Request $request, Model $model)
    {
        $fillable = $model->getFillable();
        $query = $model->newQuery();

        foreach ($request->all() as $key => $value) {
            // skip filter if not in fillable fields
            if (!in_array($key, $fillable)) {
                continue;
            }

            $query->where($key, $value);
        }

        if ($request->q) {
            // search all fillable fields for the search query
            $query->where(function (Builder $query) use ($request, $fillable) {
                foreach ($fillable as $field) {
                    $query->orWhere($field, 'LIKE', '%'.$request->q.'%');
                }
            });
        }

        if ($request->order) {
            // multiple orderBys are possible with a comma separated string
            $order = explode(',', $request->order);

            foreach ($order as $orderby) {
                $hasPrefix = in_array(substr($orderby, 0, 1), ['-', '+']);

                // if key is preceed by a minus, then the order is descending
                $direction = substr($orderby, 0, 1) == '-' ? 'DESC' : 'ASC';

                // remove order prefixes
                $orderby = $hasPrefix ? substr($orderby, 1) : $orderby;

                $query->orderBy($orderby, $direction);
            }
        }

        return $query;
    }

    /**
     * Support embedded resources. Also support nested resources.
     *
     * @see https://laravel.com/docs/5.2/eloquent-relationships#eager-loading
     *
     * @param Request $request
     * @param Model   $model
     *
     * @return Model
     */
    public function attachResources(Request $request, Model $model)
    {
        if (!$request->has('embed')) {
            return $model;
        }

        foreach (explode(',', $request->embed) as $resource) {
            $model->load($resource);
        }

        return $model;
    }
}
