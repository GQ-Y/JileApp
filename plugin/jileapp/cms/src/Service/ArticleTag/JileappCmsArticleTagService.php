<?php

namespace Plugin\Cms\Service\ArticleTag;

use Mine\Abstracts\AbstractService;

class JileappCmsArticleTagService extends AbstractService
{
    public function __construct(protected readonly JileappCmsArticleTag $model)
    {
        parent::__construct($model);
    }
}
