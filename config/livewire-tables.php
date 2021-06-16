<?php

use Illuminate\Support\Str;

return [
    /**
     * Options: tailwind | bootstrap-4 | bootstrap-5.
     */
    'theme' => getLiveWireTableTheme(),
];

function getLiveWireTableTheme(): string
{
    if (in_array(request()->path(), ['tailwind', 'bootstrap-4',  'bootstrap-5'])){
        return request()->path();
    } elseif(Str::of(request()->path())->contains('livewire/message/')) {
        return request()->request->get('fingerprint')['path'];
    }

    return 'bootstrap-4';
}
