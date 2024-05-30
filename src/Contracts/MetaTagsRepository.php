<?php

namespace Gioppy\StatamicMetatags\Contracts;

use Statamic\Entries\Entry;
use Statamic\Fields\Blueprint;
use Statamic\Taxonomies\Term;

interface MetaTagsRepository
{

    public function entry(Blueprint $blueprint, Entry|null $entry): void;

    public function term(Blueprint $blueprint, Term|null $term): void;
}