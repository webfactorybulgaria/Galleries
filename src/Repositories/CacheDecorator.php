<?php

namespace TypiCMS\Modules\Galleries\Repositories;

use TypiCMS\Modules\Core\Shells\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Shells\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements GalleryInterface
{
    public function __construct(GalleryInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Delete model and attached files.
     *
     * @return bool
     */
    public function delete($model)
    {
        $this->cache->flush();
        $this->cache->flush('dashboard');

        return $this->repo->delete($model);
    }
}
