<?php

namespace App\Http\Controllers\TCCX;

use App\Http\Requests\TCCX\StoreQuestLocation;
use App\TCCX\Quest\QuestLocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class QuestLocationController extends Controller
{
    public function index()
    {
        $ql = QuestLocation::orderByDesc('updated_at')->paginate(10);
        return view('tccx.quest.location.view', [
            'questLocations' => $ql
        ]);
    }

    /**
     * view create/edit page, Use for both create/edit
     */
    public function edit()
    {

    }

    /**
     * Use for both create/edit, create/edit post endpoint
     * @param StoreQuestLocation $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function editPost(StoreQuestLocation $request)
    {
        $creation = !QuestLocation::whereId($request->get('id'))->exists();
        QuestLocation::updateOrCreate([
            'id' => $request->get('id')
        ], [
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'lat' => $request->get('lat'),
            'lng' => $request->get('lng')
        ]);
        $status = [
            'success' => true,
            'message' => $creation ? 'Location has been created!' : 'Location has been updated!'
        ];
        return $request->ajax() ?
            response()->json($status) : redirect()->route('tccx.quest.locations')->with('status', $status);
    }

    public function delete(Request $request)
    {
        // validate
        try {
            $this->validate($request, [
                'id' => 'required|exists:quest_locations,id'
            ]);
        } catch (ValidationException $e) {
            // TODO: display error
            return back();
        }
        // find model
        $ql = QuestLocation::whereId($request->get('id'))->firstOrFail();
        // and delete it
        $ql->delete();
        $status = [
            'success' => true,
            'message' => 'Location has been deleted!'
        ];
        return $request->ajax() ?
            response()->json($status) :
            redirect()->route('tccx.quest.locations')->with('status', $status);
    }
}
