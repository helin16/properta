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
use Illuminate\Support\Facades\Session;
use App\Modules\Rental\Models\RentalUser;


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
        $errors = [];
        $issue_detail = [
            'id' => $request->all()['issue_detail_id'],
            'issue' => ($issue = Issue::find($request->all()['issue_id'])),
            'type' => trim($request->all()['issue_detail_type']),
            'priority' => $request->all()['issue_detail_priority'],
            'content' => $request->all()['issue_detail_content'],
            '3rdParty' => $request->all()['issue_detail_3rdParty'],
            'media' => [],
        ];
        if(intval($issue_detail['id']) >0 && !IssueDetail::find($issue_detail['id']) instanceof IssueDetail)
            return Redirect::route('issue_detail.show')->withErrors(['issue_detail_id' => '[system error]invalid issue detail passed in'])->withInput($request->all());
        if(!$issue_detail['issue'] instanceof Issue)
            return Redirect::route('issue_detail.show')->withErrors(['issue_id' => '[system error]invalid issue passed in'])->withInput($request->all());
        if(strlen($issue_detail['type']) === 0)
            $errors['issue_detail_type'] = 'type is required';
        if(strlen(trim($issue_detail['content'])) === 0)
            $errors['issue_detail_content'] = 'content is required';
        if(count($errors) > 0)
            return Redirect::route('issue_detail.show', ['id' => $issue_detail['id']])->withErrors($errors)->withInput($request->all());

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
        self::checkPermission($id);
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
        self::checkPermission($id);
        IssueDetail::destroy($id);
        return Redirect::to('issue');
    }
    private function checkPermission($id)
    {
        if(!($user = User::find(Session::get('currentUserId'))) instanceof User)
            return Redirect::to('user')->send();

        $rental_ids = [];
        foreach(RentalUser::where('user_id', 1)->get() as $rental_user)
            if(($rental = Rental::find($rental_user->rental_id)) instanceof Rental)
                $rental_ids[] = $rental->id;
        $rental_ids = array_unique($rental_ids);

        if(($issue_detail = IssueDetail::find($id)) instanceof IssueDetail && !in_array($issue_detail->issue_id, $rental_ids))
            abort(403);
    }
}
