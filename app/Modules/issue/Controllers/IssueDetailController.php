<?php namespace App\Modules\Issue\Controllers;

use App\Modules\Abstracts\Controllers\BaseController;
use App\Modules\Issue\Models\Issue;
use App\Modules\Issue\Models\IssueDetail;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use App\Modules\Rental\Models\Rental;
use Illuminate\Support\Facades\Redirect;
use App\Modules\Rental\Models\PropertyDetail;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Modules\Message\Models\Media;

class IssueDetailController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('issue::issue_detail.list', ['data' => IssueDetail::getAll(
            isset($_REQUEST['issue_id']) ? $_REQUEST['rental_id'] : null
        )]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $issue_detail = [
            'id' => $request->all()['issue_detail_id'],
            'issue' => ($issue = Issue::findOrFail($request->all()['issue_id'])),
            'type' => $request->all()['issue_detail_type'],
            'priority' => $request->all()['issue_detail_priority'],
            'content' => $request->all()['issue_detail_content'],
            '3rdParty' => $request->all()['issue_detail_3rdParty'],
            'media' => [],
        ];
        IssueDetail::store($issue_detail['issue'], $issue_detail['content'], $issue_detail['type'], $issue_detail['3rdParty'], $issue_detail['priority'], $issue_detail['media'], $issue_detail['id']);
        return Redirect::route('issue.index');
    }
    public static function issetOrDefault($array, $index, $default = null)
    {
        return isset($array[$index]) ? $array[$index] : $default;
    }
    public static function stripPropertyDetailOptions(Request $request)
    {
        $result = [];
        $regex = ['existing' => '/^issue_detail_/', 'new' => '/^issue_detail_new_/'];
        $request = ($request instanceof Request ? $request->all() : (is_array($request) ? $request : []));
        foreach(array_keys($request) as $key)
        {
            $striped_key = preg_replace($regex['existing'], '', $key);
            preg_match('/\d+/', $striped_key, $detail_id);
            if(sizeof($detail_id) < 1)
                continue;
            $detail_id = (intval($detail_id[0]) === 0 ? 'new' : intval($detail_id[0]));
            if(!isset($result[$detail_id]))
                $result[$detail_id] = ['media' => []];

            $field = preg_replace('/\d_/', '', $striped_key);
            if(preg_match('/^(media_id_|media_new)/', $field) === 1)
            {
                $media = Media::find($media_id = intval(preg_replace('/^media_id_/', '', $field)));
                if(($file = $request[$key]) instanceof UploadedFile && $file->isValid())
                {
                    $fileName = $file->getClientOriginalName();
                    if(pathinfo($fileName, PATHINFO_FILENAME) === '')
                    $fileName = 'file' . $fileName;
                    if(pathinfo($fileName, PATHINFO_EXTENSION) === '')
                    $fileName .= '.' . (trim($file->guessClientExtension()) !== '' ? $file->guessClientExtension() : $file->guessExtension());
                    $media = Media::store(file_get_contents($file->getPathName()), $file->getMimeType(), $fileName);
                }
                if($media instanceof Media && boolval($request[$key]) === true)
                    $result[$detail_id]['media'][$media->id] = $media;
            } else $result[$detail_id][$field] = $request[$key];
        } // endforeach
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {
        if(($issue_detail = IssueDetail::find($id)) instanceof IssueDetail)
            $issue = Issue::findOrFail($issue_detail->issue_id);
        return view('issue::issue_detail.detail', ['issue' => $issue, 'issue_detail' => $issue_detail]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        IssueDetail::destroy($id);
        return Redirect::to('issue');
    }
}
