<?php

namespace App\Traits\Models;

use Illuminate\Support\Str;

trait HasUuid
{
	public static function bootHasUuid(): void
	{
		static::creating(
			function ($model) {
				if (empty($model->{$model->getKeyName()})) {
					$model->{$model->getKeyName()} = Str::uuid()->toString();
				}
			}
		);
	}

	public function getIncrementing(): false
	{
		return false;
	}

	public function getKeyType(): string
	{
		return 'string';
	}
}