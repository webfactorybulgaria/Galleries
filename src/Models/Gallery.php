<?php

namespace TypiCMS\Modules\Galleries\Models;

use Dimsav\Translatable\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class Gallery extends Base
{
    use Historable;
    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Galleries\Presenters\ModulePresenter';

    protected $fillable = [
        'name',
        'image',
        // Translatable columns
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    /**
     * Columns that are file.
     *
     * @var array
     */
    public $attachments = [
        'image',
    ];

    protected $appends = ['status', 'title', 'files_count', 'thumb'];

    /**
     * One gallery has many files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany('TypiCMS\Modules\Files\Models\File')->order();
    }

    /**
     * One gallery has many news.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function news()
    {
        return $this->morphedByMany('TypiCMS\Modules\News\Models\News');
    }

    /**
     * One gallery has many pages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function pages()
    {
        return $this->morphedByMany('TypiCMS\Modules\Pages\Models\Page');
    }

    /**
     * Get files count.
     *
     * @return string title
     */
    public function getFilesCountAttribute()
    {
        return $this->files->count();
    }
}
