<?php

namespace App\Http\Controllers\TCCX;

use App\BooleanChain;
use App\Http\Requests\TCCX\AssignQuest;
use App\Http\Requests\TCCX\FinishQuest;
use App\Http\Requests\TCCX\StoreQuest;
use App\TCCX\Quest\Quest;
use App\TCCX\Quest\QuestLocation;
use App\TCCX\Quest\QuestType;
use App\TCCX\Quest\QuestZone;
use App\TCCX\Team;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

/**
 * Controller for quest management
 * @package App\Http\Controllers\TCCX
 */
class QuestController extends Controller
{
    private $difficulties;
    private $times;
    /**
     * @var \Illuminate\Contracts\Foundation\Application $app ;
     */
    private $app;

    /**
     * QuestController constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->difficulties = [
            '0' => 0,
            '1' => 100,
            '2' => 200,
            '3' => 300,
            '4' => 400
        ];
        $this->times = [
            'N/A' => 0,
            'Morning' => 1,
            'Afternoon' => 2,
        ];
        $this->app = $app;
    }

    /**
     * Index page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $quests = Quest::with('quest_type', 'quest_zone', 'quest_location')->paginate(10);
        $teams = Team::all();
        return view('tccx.quest.quests', ['quests' => $quests, 'teams' => $teams]);
    }

    /**
     * Return create a new quest page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createQuest()
    {
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
            ->route('tccx.quest.quests', ['page' => $request->get('last-page')])
            ->with('status', [
                'type' => 'success',
                'message' => 'Quest created!'
            ]);
    }

    /**
     * Get details of a quest
     * intended for printing
     * @param string $code quest code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getQuest($code)
    {
        $qc = $this->app->make('App\TCCX\Quest\QuestCode');
        $parsedQuestCode = $qc->parse($code);
        $quest = Quest::where('order', $parsedQuestCode['order'])
            ->where('quest_type_id', $parsedQuestCode['type'])
            ->where('quest_zone_id', $parsedQuestCode['zone'])
            ->where('time', $parsedQuestCode['time'])
            ->where('group', $parsedQuestCode['group'])
            ->where('difficulty', $parsedQuestCode['difficulty'])
            ->firstOrFail();
        return view('tccx.quest.view', ['quest' => $quest]);
    }

    /**
     * Get details of a quest by quest id
     * intended for printing
     * @param int $id a quest id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getQuestById($id)
    {
        $quest = Quest::whereId($id)->firstOrFail();
        return view('tccx.quest.view', ['quest' => $quest]);
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
            ->route('tccx.quest.quests', ['page' => $request->get('last-page')])
            ->with('status', [
                'type' => 'success',
                'message' => 'Quest updated!'
            ]);
    }

    /**
     * Delete a quest
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteQuest(Request $request)
    {
        $quest = Quest::whereId($request->get('quest-id'))->firstOrFail();
        $quest->delete();
        return redirect()
            ->back()
            ->with('status', [
                'type' => 'success',
                'message' => 'Quest deleted!'
            ]);
    }

    /**
     * Assign a quest to specified team
     * @param AssignQuest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignQuest(AssignQuest $request)
    {
        $teamId = $request->get('selected-team');
        $questId = $request->get('quest-id');
        // Query related model (team and quest)
        $quest = Quest::whereId($questId)->firstOrFail();
        $team = Team::whereId($teamId)->firstOrFail();
        // If quest has been assigned
        if (!$quest->canBeAssigned()) {
            return back()->with('status', ['type' => 'danger', 'message' => 'Quest has already been assigned!']);
        }
        // attach a team to a quest
        $quest->teams()->attach($team->id, ['assigned_at' => Carbon::now()]);
        return back()->with('status', ['type' => 'success', 'message' => 'Quest has been assigned!']);
    }

    /**
     * Mark a quest for completion
     * @param FinishQuest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finishQuest(FinishQuest $request)
    {
        $questId = $request->get('quest-id');
        $note = $request->get('note', '');
        $quest = Quest::whereId($questId)->first();
        // if quest hasn't been assigned to someone
        if ($quest->assignedTo() == null)
            return back()->with('status', [
                'type' => 'danger',
                'message' => 'This quest can\'t be mark for completion!, please assign it to someone!']);
        $team = $quest->teams()->first();
        // mark for completion
        $quest->teams()->updateExistingPivot($team, ['note' => $note, 'completed_at' => Carbon::now()]);
        $qc = $this->app->make('App\TCCX\Quest\QuestCode');
        // reward team
        $team->score = $team->score + $quest->reward;
        $team->save();
        return back()->with('status', [
            'type' => 'success',
            'message' => sprintf('Quest %s is marked for completion and team %s has been rewarded for %s points!',
                $qc->generate($quest), $team->name, $quest->reward)
        ]);
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
        // group and time
        $quest->time = $request->get('time');
        $quest->group = $request->get('group');
        // zone
        $questZone = QuestZone::whereId($request->get('zone'))->first();
        if (isset($questZone))
            $quest->quest_zone()->associate($questZone);
        // type
        $questType = QuestType::whereId($request->get('type'))->first();
        $quest->quest_type()->associate($questType);
        // difficulty, reward
        $quest->difficulty = $request->get('difficulty', 'Normal');
        $quest->reward = $request->get('reward', $this->difficulties[$quest->difficulty]);
        $quest->multiple_team = $questType->name == 'Contest';
        // location
        $locationId = $request->get('location-id');
        if (!empty($locationId)) {
            // use location id
            $quest->quest_location()->associate(QuestLocation::whereId($locationId)->first());
        } else {
            $test = new BooleanChain(function (Request $request, $key) {
                return empty($request->get($key));
            }, $request);
            // if everything is not empty
            if (!$test->evaluate(['location-name', 'location-type', 'location-lat', 'location-lng'])) {
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
        }
        // details
        // don't parse markdown
        $quest->story = $request->get('story', '');
        $quest->how_to = $request->get('how-to', '');
        $quest->criteria = $request->get('criteria', '');
        // Somehow, default value is not working (use ?? instead)
        $quest->meta = $request->get('editorial', '') ?? "";
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
            'difficulties' => $this->difficulties, 'times' => $this->times
        ];
    }

    /**
     * Can you assign the quest to specified team?
     * @param Quest $quest
     * @return bool
     */
    public function canBeAssigned(Quest $quest)
    {
        // if quest can be assigned to multiple team
        if ($quest->multiple_team) {
            return true;
        } else {
            return !$quest->teams()->exists();
        }
    }
}
