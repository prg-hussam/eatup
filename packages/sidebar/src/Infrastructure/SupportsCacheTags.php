<?php

namespace Prgayman\Sidebar\Infrastructure;

use Illuminate\Contracts\Cache\Repository;
use Prgayman\Sidebar\Exceptions\CacheTagsNotSupported;

class SupportsCacheTags
{
    /**
     * @param  Repository  $repository
     * @return bool
     *
     * @throws CacheTagsNotSupported
     */
    public function isSatisfiedBy(Repository $repository)
    {
        if (! method_exists($repository->getStore(), 'tags')) {
            throw new CacheTagsNotSupported('Cache tags are necessary to use this kind of caching. Consider using a different caching method');
        }

        return true;
    }
}
