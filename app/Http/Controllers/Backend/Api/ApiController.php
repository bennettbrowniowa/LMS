<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use App\Models\LearningSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function goallist(){
        $goals = Goal::whereNull('parrent_id')->with('subGoals')->orderBy('position')->get();

        return response()->json(['message' => 'Goals fetched successfully', 'goals' => $goals]);
    }

    public function learningsequencelist()
    {
        $learningSequences = LearningSequence::leftJoin('learning_sequence_goals', 'learning_sequences.id', '=', 'learning_sequence_goals.learning_sequence_id')
            ->leftJoin('goals', 'learning_sequence_goals.goal_id', '=', 'goals.id')
            ->leftJoin('learning_sequence_pedagogies', 'learning_sequences.id', '=', 'learning_sequence_pedagogies.learning_sequence_id')
            ->leftJoin('learning_sequence_resources', 'learning_sequences.id', '=', 'learning_sequence_resources.learning_sequence_id')
            ->leftJoin('pedagogy_tags', 'learning_sequence_pedagogies.pedagogy_tag_id', '=', 'pedagogy_tags.id')
            ->leftJoin('resource_types', 'learning_sequence_resources.resource_type_id', '=', 'resource_types.id')
            ->leftJoin('files', 'learning_sequences.id', '=', 'files.learning_sequence_id')
            ->select(
                'learning_sequences.id',
                DB::raw('MAX(learning_sequences.title) as title'),
                DB::raw('MAX(learning_sequences.description) as description'),
                DB::raw('GROUP_CONCAT(goals.id) as parent_goal_ids'),
                DB::raw('GROUP_CONCAT(goals.title) as assigned_goals'),
                DB::raw('GROUP_CONCAT(files.filename) as filenames'),
                DB::raw('GROUP_CONCAT(files.url) as urls'),
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(pedagogy_tags.id, ":", pedagogy_tags.title) SEPARATOR ",") as pedagogy_tags'),
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(resource_types.id, ":", resource_types.title) SEPARATOR ",") as resource_types'),
                DB::raw('MAX(learning_sequences.created_at) as created_at'),
                DB::raw('MAX(learning_sequences.updated_at) as updated_at'),

            )
            ->groupBy('learning_sequences.id')
            ->orderBy('order_column', 'asc')
            ->get();


        $learningSequences->transform(function ($sequence) {
            $filenames = explode(',', $sequence->filenames);
            $sequence->filenames = implode(',', array_map('basename', $filenames));

            return $sequence;
        });

        return response()->json(['message' => 'Learning Sequence fetched successfully', 'data' => $learningSequences]);
    }

}
