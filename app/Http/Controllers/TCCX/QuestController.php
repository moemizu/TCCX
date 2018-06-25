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
    private $difficulties;

    public function __construct()
    {
        $this->difficulties = [
            'Easy' => 100,
            'Normal' => 200,
            'Hard' => 300
        ];
    }

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
        return view('tccx.quest.create', $this->questSupportData());
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
        // create quest model
        $this->updateQuestModel(new Quest(), $request);
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
     * Edit quest page
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editQuest(Request $request)
    {
        $quest = Quest::whereId($request->get('id'))->firstOrFail();
        return view('tccx.quest.edit', array_merge($this->questSupportData(), ['quest' => $quest]));
    }

    /**
     * Update details of a quest
     * @param StoreQuest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateQuest(StoreQuest $request)
    {
        $quest = Quest::whereId($request->get('id'))->firstOrFail();
        $this->updateQuestModel($quest, $request);
        return redirect()
            ->route('tccx.quest.quests')
            ->with('status', [
                'type' => 'success',
                'message' => 'Quest updated!'
            ]);
    }

    /**
     * Delete a quest
     * @param Request $request
     */
    public function deleteQuest(Request $request)
    {

    }

    /**
     * Update a quest model
     * @param Quest $quest
     * @param Request $request
     */
    private function updateQuestModel(Quest $quest, Request $request)
    {
        // basic
        $quest->name = $request->get('name');
        $quest->order = $request->get('order');
        // zone
        $questZone = QuestZone::whereId($request->get('zone'))->first();
        $quest->quest_zone()->associate($questZone);
        // type
        $questType = QuestType::whereId($request->get('type'))->first();
        $quest->quest_type()->associate($questType);
        // difficulty, reward
        $quest->difficulty = $request->get('difficulty', 'Normal');
        $quest->reward = $this->difficulties[$quest->difficulty];
        $quest->multiple_team = $questType->name == 'Contest';
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
        // details
        // don't parse markdown
        $quest->story = $request->get('story', '');
        $quest->how_to = $request->get('how-to', '');
        $quest->criteria = $request->get('criteria', '');
        $quest->meta = $request->get('editorial', '');
        // save
        $quest->save();
    }

    /**
     * Return a map containing quest locations, types, zones and difficulties
     * @return array
     */
    private function questSupportData()
    {
        $types = QuestType::all();
        $zones = QuestZone::all();
        $locations = QuestLocation::orderBy('name')->get();
        return [
            'types' => $types, 'zones' => $zones, 'locations' => $locations,
            'difficulties' => $this->difficulties
        ];
    }
}
