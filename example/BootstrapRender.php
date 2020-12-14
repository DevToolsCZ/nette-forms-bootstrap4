<?php

declare(strict_types=1);

namespace App\Forms;

use Nette\Forms\IControl;
use Nette\Forms\Rendering\DefaultFormRenderer;

class BootstrapRender extends DefaultFormRenderer 
{
     public function __construct() 
     {
        $this->wrappers['controls']['container'] = null;
        $this->wrappers['pair']['container'] = 'div class="form-floating has-validation mb-3"';
        $this->wrappers['pair']['.error'] = 'has-danger';
        $this->wrappers['control']['description'] = 'span class=form-text';
        $this->wrappers['control']['errorcontainer'] = 'span class=invalid-feedback';
        $this->wrappers['control']['.error'] = 'invalid-feedback';
    }

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
