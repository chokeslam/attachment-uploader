<?php

declare(strict_types=1);

namespace App\View;

use Unicorn\Script\FormScript;
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

$app->service(FormScript::class)->fileDrag();

$attributes = $attributes->class('c-attachment-uploader d-flex flex-column position-relative')
    ->exceptProps(
        [
            'options',
            'name'
        ]
    );

$name ??= 'attachments';
$inputId ??= 'input-attachment-' . uid();

$accept = $options['accept'] ?? null;
$mutiple = $options['mutiple'] ?? false;
?>

<uni-file-drag {!! $attributes !!}  data-options="{{ json_encode($options) }}">
    <input id="{{ $inputId }}" name="{{ $name }}[]"
        {{ $mutiple ? 'multiple' : '' }}
        type="file" class="form-control"
        accept="{{ $accept }}"
    >
    <label class="px-3 c-file-drag-input__label"
        data-overlay-label
        for="{{ $inputId }}">
        <span class="label-text" >
            <span class="fa fa-upload"></span>
        </span>
    </label>
</uni-file-drag>
