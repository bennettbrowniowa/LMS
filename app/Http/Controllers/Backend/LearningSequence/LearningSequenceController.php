<?php

namespace App\Http\Controllers\Backend\LearningSequence;

use App\Http\Controllers\Controller;

use App\Models\Course;
use App\Models\CourseLearningActivity;
use App\Models\CourseLearningSequence;
use App\Models\CourseStudent;
use App\Models\File;
use App\Models\Foilfeedback;
use App\Models\Goal;
use App\Models\LearningSequence;
use App\Models\LearningSequenceGoal;
use App\Models\LearningSequencePedagogy;
use App\Models\LearningSequenceResource;

use App\Models\PedagogyTag;
use App\Models\ResourceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Repo\ImageUpload;
use Parsedown;

class LearningSequenceController extends Controller
{

    use ImageUpload;


    public function LearningSequencedatatable(Request $request)
    {
        $query = LearningSequence::leftJoin('learning_sequence_goals', 'learning_sequences.id', '=', 'learning_sequence_goals.learning_sequence_id')
            ->leftJoin('goals', 'learning_sequence_goals.goal_id', '=', 'goals.id')
            ->leftJoin('learning_sequence_pedagogies', 'learning_sequences.id', '=', 'learning_sequence_pedagogies.learning_sequence_id')
            ->leftJoin('learning_sequence_resources', 'learning_sequences.id', '=', 'learning_sequence_resources.learning_sequence_id')
            ->leftJoin('pedagogy_tags', 'learning_sequence_pedagogies.pedagogy_tag_id', '=', 'pedagogy_tags.id')
            ->leftJoin('resource_types', 'learning_sequence_resources.resource_type_id', '=', 'resource_types.id')
            ->leftJoin('files', 'learning_sequences.id', '=', 'files.learning_sequence_id')
            ->where('learning_sequences.user_id', Auth::id())
            ->select('learning_sequences.id',
                'learning_sequences.content_type',
                DB::raw('MAX(learning_sequences.title) as title'),
                DB::raw('MAX(learning_sequences.description) as description'),
                DB::raw('GROUP_CONCAT(goals.id) as parent_goal_ids'),
                DB::raw('GROUP_CONCAT(goals.title) as assigned_goals'),
                DB::raw('GROUP_CONCAT(files.filename) as filenames'),
                DB::raw('GROUP_CONCAT(files.url) as urls'),
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(pedagogy_tags.id, ":", pedagogy_tags.title) SEPARATOR ",") as pedagogy_titles'),
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(resource_types.id, ":", resource_types.title) SEPARATOR ",") as resource_titles')
            )
            ->groupBy('learning_sequences.id','learning_sequences.content_type')
            ->orderBy('order_column', 'asc')
            ->orderBy('id', 'desc');

        if ($request->has('search') && !empty($request->search['value'])) {
            $searchValue = strtolower($request->search['value']);
            $query->where(function ($query) use ($searchValue) {
                $query->whereRaw("LOWER(learning_sequences.title) LIKE ?", ["%{$searchValue}%"])
                    ->orWhereRaw("LOWER(learning_sequences.description) LIKE ?", ["%{$searchValue}%"])
                    ->orWhereRaw("LOWER(goals.title) LIKE ?", ["%{$searchValue}%"])
                    ->orWhereHas('pedagogyTags', function ($q) use ($searchValue) {
                        $q->whereRaw("LOWER(pedagogy_tags.title) LIKE ?", ["%{$searchValue}%"]);
                    })
                    ->orWhereHas('resourceTypes', function ($q) use ($searchValue) {
                        $q->whereRaw("LOWER(resource_types.title) LIKE ?", ["%{$searchValue}%"]);
                    });
            });
        }

        $data = $query->get();

        $processedData = $data->map(function ($item) {
            $learningSequence = LearningSequence::find($item->id);
            $assignedGoals = $learningSequence ? $learningSequence->goals()->pluck('title')->toArray() : [];
            $pedagogy_titles = explode(',', $item->pedagogy_titles);
            $resource_titles = explode(',', $item->resource_titles);
            $item->assigned_goals = $assignedGoals;
            $item->pedagogy_titles = $pedagogy_titles;
            $item->resource_titles = $resource_titles;
            return $item;
        });

        return DataTables::of($processedData)
            ->addColumn('description', function ($data) {
                return strip_tags($data->description);
            })

            ->addColumn('action', function ($data) {

                $actions = '';
                $url_update = route('editLearningSequence', ['id' => $data->id]);
                $actions .= '&nbsp;<a class="label label-primary" data-title="Edit Learning Engagement" data-act="ajax-modal" data-append-id="AjaxModelContent" data-action-url="' . $url_update . '" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>';
                $actions .= '&nbsp;<button class="label label-primary splitButton" style="border: 0px;margin-left: 4px;" data-id="' . $data->id . '" data-description="' . htmlspecialchars($data->description) . '" data-content-type="' . $data->content_type . '" data-parent-goal-ids="' . $data->parent_goal_ids . '"><i class="fa fa-cut" aria-hidden="true"></i> Split</button>';

                $actions .= '&nbsp;<button type="button" class="label label-primary view-files" data-toggle="modal" data-target="#fileModal" data-filenames="' . $data->filenames . '"><i class="fa fa-file" aria-hidden="true"></i>View Files</button>';
                return $actions;
            })
            ->addColumn('assigned_goals', function ($data) {
                return implode(', ', $data->assigned_goals);
            })
            ->addColumn('pedagogy_titles', function ($data) {
                return implode(', ', $data->pedagogy_titles);
            })
            ->addColumn('resource_titles', function ($data) {
                return implode(', ', $data->resource_titles);
            })
            ->rawColumns(['action', 'assigned_goals', 'pedagogy_titles', 'resource_titles'])
            ->make(true);
    }

//    public function LearningSequencedatatable(Request $request)
//    {
//        $query = LearningSequence::leftJoin('learning_sequence_goals', 'learning_sequences.id', '=', 'learning_sequence_goals.learning_sequence_id')
//            ->leftJoin('goals', 'learning_sequence_goals.goal_id', '=', 'goals.id')
//            ->leftJoin('learning_sequence_pedagogies', 'learning_sequences.id', '=', 'learning_sequence_pedagogies.learning_sequence_id')
//            ->leftJoin('learning_sequence_resources', 'learning_sequences.id', '=', 'learning_sequence_resources.learning_sequence_id')
//            ->leftJoin('pedagogy_tags', 'learning_sequence_pedagogies.pedagogy_tag_id', '=', 'pedagogy_tags.id')
//            ->leftJoin('resource_types', 'learning_sequence_resources.resource_type_id', '=', 'resource_types.id')
//            ->leftJoin('files', 'learning_sequences.id', '=', 'files.learning_sequence_id')
//            ->where('learning_sequences.user_id', Auth::id())
//            ->select('learning_sequences.id',
//                DB::raw('MAX(learning_sequences.title) as title'),
//                DB::raw('MAX(learning_sequences.description) as description'),
//                DB::raw('GROUP_CONCAT(goals.id) as parent_goal_ids'),
//                DB::raw('GROUP_CONCAT(goals.title) as assigned_goals'),
//                DB::raw('GROUP_CONCAT(files.filename) as filenames'),
//                DB::raw('GROUP_CONCAT(files.url) as urls'),
//                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(pedagogy_tags.id, ":", pedagogy_tags.title) SEPARATOR ",") as pedagogy_titles'),
//                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(resource_types.id, ":", resource_types.title) SEPARATOR ",") as resource_titles')
//            )
//            ->groupBy('learning_sequences.id')
//            ->orderBy('order_column', 'asc')
//            ->orderBy('id', 'desc');
//
//        if ($request->has('search') && !empty($request->search['value'])) {
//            $searchValue = strtolower($request->search['value']);
//            $query->where(function ($query) use ($searchValue) {
//                $query->whereRaw("LOWER(learning_sequences.title) LIKE ?", ["%{$searchValue}%"])
//                    ->orWhereRaw("LOWER(learning_sequences.description) LIKE ?", ["%{$searchValue}%"])
//                    ->orWhereRaw("LOWER(goals.title) LIKE ?", ["%{$searchValue}%"])
//                    ->orWhereHas('pedagogyTags', function ($q) use ($searchValue) {
//                        $q->whereRaw("LOWER(pedagogy_tags.title) LIKE ?", ["%{$searchValue}%"]);
//                    })
//                    ->orWhereHas('resourceTypes', function ($q) use ($searchValue) {
//                        $q->whereRaw("LOWER(resource_types.title) LIKE ?", ["%{$searchValue}%"]);
//                    });
//            });
//        }
//
//        $data = $query->get();
//
//
//        $processedData = $data->map(function ($item) {
//            $learningSequence = LearningSequence::find($item->id);
//            $assignedGoals = $learningSequence ? $learningSequence->goals()->pluck('title')->toArray() : [];
//            $pedagogy_titles = explode(',', $item->pedagogy_titles);
//            $resource_titles = explode(',', $item->resource_titles);
//            $item->assigned_goals = $assignedGoals;
//            $item->pedagogy_titles = $pedagogy_titles;
//            $item->resource_titles = $resource_titles;
//            return $item;
//        });
//
//        return DataTables::of($processedData)
//            ->addColumn('description', function ($data) {
//                return strip_tags($data->description);
//            })
//
//            ->addColumn('action', function ($data) {
//                $actions = '';
//                $url_update = route('editLearningSequence', ['id' => $data->id]);
//                $actions .= '&nbsp;<a class="label label-primary" data-title="Edit Learning Engagement" data-act="ajax-modal" data-append-id="AjaxModelContent" data-action-url="' . $url_update . '" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>';
//                $actions .= '&nbsp;<button class="label label-primary splitButton" style="border: 0px;margin-left: 4px;" data-id="' . $data->id . '" data-description="' . $data->description . '" data-parent-goal-ids="' . $data->parent_goal_ids . '"><i class="fa fa-cut" aria-hidden="true"></i> Split</button>';
//                $actions .= '&nbsp;<button type="button" class="label label-primary view-files" data-toggle="modal" data-target="#fileModal" data-filenames="' . $data->filenames . '"><i class="fa fa-file" aria-hidden="true"></i>View Files</button>';
//                return $actions;
//            })
//            ->addColumn('assigned_goals', function ($data) {
//                return implode(', ', $data->assigned_goals);
//            })
//            ->addColumn('pedagogy_titles', function ($data) {
//                return implode(', ', $data->pedagogy_titles);
//            })
//            ->addColumn('resource_titles', function ($data) {
//                return implode(', ', $data->resource_titles);
//            })
//            ->rawColumns(['action', 'assigned_goals', 'pedagogy_titles', 'resource_titles'])
//            ->make(true);
//
//    }


    public function splitDescription(Request $request)
    {
        $learningSequenceId = $request->input('id');
        $description = $request->input('description');
        $parentGoalIds = $request->input('parent_goal_ids');
        $pedagogyTags = $request->input('pedagogy_tags');
        $resourceTags = $request->input('resource_tags');

        $learningSequence = LearningSequence::find($learningSequenceId);
        if (!$learningSequence) {
            return response()->json(['success' => false, 'message' => 'Learning sequence not found'], 404);
        }

        if (strpos($description, '-^|^-') === false) {
            return response()->json(['success' => false, 'message' => 'Please insert a "-^|^-" symbol to indicate where you want to split the description.']);
        }

        $parts = explode('-^|^-', $description);

        $goalIdsArray = !empty($parentGoalIds) ? explode(',', $parentGoalIds) : [];
        $goalIdsArray = array_map('intval', $goalIdsArray);

        $userId = Auth::id();
        $pedagogyTagIds = [];
        $resourceTagIds = [];

        if ($pedagogyTags !== "null" && !empty($pedagogyTags)) {
            $pedagogyTagIds = explode(',', $pedagogyTags);
        }

        if ($resourceTags !== "null" && !empty($resourceTags)) {
            $resourceTagIds = explode(',', $resourceTags);
        }

        if (!empty($goalIdsArray)) {
            $learningSequence->goals()->sync($goalIdsArray, ['user_id' => $userId]);
        }

        if (!empty($pedagogyTagIds)) {
            $learningSequence->pedagogyTags()->sync($pedagogyTagIds, ['user_id' => $userId]);
        }

        if (!empty($resourceTagIds)) {
            $learningSequence->resourceTypes()->sync($resourceTagIds, ['user_id' => $userId]);
        }

        foreach ($parts as $part) {
            $newLearningSequence = new LearningSequence([
                'title' => $learningSequence->title,
                'description' => $part,
                'user_id' => $userId,
                'parent_id' => $learningSequenceId,
            ]);
            $newLearningSequence->save();

            $originalFiles = $learningSequence->files()->get();


            foreach ($originalFiles as $file) {
                $newFile = new File([
                    'filename' => $file->filename,
                    'user_id' => $file->user_id,
                    'url' => $file->url,
                    'learning_sequence_id' => $newLearningSequence->id,
                ]);
                $newFile->save();
            }


            if (!empty($goalIdsArray)) {
                $newLearningSequence->goals()->sync($goalIdsArray, ['user_id' => $userId]);
            }

            if (!empty($pedagogyTagIds)) {
                $newLearningSequence->pedagogyTags()->sync($pedagogyTagIds, ['user_id' => $userId]);
            }

            if (!empty($resourceTagIds)) {
                $newLearningSequence->resourceTypes()->sync($resourceTagIds, ['user_id' => $userId]);
            }

            $this->assignGoalsToChildSequences($newLearningSequence, $goalIdsArray, $pedagogyTagIds, $resourceTagIds);
        }

        $combinedDescription = implode(' ', $parts);
        $learningSequence->description = $combinedDescription;
        $learningSequence->save();

        return response()->json(['success' => true, 'message' => 'Split operation completed successfully']);
    }

    public function assignGoalsToChildSequences($learningSequence, $syncData, $pedagogyTagIds, $resourceTagIds)
    {
        $userId = Auth::id();
        $childSequences = $learningSequence->children;
        foreach ($childSequences as $childSequence) {
            $childSequence->goals()->sync($syncData, ['user_id' => $userId]);

            if (!empty($pedagogyTagIds)) {
                $childSequence->pedagogyTags()->sync($pedagogyTagIds, ['user_id' => $userId]);
            }

            if (!empty($resourceTagIds)) {
                $childSequence->resourceTypes()->sync($resourceTagIds, ['user_id' => $userId]);
            }

            if ($childSequence->children->isNotEmpty()) {
                $this->assignGoalsToChildSequences($childSequence, $syncData, $pedagogyTagIds, $resourceTagIds);
            }
        }
    }


    public function assignGoalsToLearningSequence(Request $request)
    {
        $msg = [
            'selectedGoals.required' => 'Please choose at least one goal.',
            'selectedGoals.array' => 'Selected goals must be an array.',
            'selectedGoals.*.exists' => 'One or more selected goals do not exist.',
        ];

        $validator = Validator::make($request->all(), [
            'selectedGoals' => 'required|array',
            'selectedGoals.*' => 'exists:goals,id',
        ], $msg);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }

        try {
            $learningSequence = LearningSequence::findOrFail($request->input('learningSequenceId'));
            $selectedGoals = $request->input('selectedGoals');
            $userId = Auth::id();
            $syncData = [];
            foreach ($selectedGoals as $goalId) {
                $syncData[$goalId] = ['user_id' => $userId];
            }
            $learningSequence->goals()->sync($syncData);

            $this->assignGoalsToChildrenSequences($learningSequence, $syncData);

            return response()->json(['success' => true, 'message' => 'Goals assigned to learning sequence and its related sequences successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()]);

        }
    }

    public function assignGoalsToChildrenSequences($learningSequence, $syncData)
    {
        $userId = Auth::id();
        $childSequences = $learningSequence->children;
        foreach ($childSequences as $childSequence) {
            $childSequence->goals()->sync($syncData, ['user_id' => $userId]);
            if ($childSequence->children->isNotEmpty()) {
                $this->assignGoalsToChildrenSequences($childSequence, $syncData);
            }
        }
    }




    public function LearningSequenceindex()
    {

        return view('Backend.LearningSequence.All');
    }




    public function openPedagogyTagsModal(Request $request)
    {
        $learningSequenceId = $request->input('learningSequenceId');
        $learningSequence = LearningSequence::findOrFail($learningSequenceId);
        $assignedPedagogyTags = $learningSequence->pedagogyTags;

        $pedagogyTags = PedagogyTag::all();

        return response()->json([
            'pedagogyTags' => $pedagogyTags,
            'assignedPedagogyTags' => $assignedPedagogyTags,
        ]);
    }

    public function openResourceTypesModal(Request $request)
    {
        $learningSequenceId = $request->input('learningSequenceId');
        $learningSequence = LearningSequence::findOrFail($learningSequenceId);
        $assignedResourceTypes = $learningSequence->resourceTypes;

        $resourceTypes = ResourceType::all();

        return response()->json([
            'resourceTypes' => $resourceTypes,
            'assignedResourceTypes' => $assignedResourceTypes,
        ]);
    }



    public function store_pedagogy_tags(Request $request)
    {
        $rules = [
            'learningSequenceId' => 'required|exists:learning_sequences,id',
            'pedagogyTags' => 'required|array',
            'pedagogyTags.*' => 'exists:pedagogy_tags,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $learningSequence = LearningSequence::findOrFail($request->learningSequenceId);

            $userId = Auth::id();

            $existingTags = $learningSequence->pedagogyTags()->pluck('pedagogy_tags.id')->toArray();


            $syncData = [];
            foreach ($request->pedagogyTags as $tagId) {
                if (in_array($tagId, $existingTags)) {
                    $syncData[$tagId] = ['user_id' => $userId];
                } else {
                    $syncData[$tagId] = ['user_id' => $userId];
                }
            }

            $learningSequence->pedagogyTags()->sync($syncData);


            $this->assignPedagogyTagsToChildSequences($learningSequence, $request->pedagogyTags, $userId);

            return response()->json(['message' => 'Pedagogy tags successfully added for the learning sequence.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 422);
        }
    }

    public function assignPedagogyTagsToChildSequences($learningSequence, $pedagogyTags, $userId)
    {
        $childSequences = $learningSequence->children;
        foreach ($childSequences as $childSequence) {

            $childSequence->pedagogyTags()->sync($pedagogyTags, ['user_id' => $userId]);

            if ($childSequence->children->isNotEmpty()) {
                $this->assignPedagogyTagsToChildSequences($childSequence, $pedagogyTags, $userId);
            }
        }
    }

    public function storeResourceTypes(Request $request){

        $validator = Validator::make($request->all(), [
            'resourceTypes' => 'required|array',
            'resourceTypes.*' => 'exists:resource_types,id',
            'learningSequenceId' => 'required|exists:learning_sequences,id',
        ], [
            'resourceTypes.required' => 'Please select at least one resource type.',
            'resourceTypes.*.exists' => 'One or more selected resource types do not exist.',
            'learningSequenceId.required' => 'Learning sequence ID is required.',
            'learningSequenceId.exists' => 'Learning sequence not found.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        try {
            $learningSequence = LearningSequence::findOrFail($request->input('learningSequenceId'));
            $selectedResourceTypes = $request->input('resourceTypes');
            $userId = Auth::id();


            $existingResourceTypes = $learningSequence->resourceTypes()->pluck('resource_types.id')->toArray();


            $syncData = [];
            foreach ($selectedResourceTypes as $resourceTypeId) {
                $syncData[$resourceTypeId] = ['user_id' => $userId];
            }


            if (!empty($existingResourceTypes)) {
                $learningSequence->resourceTypes()->sync($syncData);
            } else {
                $learningSequence->resourceTypes()->attach($selectedResourceTypes, ['user_id' => $userId]);
            }


            $this->assignResourceTypesToChildrenSequences($learningSequence, $syncData);

            return response()->json(['success' => true, 'message' => 'Resource types assigned to learning sequence and its related sequences successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()]);
        }
    }

    public function assignResourceTypesToChildrenSequences($learningSequence, $syncData)
    {
        $userId = Auth::id();
        $childSequences = $learningSequence->children;
        foreach ($childSequences as $childSequence) {

            if ($childSequence->resourceTypes()->exists()) {
                $childSequence->resourceTypes()->sync($syncData, ['user_id' => $userId]);
            } else {
                $childSequence->resourceTypes()->attach(array_keys($syncData), ['user_id' => $userId]);
            }


            if ($childSequence->children->isNotEmpty()) {
                $this->assignResourceTypesToChildrenSequences($childSequence, $syncData);
            }
        }
    }




    public function createAggregatedSequence(Request $request)
    {
        $rules = [
            'title' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user_id = Auth::id();


        $aggregatedSequence = new LearningSequence();
        $aggregatedSequence->title = $request->input('title');
        $aggregatedSequence->description = $request->input('description');
        $aggregatedSequence->user_id = $user_id;
        $aggregatedSequence->parent_id = 0;
        $aggregatedSequence->save();


        $selectedSequences = $request->input('selectedSequences');

        foreach ($selectedSequences as $sequenceId) {
            $childSequence = LearningSequence::findOrFail($sequenceId);
            $this->updateParentIdRecursively($childSequence, $aggregatedSequence->id);
        }

        return response()->json(['message' => 'Aggregated learning sequence created successfully']);
    }

    private function updateParentIdRecursively($sequence, $parentId)
    {
        $sequence->parent_id = $parentId;
        $sequence->save();

        foreach ($sequence->children as $childSequence) {
            $this->updateParentIdRecursively($childSequence, $sequence->id);
        }
    }



    public function fetchSequenceData($id)
    {
        $sequence= LearningSequence::with('files')->findOrFail($id);
        $fileData = [];
        foreach ($sequence->files as $file) {
            $fileData[] = [
                'filename' => $file->filename,
                'url' => $file->url,
                'learningSequenceId' => $file->learning_sequence_id,
                'userId' => $file->user_id
            ];
        }
        $data = [
            'id' => $sequence->id,
            'description' => $sequence->description,
            'goals' => $sequence->goals->pluck('id')->toArray(),
            'pedagogyTags' => $sequence->pedagogyTags->pluck('id')->toArray(),
            'resourceTags' => $sequence->resourceTypes->pluck('id')->toArray(),
            'fileData' => $fileData

        ];

        return response()->json(['data' => $data]);
    }





    public function fetchLearningSequencepedagogytag(Request $request)
    {
        $id=$request->id;
        $learningSequencePedagogies = LearningSequencePedagogy::where('learning_sequence_id', $id)
            ->join('pedagogy_tags', 'learning_sequence_pedagogies.pedagogy_tag_id', '=', 'pedagogy_tags.id')
            ->select('learning_sequence_pedagogies.*', 'pedagogy_tags.title as pedagogy_tag_title')
            ->get();

        return response()->json(['learningSequencePedagogies' => $learningSequencePedagogies]);
    }

    public function fetchLearningSequenceResourceTypes(Request $request)
    {
        $id = $request->id;
        $learningSequenceResourceTypes = LearningSequence::findOrFail($id)
            ->resourceTypes()
            ->get(['resource_types.id', 'resource_types.title']);
        return response()->json(['learningSequenceResourceTypes' => $learningSequenceResourceTypes]);
    }



    public function fetchGoalHierarchy(Request $request)
    {
        try {
            $learningSequenceId = $request->input('learningSequenceId');
            $goals = Goal::with('subGoals')->where(['user_id' => Auth::user()->id, 'parrent_id' => null])->get();
            $assignedGoals = $this->fetchAssignedGoals($learningSequenceId);

            foreach ($goals as $goal) {
                $goal->subGoals = $this->fetchSubGoals($goal->id);
            }

            return response()->json(['goals' => $goals, 'assignedGoals' => $assignedGoals]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch goal hierarchy'], 500);
        }
    }

    private function fetchAssignedGoals($learningSequenceId)
    {
        try {
            $assignedGoals = LearningSequenceGoal::where('learning_sequence_id', $learningSequenceId)
                ->pluck('goal_id')
                ->toArray();

            return $assignedGoals;
        } catch (\Exception $e) {

            return [];
        }
    }


    private function fetchSubGoals($parentId)
    {
        $subGoals = Goal::with('subGoals')->where(['user_id' => Auth::user()->id, 'parrent_id' => $parentId])->get();

        foreach ($subGoals as $subGoal) {
            $subGoal->subGoals = $this->fetchSubGoals($subGoal->id);
        }

        return $subGoals;
    }

    public function getGoalsForModal(Request $request)
    {
        $learningSequenceId = $request->input('learningSequenceId');


        try {
            $learningSequence = LearningSequence::findOrFail($learningSequenceId);
            $assignedGoals = $learningSequence->goals()->pluck('goals.id')->toArray();

            return response()->json(['success' => true, 'goals' => $assignedGoals]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error occurred while fetching assigned goals.']);
        }
    }



    public function LearningSequenceadd(){
        return view('Backend.LearningSequence.Add');
    }



    public function LearningSequencesave(Request $request)
    {
        $customMessages = [
            'title.required' => 'The title field is required.',
//            'description.required' => 'The description field is required.',
            'files.*.file' => 'Each uploaded file must be a valid file.',
            'files.*.mimes' => 'Each file must be of type: pdf, doc, docx, jpeg, jpg, png, gif, bmp, webp.',
            'linked_content.*.valid_url_array' => 'The Linked content URL must be a valid URL.',

        ];

        $this->validate($request, [
            'title' => 'required',
//            'description' => 'required',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,jpeg,jpg,png,gif,bmp,webp',
            'linked_content.*' => 'nullable|valid_url_array',
        ], $customMessages);



        $learningSequence = new LearningSequence();
        $learningSequence->user_id = Auth::user()->id;
        $learningSequence->title = $request->title;
        $learningSequence->content_type  = $request->content_type ;
        if ($request->content_type === 'qti') {
            $learningSequence->stem = $request->stem;
            $learningSequence->key_data = $request->key;
            $learningSequence->save();


            $correctFoils = array_map('intval', $request->input('correct_foils', []));
            foreach ($request->foils as $index => $foil) {
                $index = (int) $index;
                $is_correct = in_array($index, $correctFoils);

                FoilFeedback::create([
                    'learning_sequence_id' => $learningSequence->id,
                    'foil' => $foil,
                    'user_id'=> Auth::user()->id,
                    'feedback' => $request->feedbacks[$index],
                    'is_correct' => $is_correct ? 1 : 0
                ]);
            }
        }elseif ($request->content_type === 'md') {
            $parsedown = new Parsedown();
            $htmlContent = $parsedown->text($request->description);
            $learningSequence->description = $htmlContent;
        }

       else {
            $learningSequence->description = $request->description;
        }

        $learningSequence->save();

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $index => $file) {
                if ($file->isValid()) {
                    $filePath = $this->imageUpload($file, 'Files');
                    if ($filePath) {
                        $productImg = new File();
                        $productImg->filename = $filePath;
                        $productImg->user_id = Auth::user()->id;
                        $productImg->url = $request->linked_content[$index] ?? null;
                        $productImg->learning_sequence_id = $learningSequence->id;
                        $productImg->save();
                    } else {
                        return redirect()->back()->with('error', 'Failed to upload file.');
                    }
                } else {
                    return redirect()->back()->with('error', 'Invalid file uploaded.');
                }
            }
        }

        Session::flash('success', 'Learning sequence created successfully!');
        return redirect()->back();


    }


    public function LearningSequenceedit($id)
    {
        $learningSequence = LearningSequence::with('children.children')->findOrFail($id);

        $files = File::where('learning_sequence_id', $id)->get();
        if ($learningSequence->children->isNotEmpty()) {
            foreach ($learningSequence->children as $child) {
                $childFiles = File::where('learning_sequence_id', $child->id)->get();
                $files = $files->merge($childFiles);
            }
        }


        $foils = [];
        $feedbacks = [];
        $correctFoils = [];
        if ($learningSequence->content_type === 'qti') {
            $foilFeedbacks = FoilFeedback::where('learning_sequence_id', $id)->get();
            foreach ($foilFeedbacks as $index => $foilFeedback) {
                $foils[$index] = $foilFeedback->foil;
                $feedbacks[$index] = $foilFeedback->feedback;
                if ($foilFeedback->is_correct) {
                    $correctFoils[] = $index;
                }
            }
        }

        return view('Backend.LearningSequence.Edit', compact('learningSequence', 'files', 'foils', 'feedbacks','correctFoils'));
    }


    public function LearningSequenceupdate(Request $request, $id)
    {

        $customMessages = [
            'title.required' => 'The title field is required.',
//            'description.required' => 'The description field is required.',
            'files.*.file' => 'Each uploaded file must be a valid file.',
            'files.*.mimes' => 'Each file must be of type: pdf, doc, docx, jpeg, jpg, png, gif, bmp, webp.',
            'child_title.*.required' => 'The child title field is required.',
            'child_description.*.required' => 'The child description field is required.',
        ];

        $this->validate($request, [
            'title' => 'required',
//            'description' => 'required',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,jpeg,jpg,png,gif,bmp,webp',
            'linked_content.*' => 'nullable|valid_url_array',
            'child_title.*' => 'sometimes|required|string',
            'child_description.*' => 'sometimes|required|string',
        ], $customMessages);

        $update = LearningSequence::findOrFail($id);
        $update->title = $request->title;
        $update->content_type  = $request->content_type ;
        if ($request->content_type === 'qti') {
            $update->stem = $request->stem;
            $update->key_data = $request->key;
            $update->save();

            FoilFeedback::where('learning_sequence_id', $id)->delete();

            $correctFoils = array_map('intval', $request->input('correct_foils', []));

            foreach ($request->foils as $index => $foil) {
                $index = (int) $index;
                $is_correct = in_array($index, $correctFoils);

                FoilFeedback::create([
                    'learning_sequence_id' => $update->id,
                    'foil' => $foil,
                    'user_id' => Auth::user()->id,
                    'feedback' => $request->feedbacks[$index],
                    'is_correct' => $is_correct ? 1 : 0
                ]);
            }
        } elseif ($request->content_type === 'md') {
            $parsedown = new Parsedown();
            $htmlContent = $parsedown->text($request->description);
            $update->description = $htmlContent;
        } else {

            $update->description = $request->description;
        }
        $update->save();

        $learning_sequence_id=$update->id;

        $linkedContentArray = $request->linked_content;
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $index => $file) {
                $filePath = $this->imageUpload($file, 'Files');
                $productImg = new File();
                $productImg->filename = $filePath;
                $productImg->learning_sequence_id = $learning_sequence_id;
                $productImg->user_id = Auth::user()->id;
                $productImg->url = $linkedContentArray[$index] ?? null;
                $productImg->save();
            }
        }

        if ($request->has('child_title')) {
            $this->updateChildren($update, $request->child_title, $request->child_description, $request->child_id);
        }
        Session::flash('success', "Learning sequence updated successfully.");
        return redirect()->back();
    }



    protected function updateChildren($parent, $titles, $descriptions, $ids)
    {
        foreach ($titles as $index => $title) {
            $childId = $ids[$index];
            $child = LearningSequence::findOrFail($childId);
            $child->title = $title;
            $child->description = $descriptions[$index];
            $child->save();
        }
    }

    public function deleteLearningSequenceFile($fileId)
    {

        $file = File::find($fileId);

        if (!$file) {
            return response()->json(['message' => 'File not found.'], 404);
        }
        if (file_exists(public_path($file->filename))) {
            @unlink(public_path($file->filename));
        }

        $file->delete();

        return response()->json(['message' => 'File deleted successfully.']);
    }


    public function LearningSequencedelete(Request $request, $id)
    {

        $learningSequence = LearningSequence::findOrFail($id);
        $files = File::where('learning_sequence_id', $id)->get();
        foreach ($files as $file) {
            @unlink(public_path($file->filename));
            $file->delete();
        }


        if ($learningSequence->content_type === 'qti') {
            FoilFeedback::where('learning_sequence_id', $id)->delete();
        }


        $learningSequence->goals()->detach();
        $learningSequence->pedagogyTags()->detach();
        $learningSequence->resourceTypes()->detach();


        if ($learningSequence->parent_id === 0) {

            $childSequences = LearningSequence::where('parent_id', $id)->get();
            foreach ($childSequences as $childSequence) {
                $childSequence->parent_id = 0;
                $childSequence->save();
            }

            $learningSequence->delete();

            return response()->json(['success' => true, 'message' => 'Parent learning sequence deleted successfully']);
        } else {

            $parent = $learningSequence->parent;
            $parent->description = str_replace($learningSequence->description, '', $parent->description);
            $parent->description = str_replace(',', ' ', $parent->description);
            $parent->description = trim($parent->description);
            $parent->save();


            $learningSequence->delete();

            return response()->json(['success' => true, 'message' => 'Child learning sequence deleted successfully']);
        }
    }
    public function updateOrder(Request $request)
    {
        $newOrder = $request->get('newOrder');
        foreach ($newOrder as $index => $itemId) {
            $learningSequence = LearningSequence::find($itemId);
            if ($learningSequence) {
                $learningSequence->order_column = $index;
                $learningSequence->save();
            }
        }


        return response()->json(['success' => true]);
    }

    public function download_file($filename){


        $path = public_path() . '/uploads/files/' . $filename;


        if (file_exists($path)) {
            return response()->download($path);
        } else {
            abort(404, 'File not found.');
        }
    }

    public function buildCourse(Request $request)
    {
        $activities = $request->activities;
        $course = new Course();
        $course->title = $request->get('title');
        $course->user_id = Auth::user()['id'];
        $course->save();

        $this->addInstructorToCourse($course->id, Auth::id());

        foreach ($activities as $index => $activity) {
            $courseLearningSequence = new CourseLearningSequence();
            $courseLearningSequence->course_id = $course->id;
            $courseLearningSequence->learning_sequence_id = $activity['sequenceId'];
            $courseLearningSequence->user_id = Auth::user()['id'];
            $courseLearningSequence->title =$activity['title'];
            $courseLearningSequence->description =$activity['description'];
            $courseLearningSequence->content_type =$activity['content_type'];
            $courseLearningSequence->order_column = $index + 1;
            $courseLearningSequence->save();
        }

        return response()->json(['success' => true, 'message' => 'Course built successfully']);
    }



    protected function addInstructorToCourse($courseId, $instructorId)
    {
        CourseStudent::updateOrCreate(
            ['course_id' => $courseId, 'instructor_id' => $instructorId],
            ['student_id' => null]
        );
    }










}
