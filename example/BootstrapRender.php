<?php

declare(strict_types=1);

namespace App\Forms;

use Nette\Forms\IControl;
use Nette\Forms\Rendering\DefaultFormRenderer;

class BootstrapRender extends DefaultFormRenderer 
{
    public function renderPair(IControl $control): string
    {
        parent::renderPair($control);

        $pair = $this->getWrapper('pair container');
        $pair->addHtml($this->renderControl($control));
        $pair->addHtml($this->renderLabel($control));
	$pair->class($this->getValue($control->isRequired() ? 'pair .required' : 'pair .optional'), true);
	$pair->class($control->hasErrors() ? $this->getValue('pair .error') : null, true);
	$pair->class($control->getOption('class'), true);
	if (++$this->counter % 2) {
		$pair->class($this->getValue('pair .odd'), true);
	}
	$pair->id = $control->getOption('id');
	return $pair->render(0);
    }
}
