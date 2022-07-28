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

$asset->css('vendor/lyrasoft/attachment/dist/attachment.min.css');
$asset->js('vendor/lyrasoft/attachment/dist/attachment.min.js');

$attributes = $attributes->class('c-attachment-field')
    ->exceptProps(
        [
            'items',
            'insertBtn',
            'accept',
            'name',
            'id',
        ]
    );

$insertBtn = $insertBtn ?? false;

$options = [
    'accept' => $accept ?? false,
];

$name ??= 'attachments';
$id ??= null;
?>

<div {!! $attributes !!}>
    <x-attachment-list
        :items="$items"
        :insertBtn="$insertBtn"
        >
        @if ($buttons ?? null)
        <x-slot name="buttons">
            @scope($item, $i)
            {!! $buttons(item: $item, i: $i) !!}
        </x-slot>
        @endif
    ></x-attachment-list>

    <x-attachment-uploader
        :id="$id"
        :name="$name"
        :options="$options"></x-attachment-uploader>
</div>
