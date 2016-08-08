<?php

namespace TypiCMS\Modules\Galleries\Models;

use TypiCMS\Modules\Core\Shells\Traits\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Shells\Models\Base;
use TypiCMS\Modules\History\Shells\Traits\Historable;

class Gallery extends Base
{
    use Historable;
    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Galleries\Shells\Presenters\ModulePresenter';

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

    protected $appends = ['files_count', 'thumb'];

    /**
     * One gallery has many files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany('TypiCMS\Modules\Files\Shells\Models\File')->order();
    }

    /**
     * One gallery has many news.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function news()
    {
        return $this->morphedByMany('TypiCMS\Modules\News\Shells\Models\News');
    }

    /**
     * One gallery has many pages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function pages()
    {
        return $this->morphedByMany('TypiCMS\Modules\Pages\Shells\Models\Page');
    }

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->thumbSrc(null, 22);
    }

    /**
     * Append files_count attribute.
     *
     * @return string
     */
    public function getFilesCountAttribute()
    {
        return $this->files->count();
    }
}
