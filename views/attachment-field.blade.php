<?php

declare(strict_types=1);

namespace App\View;

use Windwalker\Core\Asset\AssetService;
use Windwalker\Core\DateTime\ChronosService;
use Windwalker\Core\Language\LangService;
use Windwalker\Core\Pagination\Pagination;
use Windwalker\Core\Router\Navigator;
use Windwalker\Core\Application\AppContext;
use Windwalker\Core\Attributes\ViewModel;
use Windwalker\Core\Router\SystemUri;

use function Windwalker\uid;

/**
 * Global variables
 * --------------------------------------------------------------
 * @var $app       AppContext      Global Application
 * @var $view      ViewModel       Some information of this view.
 * @var $uri       SystemUri       Uri information, example: $uri->path
 * @var $chronos   ChronosService  PHP DateTime object of current time.
 * @var $nav       Navigator       Router object.
 * @var $asset     AssetService    The Asset service.
 * @var $lang      LangService     The lang service.
 */

/**
 * @var \Windwalker\Edge\Component\ComponentAttributes $attributes
 * @var \Windwalker\Edge\Wrapper\SlotWrapper           $slot
 */

$attributes = $attributes->class('c-attachment-field')
    ->exceptProps(
        [
            'items',
            'insertBtn',
            'accept',
            'name',
            'id',
            'sortable',
        ]
    );

$insertBtn = $insertBtn ?? false;

$options = [
    'accept' => $accept ?? false,
    'mutiple' => $mutiple ?? false,
];

$name ??= 'attachments';
$id ??= null;
$sortable ??= false;

?>

<div {!! $attributes !!}>
    <x-attachment-list
        :id="$id ? $id . '-list' : null"
        :items="$items"
        :name="$name"
        :insertBtn="$insertBtn"
        :sortable="$sortable"
        >
        @if ($buttons ?? null)
        <x-slot name="buttons">
            @scope($item, $i)
            {!! $buttons(item: $item, i: $i) !!}
        </x-slot>
        @endif

        @if ($input ?? null)
        <x-slot name="buttons">
            @scope($item, $i)
            {!! $input(item: $item, i: $i) !!}
        </x-slot>
        @endif
    ></x-attachment-list>

    <x-attachment-uploader
        :input-id="$id ? 'input-' . $id : null"
        :name="$name"
        :options="$options"></x-attachment-uploader>
</div>
