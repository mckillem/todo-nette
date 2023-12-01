<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\DI\Attributes\Inject;


final class HomePresenter extends Nette\Application\UI\Presenter
{

	#[Inject]
	public Nette\Database\Explorer $db;

	public function renderDefault(): void
	{
		$this->template->todos = $this->db->table('todo')->fetchAll();
	}

	protected function createComponentTodoForm(): Form
	{
		$form = new Form;

		$form->addText('title', 'Úkol:')
			->setRequired();

		$form->addSubmit('send', 'Přidat');
		$form->onSuccess[] = $this->todoFormSucceeded(...);

		return $form;
	}

	private function todoFormSucceeded(\stdClass $data): void
	{
		$id = $this->getParameter('id');

		$this->db->table('todo')->insert([
			'id' => $id,
			'title' => $data->title,
		]);

		$this->flashMessage('Úkol uložen', 'success');
		$this->redirect('this');
	}

	public function actionDelete(int $id): void
	{
		$this->db->table('todo')->where('id', $id)->delete();

		$this->flashMessage('Úkol byl smazán', 'success');
		$this->redirect('Home:default');
	}
}
