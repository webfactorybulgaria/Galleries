<?php

namespace TypiCMS\Modules\Galleries\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Request;
use TypiCMS;
use TypiCMS\Modules\Core\Shells\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Galleries\Shells\Repositories\GalleryInterface;

class PublicController extends BasePublicController
{
    public function __construct(GalleryInterface $gallery)
    {
        parent::__construct($gallery, 'galleries');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $page = Request::input('page');
        $perPage = config('typicms.galleries.per_page');
        $data = $this->repository->byPage($page, $perPage, []);
        $models = new Paginator($data->items, $data->totalItems, $perPage, null, ['path' => Paginator::resolveCurrentPath()]);

        return view('galleries::public.index')
            ->with(compact('models'));
    }

    /**
     * Show gallery.
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug, ['files']);

        return view('galleries::public.show')
            ->with(compact('model'));
    }
}
