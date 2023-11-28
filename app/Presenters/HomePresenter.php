<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\DI\Attributes\Inject;


final class HomePresenter extends Nette\Application\UI\Presenter
{

	#[Inject]
	public Nette\Database\Explorer $db;

	public function renderDefault(): void
	{
		$this->template->todos = $this->db->table('todo')->fetchAll();
	}
}
