<?php

namespace App\Http\Controllers\TCCX;

use App\Http\Requests\TCCX\StoreQuest;
use App\TCCX\Quest\Quest;
use App\TCCX\Quest\QuestLocation;
use App\TCCX\Quest\QuestType;
use App\TCCX\Quest\QuestZone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use function Psy\debug;

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
     * Return create a new quest page
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createQuest(Request $request)
    {
        // load type and zone
        $types = QuestType::all();
        $zones = QuestZone::all();
        $locations = QuestLocation::orderBy('name')->get();
        // return quest creation page
        return view('tccx.quest.create', ['types' => $types, 'zones' => $zones, 'locations' => $locations]);
    }

    /**
     * Create a new quest
     * @param StoreQuest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createQuestPost(StoreQuest $request)
    {
        // Log
        Log::info('New quest created! ' . print_r($request->toArray(), true));
        // Markdown parser
        $parser = new \Parsedown();
        // create quest model
        $quest = new Quest();
        // basic
        $quest->name = $request->get('name');
        $quest->order = $request->get('order');
        $questZone = QuestZone::whereId($request->get('zone'))->first();
        $quest->quest_zone()->associate($questZone);
        $questType = QuestType::whereId($request->get('type'))->first();
        $quest->quest_type()->associate($questType);
        $quest->difficulty = $request->get('difficulty', 'Normal');
        $quest->reward = [
            'Easy' => 100,
            'Normal' => 200,
            'Hard' => 300
        ][$quest->difficulty];
        $quest->multiple_team = (bool)strcasecmp($questType->name, 'Contest');
        // location
        $LocationId = $request->get('location-id');
        if (!empty($LocationId)) {
            // use location id
            $quest->quest_location()->associate(QuestLocation::whereId($LocationId)->first());
        } else {
            // create new location
            $location = new QuestLocation();
            $location->name = $request->get('location-name');
            $location->type = $request->get('location-type');
            $location->lat = $request->get('location-lat');
            $location->lng = $request->get('location-lng');
            // save
            $location->save();
            // associate with the quest
            $quest->quest_location()->associate($location);
        }
        // details, with markdown parser
        $quest->story = $parser->text($request->get('story'));
        $quest->how_to = $parser->text($request->get('how-to'));
        $quest->criteria = $parser->text($request->get('criteria'));
        $quest->meta = $parser->text($request->get('editorial'));
        // save
        $quest->save();
        // return success response
        return redirect()
            ->route('tccx.quest.quests')
            ->with('status', [
                'type' => 'success',
                'message' => 'Quest created!'
            ]);
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
