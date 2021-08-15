<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class FileHelper extends Model
{
	public static function uploadFile($file, $ext = null, $name = null, $folder = 'files')
	{
		if ($file === null) {
			return null;
		}
		if ($name) {
			$old = public_path('/' . $folder . '/' . $name);

			if (!is_dir($old) && file_exists($old)) {
				unlink($old);
			}
		}
		$time = microtime('.') * 10000;
		$ext = $ext ? $ext : $file->getClientOriginalExtension();
		$name = strtolower($time . '.' . $ext);
		$file->storeAs($folder, $name, 'public');
		return $name;
	}

	public static function getFile () {
		//
	}
}
