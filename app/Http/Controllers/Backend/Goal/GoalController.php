<?php

namespace App\Http\Controllers\Backend\Goal;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class GoalController extends Controller
{

    public function index()
    {
        $user_id = Auth::user()->id;


        $parent_goals = Goal::where(['user_id' => $user_id, 'parrent_id' => null])->orderBy('position')->get();


        $goals = Goal::where('user_id', $user_id)->orderBy('position')->get();


        return view('Backend.Goal.All', compact('goals', 'parent_goals'));
    }


    public function add(){

        return view('Backend.Goal.Add');
    }

    public function save(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',

        ]);



        $save = new Goal();
        $save->user_id=Auth::user()['id'];
        $save->title=$request->get('title');
        $save->description=$request->get('description');
        $save->parrent_id = null;
        $save->position = Goal::max('position') + 1;
        $save->save();
        Session::flash('success', "Goal has been created successfully");
        return redirect()->back();
    }

    public function editGoal($id)
    {
        $records = Goal::findOrFail($id);
        return view('Backend.Goal.Edit',['records'=>$records]);

    }

    public function updateGoal(Request $request,$id){

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',

        ]);

        $update=Goal::findOrFail($id);
        $update->title=$request->get('title');
        $update->description=$request->get('description');
        $update->save();
        Session::flash('success', "Goal has been updated");
        return redirect()->back();
    }

    public function deletegoal(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $goal = Goal::findOrFail($id);
            if (!$goal) {
                DB::rollback();
                return response()->json(['error' => 'Goal not found.'], 404);
            }
            if ($goal->parrent_id === null) {

                Goal::where('parrent_id', $goal->id)->delete();
            }
            $goal->delete();

            DB::commit();
            return response()->json(['success' => 'Goal and any subgoals have been deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'An error occurred while deleting the goal.'], 500);
        }
    }




    public function subGoal($id)
    {

        $parentGoal = Goal::findOrFail($id);
        $subGoals = Goal::where(['user_id' => Auth::user()->id, 'parrent_id' => $id])->get();


        return view('Backend.subgoal.All', compact('parentGoal', 'subGoals', 'id'));
    }


    public function addsubGoal($id){
         return view('Backend.subgoal.Add',compact('id'));
    }
    public function savesubgoal(Request $request,$id){

         $this->validate($request, [
            'title' => 'required',
            'description' => 'required',

        ]);
        $save = new Goal();
        $save->user_id=Auth::user()['id'];
        $save->title=$request->get('title');
        $save->description=$request->get('description');
        $save->is_parrent='1';
        $save->parrent_id=$id;
        $save->save();
        Session::flash('success', "Sub Goal has been created successfully");
        return redirect()->back();
    }
    public function editsubgoal($id){
         $records = Goal::findOrFail($id);
        return view('Backend.subgoal.Edit',['records'=>$records]);
    }
    public function updatesubgoal(Request $request,$id){

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',

        ]);

        $update=Goal::findOrFail($id);
        $update->title=$request->get('title');
        $update->description=$request->get('description');
        $update->save();
        Session::flash('success', "Sub Goal has been updated");
        return redirect()->back();
    }


    public function deletesubgoal(Request $request, $id)
    {
        try {
            $goal = Goal::findOrFail($id);

            if ($goal->is_parrent=='1') {
                $this->deleteParentAndChildren($goal);
            } else {
                $goal->delete();
            }

            return response()->json(['success' => 'Goal deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting goal']);
        }
    }

    protected function deleteParentAndChildren($parentGoal)
    {
        $childGoals = Goal::where('parrent_id', $parentGoal->id)->get();
        foreach ($childGoals as $childGoal) {
            $childGoal->delete();
        }
        $parentGoal->delete();
    }




    public function save_sub_Goal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parentId' => 'required|exists:goals,id',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $parentId = $request->input('parentId');


        $parentGoal = Goal::findOrFail($parentId);
        $subgoal = new Goal();
        $subgoal->title = $request->title;
        $subgoal->user_id = Auth::user()['id'];
        $subgoal->description = $request->description;
        $subgoal->parrent_id = $parentId;
        $subgoal->position =$parentGoal->subGoals()->count() + 1;
        $subgoal->save();
        return response()->json(['message' => 'Subgoal created successfully'], 200);
    }








public function movegoal(Request $request)
    {
        $goalId = $request->input('goalId');
        $newPosition = $request->input('newPosition');


        $goal = Goal::where('id',$goalId)->first();
        $assignnewgoal = Goal::where('id',$newPosition)->first();

        DB::table('goals')->where('id',$goalId)->update(['position'=>$assignnewgoal->position]);
        DB::table('goals')->where('id',$newPosition)->update(['position'=>$goal->position]);

        return response()->json(['message' => 'Goal moved successfully'], 200);
    }

    public function moveSubgoal(Request $request)
    {
        $goalId = $request->input('goalId');
        $newPosition = $request->input('newPosition');


        $subgoal = Goal::findOrFail($goalId);
        $goalAtNewPosition = Goal::findOrFail($newPosition);

        DB::table('goals')
            ->where('id', $subgoal->id)
            ->update([
                'parrent_id' => $goalAtNewPosition->parrent_id,
                'position' => $goalAtNewPosition->position
            ]);

        return response()->json(['message' => 'Subgoal moved successfully'], 200);
    }







    public function getAvailablePositions(Request $request)
    {
        try {
            $goalId = $request->input('goalid');


            $goal = Goal::findOrFail($goalId);

            $potentialParentGoals = Goal::where( 'parrent_id', '=', null)->where('id','!=',$goal->id)->get();


            $highestPositionRow = Goal::where('position', function ($query) {
                $query->selectRaw('MAX(position)')
                    ->from('goals');
            })
                ->where( 'parrent_id', '=', null)
                ->first();



            $positionText = 'As After';
            if ($highestPositionRow && $highestPositionRow->position > $goal->position) {
                $positionText = 'As After';
            }


            return response()->json([
                'goal'=> $goal,
                'potentialParentGoals' => $potentialParentGoals,
                'positionText' => $positionText

            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getsubgoalAvailablePositions(Request $request)
    {
        try {
            $subgoalId = $request->input('subgoalid');


            $subgoal = Goal::findOrFail($subgoalId);


            $potentialParentGoals = Goal::where( 'parrent_id', '!=', null)->where('id','!=',$subgoal->id)->get();

            $positionText = 'Under';

            return response()->json([
                'goal'=> $subgoal,
                'potentialParentGoals' => $potentialParentGoals,
                'positionText' => $positionText


            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function moveSubgoaldown(Request $request) {
        $currentId = $request->input('currentId');
        $nextId = $request->input('nextId');


        DB::beginTransaction();

        try {
            $currentGoal = Goal::findOrFail($currentId);
            $nextGoal = Goal::findOrFail($nextId);



            $currentPosition = $currentGoal->position;
            $nextPosition = $currentPosition + 1;


            $currentGoal->update(['position' => $nextPosition]);
            $nextGoal->update(['position' => $currentPosition]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Subgoals moved successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to move subgoals. Error: ' . $e->getMessage()], 500);
        }
    }



}
