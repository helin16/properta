<?php 
namespace App\Modules\Abstracts\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Message\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BaseController extends Controller
{
	public static function stripMedia($request)
	{
		$result = [];
		$regex = '/^media_id_/';
		$request = ($request instanceof Request ? $request->all() : (is_array($request) ? $request : []));
		foreach(array_keys($request) as $key)
		{
			switch($key)
			{
				case (preg_match($regex, $key) === 1):
				{
					$media_id = preg_replace($regex, '', $key);
					if(intval($request[$key]) !== 1)
						Media::destroy($media_id);
					elseif(($media = Media::find($media_id)) instanceof Media)
						$result[] = $media;
					break;
				}
				case ($key === 'media_new' && ($file = $request[$key]) instanceof UploadedFile && $file->isValid()):
				{
					$fileName = $file->getClientOriginalName();
					if(pathinfo($fileName, PATHINFO_FILENAME) === '')
						$fileName = 'file' . $fileName;
					if(pathinfo($fileName, PATHINFO_EXTENSION) === '')
						$fileName .= '.' . (trim($file->guessClientExtension()) !== '' ? $file->guessClientExtension() : $file->guessExtension());
					$result[] = Media::store(file_get_contents($file->getPathName()), $file->getMimeType(), $fileName);
				}
			}
		}
		return $result;
	}
}