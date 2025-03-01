<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Models\Todo;

final class HomePresenter extends Nette\Application\UI\Presenter
{
	private Todo $todo;
	private int $id = 0;

	public function __construct(Todo $todo)
	{
		$this->todo = $todo;
	}

	public function renderDefault(): void
	{
		$this->template->todos = $this->todo->getAllTodos();
	}

	public function renderEdit($id): void
	{
		$this->id = (int) $id;
		$this->template->id = $id;
	}

	protected function createComponentTodoForm(): Form
	{
		$form = new Form;

		$form->addText('id')
			->setDefaultValue($this->id)
			->setRequired();

		if ($this->id) {
			$form->addText('title')
				->setDefaultValue($this->todo->getTodoById($this->id))
				->setRequired();
		} else {
			$form->addText('title', 'Úkol:')
				->setRequired();
		}

		$form->addSubmit('send', 'Přidat');
		$form->onSuccess[] = $this->todoFormSucceeded(...);

		return $form;
	}

	private function todoFormSucceeded(\stdClass $data): void
	{
		if ($data->id) {
			$this->todo->updateTodo($data);
		} else {
			$this->todo->saveTodo($data);
		}

		$this->flashMessage('Úkol byl uložen', 'success');
		$this->redirect('Home:default');
	}

	public function actionDelete(int $id): void
	{
		$this->todo->deleteTodo($id);

		$this->flashMessage('Úkol byl smazán', 'success');
		$this->redirect('Home:default');
	}

//	public function actionUpdate(\stdClass $data, int $id): void
//	{
//		$this->todo->updateTodo($data, $id);
//
//		$this->flashMessage('Úkol byl upraven', 'success');
//		$this->redirect('this');
//	}
}
