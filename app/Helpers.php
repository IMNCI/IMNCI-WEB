<?php

use Illuminate\Support\Facades\Storage;

function getCountiesSQL(){
	if (!Storage::disk('local')->exists('counties.sql')) {
		throw new Exception('Counties SQL statement not found');
	}

	$contents = Storage::disk('local')->get('counties.sql');

	return $contents;
}