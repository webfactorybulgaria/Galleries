<?php

namespace TypiCMS\Modules\Galleries\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use TypiCMS\Modules\Core\Shells\Repositories\RepositoriesAbstract;
use TypiCMS\Modules\Files\Shells\Models\File;

class EloquentGallery extends RepositoriesAbstract implements GalleryInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all galleries with files_count for back end.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allRaw()
    {
        $query = $this->make()
            ->select(
                'galleries.id',
                'name',
                'image',
                'status',
                DB::raw('COUNT('.DB::getTablePrefix().'files.id) as files_count')
            )
            ->leftJoin('files', function($join)
            {
                $join->on('gallery_id', '=', 'galleries.id');
            })
            ->groupBy('galleries.id')
            ->order();

        // Get
        return $query->get();
    }

    /**
     * Delete model and attached files.
     *
     * @return bool
     */
    public function delete($model)
    {
        if ($model->files) {
            $model->files->each(function (File $file) {
                $file->delete();
            });
        }
        if ($model->delete()) {
            return true;
        }

        return false;
    }
}
