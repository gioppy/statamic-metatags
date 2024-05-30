<?php

namespace Gioppy\StatamicMetatags\Listeners;

use Gioppy\StatamicMetatags\Contracts\MetaTagsRepository;
use Statamic\Events\TermBlueprintFound;

class TermBlueprintFoundListener
{
    public function __construct(private readonly MetaTagsRepository $metaTagsRepository)
    {
    }

    public function handle(TermBlueprintFound $event): void
    {
        $this->metaTagsRepository->term($event->blueprint, $event->term);
    }
}
