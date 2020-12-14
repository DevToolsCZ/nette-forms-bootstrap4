<?php

declare(strict_types=1);

namespace App\Forms;

use Nette\Application\UI\Form;
use Nette\Forms\Controls\Checkbox;
use Nette\Forms\IFormRenderer;
use Nette\SmartObject;
use Nette\Utils\Random;

final class FormFactory
{
    use SmartObject;

    public function create(): Form
    {
        $form = new Form;

        $form->onRender[] = [$this, 'boostrapRender'];

        return $form;
    }
    /**
     * @property IFormRenderer $wrappers;
     */
    public function boostrapRender(Form $form)
    {
        $form->setRenderer(new BootstrapRender());
        
        foreach ($form->getControls() as $control) {
            $random = Random::generate(5);
            $type = $control->getOption('type');
            if ($type === 'button') {
                $control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-secondary');
                $usedPrimary = true;
            } elseif (in_array($type, ['text', 'textarea', 'select'], true)) {
                $control->getControlPrototype()->addClass('form-control')->placeholder('fid-' . $random);
            } elseif ($type === 'file') {
                $control->getControlPrototype()->addClass('form-control-file');
            } elseif (in_array($type, ['checkbox', 'radio'], true)) {
                if ($control instanceof Checkbox) {
                    $control->getLabelPrototype()->addClass('form-check-label');
                } else {
                    $control->getItemLabelPrototype()->addClass('form-check-label');
                }
                $control->getControlPrototype()->addClass('form-check-input');
                $control->getSeparatorPrototype()->setName('div')->addClass('form-check');
            }
            
        }
    }
}
