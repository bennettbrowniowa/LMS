<?php

use App\Http\Controllers\Backend\Student\StudentController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'checkUserRole:admin'], function () {

    Route::get('/locked',['as' => 'locked', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@locked']);
    Route::post('/lockedOut',['as' => 'lockedOut', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@lockedOut']);
    Route::get('/lockedLogout',['as' => 'lockedLogout', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@lockedLogout']);
    Route::get('/logout',['as' => 'logout', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@logout']);


});

Route::group(['middleware' => 'checkUserRole:Instructor'], function () {
    Route::get('/instructor-locked',['as' => 'instructor_locked', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@instructor_locked']);
    Route::post('/instructor-lockedOut',['as' => 'instructor_lockedOut', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@instructor_lockedOut']);

    Route::get('/instructor-lockedLogout',['as' => 'instructor_lockedLogout', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@instructor_lockedLogout']);
    Route::get('/instructor_logout',['as' => 'instructor_logout', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@instructor_logout']);

});
Route::group(['middleware' => 'checkUserRole:Student'], function () {
    Route::get('/student-locked',['as' => 'student_locked', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@student_locked']);
    Route::post('/student-lockedOut',['as' => 'student_lockedOut', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@student_lockedOut']);
    Route::get('/student-lockedLogout',['as' => 'student_lockedLogout', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@student_lockedLogout']);
    Route::get('/student_logout',['as' => 'student_logout', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@student_logout']);


});
Route::get('/auth/student',['as' => 'login_student', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@login_student']);
Route::post('/auth/student',['as' => 'login_validate_student', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@login_validate_student']);


Route::get('/auth/instructor',['as' => 'login_instructor', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@login_instructor']);
Route::post('/auth/instructor',['as' => 'login_validate_instructor', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@login_validate_instructor']);


Route::get('/auth',['as' => 'login', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@login']);
Route::post('/auth',['as' => 'login_validate', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@login_validate']);



Route::get('/forgot',['as' => 'forgot', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@forgot']);
Route::post('/forgot_post',['as' => 'forgot_post', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@forgot_post']);


Route::get('/student-reset-password-form/{id}',['as' => 'student_reset_password', 'uses' => 'App\Http\Controllers\Backend\InstructorStudent\InstructorStudentController@student_reset_password']);
Route::post('/student-save-reset-password',['as' => 'student_save_reset_password', 'uses' => 'App\Http\Controllers\Backend\InstructorStudent\InstructorStudentController@student_save_reset_password']);

Route::get('/resetPassword/{id}',['as' => 'resetPassword', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@resetPassword']);
Route::post('/saveResetPassword/{id}',['as' => 'saveResetPassword', 'uses' => 'App\Http\Controllers\Backend\Auth\AuthController@saveResetPassword']);

Route::get('auth/github',  'App\Http\Controllers\Backend\GitHub\GitHubController@gitRedirect');
Route::get('auth/github/callback', 'App\Http\Controllers\Backend\GitHub\GitHubController@gitCallback')->middleware('nocache');


Route::get('/auth/student/google', ['as' =>'auth_google_student', 'uses' => 'App\Http\Controllers\Backend\GoogleStudent\GoogleStudentController@redirectToGoogleStudent']);

Route::get('/auth/student/google/callback', ['uses' =>'App\Http\Controllers\Backend\GoogleStudent\GoogleStudentController@handleGoogleStudentCallback'])->middleware('nocache');



Route::get('/google/redirect', 'App\Http\Controllers\Backend\GoogleLogin\GoogleLoginController@redirectToGoogle');
Route::get('auth/google/callback', ['uses' =>'App\Http\Controllers\Backend\GoogleLogin\GoogleLoginController@handleGoogleCallback'])->middleware('nocache');

Route::get('/qusteam',['as' => 'sps_form',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@form_submit']);
Route::post('/qusteam-save',['as' => 'save_form',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@form_save']);
Route::get('/register-success',['as' => 'register_success',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@success_msg']);
Route::get('/block',['as' => 'block',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@block_user']);

Route::get('course/invitation/accept/{token}',  ['as' => 'course_invitation', 'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@acceptInvitation']);

Route::group(['middleware' => ['web','permission:access-panel']], function () {

    Route::get('checkIdle', array('as' => 'checkIdle', function(){return 1;}));
    Route::get('', array('as' => 'baseURL', function(){return 1;}));

    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'App\Http\Controllers\Backend\Dashboard\DashboardController@dashboard', 'middleware' => ['role:admin']]);

    Route::group(['prefix' =>'instructor', 'middleware' => ['role:Instructor']], function() {
        Route::get('/instructor-dashboard',['as' => 'instructor_dashboard',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@instructor_dashboard']);
        Route::get('/course-datatable',['as' => 'coursedatatable',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@coursedatatable']);
        Route::get('/course-enroll/{id}',['as' => 'courseenroll',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@courseenroll']);
        Route::post('/course-assign',['as' => 'courseassign',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@courseassign']);
        Route::get('/get-enrolled-students/{courseId}',['as' => 'get_enrolled_students',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@getEnrolledStudents']);
        Route::post('/courses/{courseId}/remove-instructor',['as' => 'removeInstructor',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@removeInstructor']);
        Route::post('/courses/delete/{courseId}',['as' => 'deleteCourse',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@deleteCourse']);


        //Goal
        Route::get('/Goal',['as' => 'allGoal',  'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@index']);
        Route::get('/allGoalDatatable',['as' => 'allGoalDatatable',  'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@datatable']);
        Route::get('/add',['as' => 'addGoal',  'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@add']);
        Route::post('/save',['as' => 'saveGoal', 'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@save']);
        Route::get('/edit/{id}',['as' =>'editGoal',  'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@editGoal']);
        Route::post('/updateGoal/{id}', ['as' => 'updateGoal', 'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@updateGoal']);
        Route::get('/deleteGoal/{id}',['as' => 'deleteGoal', 'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@deletegoal']);

        Route::post('/move-goal' ,['as' => 'movegoal', 'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@movegoal']);
        Route::post('/move-sub-goal' ,['as' => 'movesubgoal', 'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@movesubgoal']);
        Route::post('/move-subgoal-down' ,['as' => 'move_subgoal_down', 'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@moveSubgoaldown']);
        Route::post('/reorder-subgoals', ['as' => 'reorderSubgoals', 'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@reorderSubgoals']);
        Route::get('/get-available-positions',  ['as' => 'getAvailablePositions', 'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@getAvailablePositions']);
        Route::get('/get-subgoal-available-positions',  ['as' => 'getsubgoalAvailablePositions', 'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@getsubgoalAvailablePositions']);


        // Sub Goals created by chanchal on 3/06/2024/ pankaj absence
        Route::get('/sub-goal/{id}',['as' => 'subGoal',  'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@subGoal']);
        Route::get('/sub-goal-datatable/{id}',['as' => 'allsubGoal',  'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@GetsubGoal']);
        Route::get('/add-sub-goal/{id}',['as' => 'addsubGoal',  'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@addsubGoal']);
        Route::post('/save-subgoal/{id}',['as' => 'savesubGoal', 'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@savesubgoal']);
        Route::get('subgoal/edit/{id}',['as' => 'editsubGoal',  'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@editsubgoal']);
        Route::post('/update/{id}',['as' => 'updatesubGoal', 'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@updatesubgoal']);
        Route::get('/delete/{id}',['as' => 'deletesubGoal', 'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@deletesubgoal']);
        Route::post('/save-sub-goal',['as' => 'save_sub_Goal', 'uses' => 'App\Http\Controllers\Backend\Goal\GoalController@save_sub_Goal']);

        //LearningSequence
        Route::get('/LearningSequence',['as' => 'allLearningSequence',  'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@LearningSequenceindex']);
        Route::get('/allLearningSequenceDatatable',['as' => 'allLearningSequenceDatatable',  'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@LearningSequencedatatable']);
        Route::get('/addLearningSequence',['as' => 'addLearningSequence',  'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@LearningSequenceadd']);
        Route::post('/saveLearningSequence',['as' => 'saveLearningSequence', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@LearningSequencesave']);
        Route::get('/editLearningSequence/{id}',['as' => 'editLearningSequence',  'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@LearningSequenceedit']);
        Route::post('/updateLearningSequence/{id}',['as' => 'updateLearningSequence', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@LearningSequenceupdate']);
        Route::get('/deleteLearningSequence/{id}',['as' => 'deleteLearningSequence', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@LearningSequencedelete']);
        Route::get('/get-goal',['as' => 'get_goal',  'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@getGoalsForModal']);
        Route::post('/assign-goals-to-learning-sequence',['as' => 'assign_goals_to_learning_sequence',  'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@assignGoalsToLearningSequence']);
        Route::post('/split-description',['as' => 'split_description',  'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@splitDescription']);
        Route::get('/get-goal-hierarchy',['as' => 'get_goal_hierarchy', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@fetchGoalHierarchy']);
        Route::post('/update_order_endpoint',['as' => 'updateOrder', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@updateOrder']);
        Route::get('/open-pedagogy-tags-modal',['as' => 'open_pedagogy_tags_modal', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@openPedagogyTagsModal']);
        Route::get('/open-resource-types-modal',['as' => 'open_resource_types_modal', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@openResourceTypesModal']);
        Route::post('/store-pedagogy-tags',['as' => 'store_pedagogy_tags', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@store_pedagogy_tags']);
        Route::post('/store-Resource-Types',['as' => 'storeResourceTypes', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@storeResourceTypes']);
        Route::get('/fetch-Learning-Sequence',['as' => 'fetchLearningSequencepedagogytag', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@fetchLearningSequencepedagogytag']);
        Route::get('/fetch-Learning-Sequence-Resource-Types',['as' => 'fetchLearningSequenceResourceTypes', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@fetchLearningSequenceResourceTypes']);
        Route::post('/create-aggregated-sequence',['as' => 'create_aggregated_sequence', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@createAggregatedSequence']);
        Route::get('/fetch-sequence-data/{id}',['as' => 'fetch_sequence_data', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@fetchSequenceData']);
        Route::get('/learning-sequence/{fileId}',  ['as' => 'deleteLearningSequenceFile', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@deleteLearningSequenceFile']);
        Route::get('/download/{filename}',  ['as' => 'download_file', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@download_file']);
        Route::post('build-course',  ['as' => 'build_course', 'uses' => 'App\Http\Controllers\Backend\LearningSequence\LearningSequenceController@buildcourse']);
        Route::get('/course-invite/{id}',  ['as' => 'inviteStudentsForm', 'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@inviteStudentsForm']);
        Route::post('/store-invitation',  ['as' => 'store_invitation', 'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@store_invitation']);


        //instructor-student
        Route::get('/instructor-student',['as' => 'allinstructorstudent',  'uses' => 'App\Http\Controllers\Backend\InstructorStudent\InstructorStudentController@index']);
        Route::get('/allinstructorstudent',['as' => 'allinstructorstudentdatatable',  'uses' => 'App\Http\Controllers\Backend\InstructorStudent\InstructorStudentController@datatable']);
        Route::get('/add-instructor-student',['as' => 'addinstructorstudent',  'uses' => 'App\Http\Controllers\Backend\InstructorStudent\InstructorStudentController@add']);
        Route::post('/save-instructor-student',['as' => 'saveinstructorstudent', 'uses' => 'App\Http\Controllers\Backend\InstructorStudent\InstructorStudentController@save']);
        Route::get('/edit-instructor-student/{id}',['as' =>'editinstructorstudent',  'uses' => 'App\Http\Controllers\Backend\InstructorStudent\InstructorStudentController@edit']);
        Route::post('/update-instructor-student/{id}', ['as' => 'updateinstructorstudent', 'uses' => 'App\Http\Controllers\Backend\InstructorStudent\InstructorStudentController@update']);
        Route::get('/delete-instructor-student/{id}',['as' => 'deleteinstructorstudent', 'uses' => 'App\Http\Controllers\Backend\InstructorStudent\InstructorStudentController@delete']);




    });

    Route::group(['prefix' =>'student', 'middleware' => ['role:Student']], function() {

        Route::get('/allstudentDatatable',['as' => 'allstudentDatatable',  'uses' => 'App\Http\Controllers\Backend\Student\StudentController@studentDatatable']);

        Route::get('/student-dashboard',['as' => 'student_dashboard',  'uses' => 'App\Http\Controllers\Backend\Student\StudentController@student_dashboard']);

        Route::get('/course/{courseId}', [StudentController::class, 'showCourse'])->name('show.course');
        Route::post('/activity/{sequenceId}/next', [StudentController::class, 'nextActivity'])->name('next.learning_sequence');
        Route::get('/activity/{sequenceId}', [StudentController::class, 'renderActivity'])->name('render.learning_sequence');
        Route::get('/nextactivity/{sequenceId}', [StudentController::class, 'rendernextActivity'])->name('render.nextlearning_sequence');

    });

    //Setting
    Route::group(['prefix' => 'settings'], function () {
        //General Setting
        Route::get('/generalSetting', ['as' => 'generalSetting', 'middleware' => ['web', 'permission:view-general-setting'], 'uses' => 'App\Http\Controllers\Backend\Settings\GeneralSettingsController@index']);
        Route::post('/saveGeneralSetting/{id}', ['as' => 'saveGeneralSetting', 'middleware' => ['web', 'permission:update-general-setting'], 'uses' => 'App\Http\Controllers\Backend\Settings\GeneralSettingsController@saveGeneralSetting']);

        //Company Setting
        Route::get('/companySetting', ['as' => 'companySetting', 'middleware' => ['web', 'permission:view-company-setting'], 'uses' => 'App\Http\Controllers\Backend\Settings\CompanySettingsController@index']);
        Route::post('/saveCompanySetting/{id}', ['as' => 'saveCompanySetting', 'middleware' => ['web', 'permission:update-company-setting'], 'uses' => 'App\Http\Controllers\Backend\Settings\CompanySettingsController@saveCompanySetting']);

        //Email Setting
        Route::get('/emailSetting', ['as' => 'emailSetting', 'middleware' => ['web', 'permission:view-email-setting'], 'uses' => 'App\Http\Controllers\Backend\Settings\EmailSettingsController@index']);
        Route::post('/saveEmailSetting/{id}', ['as' => 'saveEmailSetting', 'middleware' => ['web', 'permission:update-email-setting'], 'uses' => 'App\Http\Controllers\Backend\Settings\EmailSettingsController@saveEmailSetting']);

        //Country Setting
        Route::get('/countries', ['as' => 'countries', 'middleware' => ['web', 'permission:view-country'], 'uses' => 'App\Http\Controllers\Backend\Settings\CountryController@index']);
        Route::get('/countriesDatatable', ['as' => 'countriesDatatable', 'middleware' => ['web', 'permission:view-country'], 'uses' => 'App\Http\Controllers\Backend\Settings\CountryController@datatable']);
        Route::get('/addCountry', ['as' => 'addCountry', 'middleware' => ['web', 'permission:add-country'], 'uses' => 'App\Http\Controllers\Backend\Settings\CountryController@add']);
        Route::post('/saveCountry', ['as' => 'saveCountry', 'middleware' => ['web', 'permission:add-country'], 'uses' => 'App\Http\Controllers\Backend\Settings\CountryController@save']);
        Route::get('/editCountry/{id}', ['as' => 'editCountry', 'middleware' => ['web', 'permission:view-country'], 'uses' => 'App\Http\Controllers\Backend\Settings\CountryController@edit']);
        Route::post('/updateCountry/{id}', ['as' => 'updateCountry', 'middleware' => ['web', 'permission:update-country'], 'uses' => 'App\Http\Controllers\Backend\Settings\CountryController@update']);
        Route::get('/deleteCountry/{id}', ['as' => 'deleteCountry', 'middleware' => ['web', 'permission:delete-country'], 'uses' => 'App\Http\Controllers\Backend\Settings\CountryController@delete']);
        Route::get('/countryOptions', ['as' => 'countryOptions', 'middleware' => ['web', 'permission:view-country'], 'uses' => 'App\Http\Controllers\Backend\Settings\CountryController@countryOptions']);

        //State Setting
        Route::get('/states', ['as' => 'states', 'middleware' => ['web', 'permission:view-state'], 'uses' => 'App\Http\Controllers\Backend\Settings\StateController@index']);
        Route::get('/statesDatatable', ['as' => 'statesDatatable', 'middleware' => ['web', 'permission:view-state'], 'uses' => 'App\Http\Controllers\Backend\Settings\StateController@datatable']);
        Route::get('/addState', ['as' => 'addState', 'middleware' => ['web', 'permission:add-state'], 'uses' => 'App\Http\Controllers\Backend\Settings\StateController@add']);
        Route::post('/saveState', ['as' => 'saveState', 'middleware' => ['web', 'permission:add-state'], 'uses' => 'App\Http\Controllers\Backend\Settings\StateController@save']);
        Route::get('/editState/{id}', ['as' => 'editState', 'middleware' => ['web', 'permission:view-state'], 'uses' => 'App\Http\Controllers\Backend\Settings\StateController@edit']);
        Route::post('/updateState/{id}', ['as' => 'updateState', 'middleware' => ['web', 'permission:update-state'], 'uses' => 'App\Http\Controllers\Backend\Settings\StateController@update']);
        Route::get('/deleteState/{id}', ['as' => 'deleteState', 'middleware' => ['web', 'permission:delete-state'], 'uses' => 'App\Http\Controllers\Backend\Settings\StateController@delete']);
        Route::get('/stateOptions', ['as' => 'stateOptions', 'middleware' => ['web', 'permission:view-state'], 'uses' => 'App\Http\Controllers\Backend\Settings\StateController@stateOptions']);
        Route::get('/countryWiseStateOptions/{CountryID?}', ['as' => 'countrywiseStateOptions', 'middleware' => ['web'], 'uses' => 'App\Http\Controllers\Backend\Settings\StateController@countryWiseStateOptions']);

        //Permission Setting
        Route::get('/permission', ['as' => 'permission', 'middleware' => ['web', 'permission:view-permission'], 'uses' => 'App\Http\Controllers\Backend\Settings\PermissionController@index']);
        Route::post('/savePermission', ['as' => 'savePermission', 'middleware' => ['web', 'permission:add-permission'], 'uses' => 'App\Http\Controllers\Backend\Settings\PermissionController@savePermission']);
        Route::get('/editPermission/{id}', ['as' => 'editPermission', 'middleware' => ['web', 'permission:view-permission'], 'uses' => 'App\Http\Controllers\Backend\Settings\PermissionController@editPermission']);
        Route::post('/updatePermission/{id}', ['as' => 'updatePermission', 'middleware' => ['web', 'permission:update-permission'], 'uses' => 'App\Http\Controllers\Backend\Settings\PermissionController@updatePermission']);
        Route::get('/deletePermission/{id}', ['as' => 'deletePermission', 'middleware' => ['web', 'permission:delete-permission'], 'uses' => 'App\Http\Controllers\Backend\Settings\PermissionController@deletePermission']);

        //Roles Setting
        Route::get('/role', ['as' => 'role', 'middleware' => ['web', 'permission:view-role'], 'uses' => 'App\Http\Controllers\Backend\Settings\RoleController@index']);
        Route::post('/saveRole', ['as' => 'saveRole', 'middleware' => ['web', 'permission:add-role'], 'uses' => 'App\Http\Controllers\Backend\Settings\RoleController@saveRole']);
        Route::get('/editRole/{id}', ['as' => 'editRole', 'middleware' => ['web', 'permission:view-role'], 'uses' => 'App\Http\Controllers\Backend\Settings\RoleController@editRole']);
        Route::post('/updateRole/{id}', ['as' => 'updateRole', 'middleware' => ['web', 'permission:update-role'], 'uses' => 'App\Http\Controllers\Backend\Settings\RoleController@updateRole']);
        Route::get('/deleteRole/{id}', ['as' => 'deleteRole', 'middleware' => ['web', 'permission:delete-role'], 'uses' => 'App\Http\Controllers\Backend\Settings\RoleController@deleteRole']);

        //Taxes Setting
        Route::get('/tax', ['as' => 'tax', 'middleware' => ['web', 'permission:view-tax'], 'uses' => 'App\Http\Controllers\Backend\Settings\TaxController@index']);
        Route::get('/taxDatatable', ['as' => 'taxDatatable', 'middleware' => ['web', 'permission:view-tax'], 'uses' => 'App\Http\Controllers\Backend\Settings\TaxController@datatable']);
        Route::get('/addTax', ['as' => 'addTax', 'middleware' => ['web', 'permission:add-tax'], 'uses' => 'App\Http\Controllers\Backend\Settings\TaxController@addTax']);
        Route::post('/saveTax', ['as' => 'saveTax', 'middleware' => ['web', 'permission:add-tax'], 'uses' => 'App\Http\Controllers\Backend\Settings\TaxController@saveTax']);
        Route::get('/editTax/{id}', ['as' => 'editTax', 'middleware' => ['web', 'permission:view-tax'], 'uses' => 'App\Http\Controllers\Backend\Settings\TaxController@editTax']);
        Route::post('/updateTax/{id}', ['as' => 'updateTax', 'middleware' => ['web', 'permission:update-tax'], 'uses' => 'App\Http\Controllers\Backend\Settings\TaxController@updateTax']);
        Route::get('/deleteTax/{id}', ['as' => 'deleteTax', 'middleware' => ['web', 'permission:delete-tax'], 'uses' => 'App\Http\Controllers\Backend\Settings\TaxController@deleteTax']);
    });

    //Profile
    Route::group(['prefix' => 'profile'], function () {
        //General
        Route::post('/changeProfileImage',['as' => 'changeProfileImage', 'uses' => 'App\Http\Controllers\Backend\Profile\GeneralController@changeProfileImage']);
        Route::get('/general',['as' => 'generalProfile', 'uses' => 'App\Http\Controllers\Backend\Profile\GeneralController@index']);
        Route::post('/saveGeneral',['as' => 'saveGeneralProfile', 'uses' => 'App\Http\Controllers\Backend\Profile\GeneralController@save']);
        //Account Setting
        Route::get('/accountSettingProfile',['as' => 'accountSettingProfile', 'uses' => 'App\Http\Controllers\Backend\Profile\SettingController@index']);
        Route::post('/saveAccountSettingProfile',['as' => 'saveAccountSettingProfile', 'uses' => 'App\Http\Controllers\Backend\Profile\SettingController@save']);
        //Social Links
        Route::get('/socialLink',['as' => 'socialLink', 'middleware' => ['web', 'permission:view-social-link'], 'uses' => 'App\Http\Controllers\Backend\Profile\SocialController@index']);
        Route::post('/saveSocialLink',['as' => 'saveSocialLink', 'middleware' => ['web', 'permission:update-social-link'], 'uses' => 'App\Http\Controllers\Backend\Profile\SocialController@save']);
    });

    //Users
    Route::group(['prefix' => 'users'], function () {
        Route::get('/all',['as' => 'allUsers', 'middleware' => ['web', 'permission:view-user'], 'uses' => 'App\Http\Controllers\Backend\Users\UsersController@index']);
        Route::get('/allUsersDatatable',['as' => 'allUsersDatatable', 'middleware' => ['web', 'permission:view-user'], 'uses' => 'App\Http\Controllers\Backend\Users\UsersController@datatable']);
        Route::get('/add',['as' => 'addUser', 'middleware' => ['web', 'permission:add-user'], 'uses' => 'App\Http\Controllers\Backend\Users\UsersController@add']);
        Route::post('/save',['as' => 'saveUser', 'middleware' => ['web', 'permission:add-user'], 'uses' => 'App\Http\Controllers\Backend\Users\UsersController@save']);
        Route::get('/edit/{id}',['as' => 'editUser', 'middleware' => ['web', 'permission:view-user'], 'uses' => 'App\Http\Controllers\Backend\Users\UsersController@edit']);
        Route::post('save/{id}',['as' => 'updateUser', 'middleware' => ['web', 'permission:update-user'], 'uses' => 'App\Http\Controllers\Backend\Users\UsersController@update']);
        Route::get('delete/{id}',['as' => 'deleteUser', 'middleware' => ['web', 'permission:delete-user'], 'uses' => 'App\Http\Controllers\Backend\Users\UsersController@delete']);

    });

    Route::group(['prefix' => 'Instructor','middleware' => ['role:admin']], function () {
        Route::get('/all',['as' => 'allInstructor',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@instructor_list']);
        Route::get('/instructordetails/{id}',['as' => 'instructor_details',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@instructor_details']);
        Route::get('/instructor-activate/{id}',['as' => 'instructor_activate',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@instructor_activate']);
        Route::get('/instructor-approve/{id}',['as' => 'instructor_approve',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@instructor_approve']);
        Route::get('/instructor-remove/{id}',['as' => 'instructor_remove',  'uses' => 'App\Http\Controllers\Backend\Instructor\InstructorController@instructor_remove']);


    });


    //Specialization
    Route::group(['prefix' => 'Specialization','middleware' => ['role:admin']], function () {
        Route::get('/all',['as' => 'allSpecialization',  'uses' => 'App\Http\Controllers\Backend\Specialization\SpecializationController@index']);
        Route::get('/allSpecializationDatatable',['as' => 'allSpecializationDatatable',  'uses' => 'App\Http\Controllers\Backend\Specialization\SpecializationController@datatable']);
        Route::get('/add',['as' => 'addSpecialization',  'uses' => 'App\Http\Controllers\Backend\Specialization\SpecializationController@add']);
        Route::post('/save',['as' => 'saveSpecialization',  'uses' => 'App\Http\Controllers\Backend\Specialization\SpecializationController@save']);
        Route::get('/edit/{id}',['as' => 'editSpecialization',  'uses' => 'App\Http\Controllers\Backend\Specialization\SpecializationController@edit']);
        Route::post('/update/{id}',['as' => 'updateSpecialization',  'uses' => 'App\Http\Controllers\Backend\Specialization\SpecializationController@update']);
        Route::get('delete/{id}',['as' => 'deleteSpecialization',  'uses' => 'App\Http\Controllers\Backend\Specialization\SpecializationController@delete']);

    });


    //Pedagogy
    Route::group(['prefix' => 'Pedagogy','middleware' => ['role:admin']], function () {
        Route::get('/all',['as' => 'allPedagogy',  'uses' => 'App\Http\Controllers\Backend\Pedagogy\PedagogyController@index']);
        Route::get('/allPedagogyDatatable',['as' => 'allPedagogyDatatable',  'uses' => 'App\Http\Controllers\Backend\Pedagogy\PedagogyController@datatable']);
        Route::get('/add',['as' => 'addPedagogy',  'uses' => 'App\Http\Controllers\Backend\Pedagogy\PedagogyController@add']);
        Route::post('/save',['as' => 'savePedagogy',  'uses' => 'App\Http\Controllers\Backend\Pedagogy\PedagogyController@save']);
        Route::get('/edit/{id}',['as' => 'editPedagogy',  'uses' => 'App\Http\Controllers\Backend\Pedagogy\PedagogyController@edit']);
        Route::post('/update/{id}',['as' => 'updatePedagogy',  'uses' => 'App\Http\Controllers\Backend\Pedagogy\PedagogyController@update']);
        Route::get('delete/{id}',['as' => 'deletePedagogy',  'uses' => 'App\Http\Controllers\Backend\Pedagogy\PedagogyController@delete']);

    });


    //Resource
    Route::group(['prefix' => 'Resource','middleware' => ['role:admin']], function () {
        Route::get('/all',['as' => 'allResource',  'uses' => 'App\Http\Controllers\Backend\Resource\ResourceController@index']);
        Route::get('/allResourceDatatable',['as' => 'allResourceDatatable',  'uses' => 'App\Http\Controllers\Backend\Resource\ResourceController@datatable']);
        Route::get('/add',['as' => 'addResource',  'uses' => 'App\Http\Controllers\Backend\Resource\ResourceController@add']);
        Route::post('/save',['as' => 'saveResource',  'uses' => 'App\Http\Controllers\Backend\Resource\ResourceController@save']);
        Route::get('/edit/{id}',['as' => 'editResource',  'uses' => 'App\Http\Controllers\Backend\Resource\ResourceController@edit']);
        Route::post('/update/{id}',['as' => 'updateResource',  'uses' => 'App\Http\Controllers\Backend\Resource\ResourceController@update']);
        Route::get('delete/{id}',['as' => 'deleteResource',  'uses' => 'App\Http\Controllers\Backend\Resource\ResourceController@delete']);

    });


    Route::group(['prefix' => 'course','middleware' => ['role:admin']], function () {
        Route::get('/all',['as' => 'allcourse',  'uses' => 'App\Http\Controllers\Backend\Admin\CourseController@index']);
        Route::get('/allcourseDatatable',['as' => 'allcourseDatatable',  'uses' => 'App\Http\Controllers\Backend\Admin\CourseController@datatable']);
        Route::post('/courses/{courseId}/instructors', ['as' => 'courses_addInstructor', 'uses' => 'App\Http\Controllers\Backend\Admin\CourseController@addInstructor']);

    });

    Route::group(['prefix' => 'publiccourse','middleware' => ['role:admin']], function () {
        Route::get('/allpubliccourseDatatable',['as' => 'allpubliccourseDatatable',  'uses' => 'App\Http\Controllers\Backend\Admin\CourseController@publiccoursedatatable']);
        Route::get('/all-public-courses',['as' => 'allpubliccourse',  'uses' => 'App\Http\Controllers\Backend\Admin\CourseController@publiccourse']);
        Route::post('/courses-publish/{id}',['as' => 'courses_publish',  'uses' => 'App\Http\Controllers\Backend\Admin\CourseController@publishCourse']);
        Route::post('/courses-unpublish/{id}',['as' => 'courses_unpublish',  'uses' => 'App\Http\Controllers\Backend\Admin\CourseController@unpublishCourse']);
    });

});
