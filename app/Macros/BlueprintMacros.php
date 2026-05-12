<?php

namespace App\Macros;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

class BlueprintMacros
{
	public function foreignIdForConstrained(): callable
	{
		return function (
			string  $model,
			?string $column = null,
			string  $comment = '',
			bool    $isNullable = true,
			string  $after = null
		) {
			/** @var Blueprint $this */
			return $this->foreignIdFor($model, $column)
			            ->nullable($isNullable)
			            ->comment($comment)
			            ->when(
				            !empty($after),
				            fn (ColumnDefinition $definition) => $definition->after($after)
			            )
			            ->constrained();
		};
	}

	public function uuidId(): callable
	{
		return function (
			string $column = 'id',
			string $comment = 'ID',
			bool   $isPrimary = true,
			bool   $isUnique = false,
		) {
			/** @var Blueprint $this */
			return $this->uuid($column)
			            ->comment($comment)
			            ->when(
				            $isUnique,
				            fn (ColumnDefinition $definition) => $definition->unique()
			            )
			            ->when(
				            $isPrimary,
				            fn (ColumnDefinition $definition) => $definition->primary()
			            );
		};
	}

	public function userId(): callable
	{
		return function (?string $column = null, string $comment = 'ID пользователя', bool $isNullable = true) {
			/** @var Blueprint $this */
			return $this->foreignIdForConstrained(User::class, $column, $comment, $isNullable);
		};
	}

	public function title(): callable
	{
		return function (
			string $column = 'title',
			string $comment = 'Название',
			int    $length = 200,
			bool   $isUnique = false,
			bool   $isNullable = false
		) {
			/** @var Blueprint $this */
			return $this->string($column, $length)
			            ->comment($comment)
			            ->when(
				            $isUnique,
				            fn (ColumnDefinition $definition) => $definition->unique()
			            )
			            ->when(
				            $isNullable,
				            fn (ColumnDefinition $definition) => $definition->nullable()
			            );
		};
	}

	public function description(): callable
	{
		return function (string $column = 'description', string $comment = 'Описание', bool $isNullable = true) {
			/** @var Blueprint $this */
			return $this->text($column)
			            ->comment($comment)
			            ->when(
				            $isNullable,
				            fn (ColumnDefinition $definition) => $definition->nullable()
			            );
		};
	}

	public function is(): callable
	{
		return function (string $column, string $comment, bool $default = false) {
			/** @var Blueprint $this */
			return $this->boolean('is_' . $column)
			            ->default($default)
			            ->comment($comment);
		};
	}

	public function isActive(): callable
	{
		return function (string $column = 'active', string $comment = 'Активность', bool $default = false) {
			/** @var Blueprint $this */
			return $this->is($column, $comment, $default);
		};
	}
}