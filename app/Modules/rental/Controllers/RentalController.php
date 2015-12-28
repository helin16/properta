<?php namespace App\Modules\Rental\Controllers;

use App\Modules\Abstracts\Controllers\BaseController;
use App\Modules\Rental\Models\Property;
use App\Modules\Rental\Models\Rental;
use App\Modules\Rental\Models\Address;
use App\Modules\Message\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RentalController extends BaseController 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rental::rental.list', ['data' => Rental::getAll()]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rental = [
            'id' => $request->all()['rental_id'],
            'dailyAmount' => $request->all()['rental_dailyAmount'],
            'from' => $request->all()['rental_from'],
            'to' => $request->all()['rental_to'],
            'dailyAmount' => $request->all()['rental_dailyAmount'],
            'media' => self::stripMedia($request),
        ];
        $property = Property::findOrFail($request->all()['property_id']);

        Rental::store($rental['dailyAmount'], $rental['from'], $rental['to'], $property, $rental['media'], $rental['id']);
        return Redirect::to('rental');
    }
    public static function stripMedia(Request $request)
    {
        $result = [];
        $regex = '/^media_id_/';
        $options = array_intersect_key($request->all(), array_flip(preg_grep($regex, array_keys($request->all()))));
        foreach($options as $key => $value)
            if(preg_match($regex, $key) && boolval($value) === true && ($media = Media::getById(preg_replace($regex, '', $key))) instanceof Media)
                $result[] = $media;
        // new file
        if(isset($request->all()['media_new']) && ($file = $request->all()['media_new']) instanceof UploadedFile && $file->isValid())
        {
            $fileName = $file->getClientOriginalName();
            if(pathinfo($fileName, PATHINFO_FILENAME) === '')
                $fileName = 'file' . $fileName;
            if(pathinfo($fileName, PATHINFO_EXTENSION) === '')
                $fileName .= '.' . (trim($file->guessClientExtension()) !== '' ? $file->guessClientExtension() : $file->guessExtension());
            $result[] = Media::store(file_get_contents($file->getPathName()), $file->getMimeType(), $fileName);
        }
        return $result;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {
        return view('rental::rental.detail', ['rental' => Rental::getById($id), 'properties' => Property::getAll(false)]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Rental::destroy($id);
        return $this->index();
    }
}
