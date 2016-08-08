<?php

namespace TypiCMS\Modules\Galleries\Presenters;

use TypiCMS\Modules\Core\Shells\Presenters\Presenter;

class ModulePresenter extends Presenter
{
    /**
     * Files in list.
     *
     * @return string
     */
    public function countFiles()
    {
        $nbFiles = $this->entity->files->count();
        $label = $nbFiles ? 'label-success' : 'label-default';
        $html = [];
        $html[] = '<span class="label '.$label.'">';
        $html[] = $nbFiles;
        $html[] = '</span>';

        return implode("\r\n", $html);
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function title()
    {
        return $this->entity->name;
    }
}
