<?php

namespace App\Http\Controllers\TCCX;

use App\TCCX\Quest\Quest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Controller for quest management
 * @package App\Http\Controllers\TCCX
 */
class QuestController extends Controller
{
    /**
     * Index page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $quests = Quest::with('quest_type', 'quest_zone', 'quest_location')->paginate(10);
        return view('tccx.quest.quests', ['quests' => $quests]);
    }

    /**
     * Create a new quest
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createQuest(Request $request)
    {
        // get
        if ($request->isMethod(Request::METHOD_GET)) {
            // return quest creation page
            return view('tccx.quest.create');
        } // post
        else if ($request->isMethod(Request::METHOD_POST)) {
            // validate input
            // create quest model
            // return success response
            return redirect()
                ->route('tccx.quest.quests')
                ->with('status', [
                    'type' => 'success',
                    'message' => 'Quest created!'
                ]);
        } else {
            // unauthorized method
            return abort(401);
        }
    }

    /**
     * Get details of a quest
     * @param Request $request
     */
    public function getQuest(Request $request)
    {

    }

    /**
     * Update details of a quest
     * @param Request $request
     */
    public function updateQuest(Request $request)
    {

    }

    /**
     * Delete a quest
     * @param Request $request
     */
    public function deleteQuest(Request $request)
    {

    }
}
