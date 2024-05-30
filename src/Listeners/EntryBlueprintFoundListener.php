<?php

namespace Gioppy\StatamicMetatags\Listeners;

use Gioppy\StatamicMetatags\Contracts\MetaTagsRepository;
use Statamic\Events\EntryBlueprintFound;

class EntryBlueprintFoundListener
{
    public function __construct(private readonly MetaTagsRepository $metaTagsRepository)
    {
    }

    public function handle(EntryBlueprintFound $event): void
    {
        $this->metaTagsRepository->entry($event->blueprint, $event->entry);
    }
}
