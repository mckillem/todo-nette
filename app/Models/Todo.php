<?php

declare(strict_types=1);

namespace App\Models;

use Nette\Database\Explorer;

class Todo
{
	public Explorer $db;

	public function __construct(Explorer $db)
	{
		$this->db = $db;
	}

	public function getAllTodos(): array
	{
		return $this->db->table('todo')->fetchAll();
	}

	public function getTodoById(int $id): string
	{
		$todo = $this->db->table('todo')->get($id);

		return $todo->title;
	}

	public function saveTodo(\stdClass $data): void
	{
		$this->db->table('todo')->insert([
			'title' => $data->title,
		]);
	}

	public function deleteTodo(int $id): void
	{
		$this->db->table('todo')->where('id', $id)->delete();
	}

	public function updateTodo(\stdClass $data): void
	{
		$this->db->table('todo')->where('id', (int)$data->id)->update([
			'title' => $data->title,
		]);
	}
}