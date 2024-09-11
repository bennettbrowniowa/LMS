<?php

namespace App\Http\Controllers\Backend\Specialization;

use App\Http\Controllers\Controller;

use App\Models\Specialization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class SpecializationController extends Controller
{
    public function index(){

        return view('Backend.Specialization.All');

    }
    public function datatable(){
        $query = Specialization::select('id', 'name','status');
        return DataTables::eloquent($query)

             ->addColumn('status', function ($data) {
                if (isset($data->status) && $data->status=='Active') {
                    return '<span class="label label-success">Active</span>';
                } else {
                    return '<span class="label label-danger">Inactive</span>';
                }
            })
            ->addColumn('action', function ($data)  {
                $url_update = route('editSpecialization', ['id' => $data->id]);
                $url_delete = route('deleteSpecialization', ['id' => $data->id]);
                $edit = '<a class="label label-primary" data-title="Edit Specialization" data-act="ajax-modal" data-append-id="AjaxModelContent" data-action-url="'.$url_update.'" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>';

                $edit .= '&nbsp<a href="' . $url_delete . '" class="label label-danger" data-confirm="Are you sure to delete Specialization: <span class=&#034;label label-primary&#034;></span>"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>';

                return $edit;
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    public function add(){
        return view('Backend.Specialization.Add');
    }

    public function save(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',

        ]);

        $save = new Specialization();
        $save->name=$request->get('name');
        $save->status=$request->get('status');
        $save->save();
        Session::flash('success', "Specialization has been created successfully");
        return redirect()->back();
    }

    public function edit($id)
    {
        $records = Specialization::findOrFail($id);

        return view('Backend.Specialization.Edit',['records'=>$records]);

    }

    public function update(Request $request,$id){

        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',

        ]);

        $update=Specialization::findOrFail($id);
        $update->name=$request->get('name');
        $update->status=$request->get('status');
        $update->save();
        Session::flash('success', "Specialization has been updated");
        return redirect()->back();
    }

    public function delete($id=null){
        $Remove = Specialization::findOrFail($id);
        $Remove->delete();
        Session::flash('success', "Specialization has been deleted");
        return redirect()->back();
    }


}
