<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Track;

class CreateTrack
	extends Command
{
	protected $signature   = 'track:create {sound_pack_id}';
	protected $description = 'Create a track with specified sound_pack_id';

	public function handle()
	{
		$soundPackId = $this->argument('sound_pack_id');

		Track::factory()
		     ->forSoundPack($soundPackId)
		     ->create();

		$this->info("Track created with sound_pack_id: $soundPackId");
	}
}