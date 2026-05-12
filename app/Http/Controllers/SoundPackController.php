<?php

namespace App\Http\Controllers;

use App\Http\Resources\SoundPackCollection;
use App\Http\Resources\SoundPackResource;
use App\Models\SoundPack;
use Illuminate\Http\Request;

class SoundPackController
{
	public function index(Request $request)
	{
		return SoundPackCollection::make(SoundPack::all());
	}

	public function show(SoundPack $soundPack)
	{
		return SoundPackResource::make($soundPack);
	}

	public function store() { }

	public function delete() { }
}
