<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB, Helper;
use Illuminate\Support\Facades\Session;

use Illuminate\Routing\Controller as BaseController;

class PeopleController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
        if (!empty(Session::get('unit_id'))) {
            $login_user = Session::get('unit_id');
        } else {
            $login_user = Auth::user()->id;
        }
        $name = $_GET['name'] ?? '';
        $frequency = $_GET['frequency'] ?? '';
        $status = $_GET['status'] ?? '';
        $entries = $_GET['entries'] ?? '';
        $responsibility = DB::table('authority')->where('unit_id', $login_user)->get();
        $locations = DB::table('locations')->where('created_by', $login_user)->whereNull('parent')->get();

        if (!empty(Session::get('unit_id'))) {
            $unit_id = Session::get('unit_id');
        } else {
            $unit_id = Auth::user()->id;
        }

        $training_types_list = DB::table('training_types');

        if (!empty($name)) {
            $training_types_list = $training_types_list->where('name', $name);
        }

        if (!empty($frequency)) {
            $training_types_list = $training_types_list->where('frequency', $frequency);
        }

        if (!empty($status)) {
            $training_types_list = $training_types_list->where('status', $status);
        }

        if (!empty($entries)) {
            if ($entries == 'All') {
                $training_types_list = $training_types_list->where('unit_id', $unit_id)->orderBy('id', 'DESC')->paginate(350);
            } else {
                $training_types_list = $training_types_list->where('unit_id', $unit_id)->orderBy('id', 'DESC')->paginate($entries);
            }
        } else {
            $training_types_list = $training_types_list->where('unit_id', $unit_id)->orderBy('id', 'DESC')->paginate(10);
        }

        $url = url()->full();

        return view('admin.people.list', compact('responsibility', 'locations', 'training_types_list', 'url'));
    }

    public function dashboard(Request $request)
    {
        if (!empty(Session::get('unit_id'))) {
            $login_user = Session::get('unit_id');
        } else {
            $login_user = Auth::user()->id;
        }

        $s_date = $_GET['s_date'] ?? '';
        $e_date = $_GET['e_date'] ?? '';
        $responsibilitys = $_GET['responsibilitys'] ?? '';

        if ($responsibilitys == 2) {
            $responsibility = DB::table('locations')->where('created_by', $login_user)->whereNull('parent')->get();

            $responsibilityvalue = '2';
            $data = [];
            $locationdata = [];
        } else {
            $responsibility = DB::table('authority')->where('unit_id', $login_user)->get();
            $responsibilityvalue = '1';

            $data = [];
            $data1 = [];
            foreach ($responsibility as $responsibilitys) {
                $data1['name'] = $responsibilitys->name ?? '';

                $dataarray1 = [];
                $dataarray = [];
                if (!empty($responsibilitys->location)) {
                    $authorityslocation = json_decode($responsibilitys->location);

                    $first = 0;
                    $first1 = 0;
                    foreach ($authorityslocation as $authorityslocations) {
                        $first += Helper::opencase($authorityslocations ?? '', $responsibilitys->id ?? '', $responsibilityvalue, $s_date, $e_date);
                        $first1 += Helper::closecase($authorityslocations ?? '', $responsibilitys->id ?? '', $responsibilityvalue, $s_date, $e_date);
                        $dataarray['subname'] = DB::table('locations')->where('id', $authorityslocations)->value('name');
                        $dataarray['opencase'] = Helper::opencase($authorityslocations ?? '', $responsibilitys->id ?? '', $responsibilityvalue, $s_date, $e_date);
                        $dataarray['closecase'] = Helper::closecase($authorityslocations ?? '', $responsibilitys->id ?? '', $responsibilityvalue, $s_date, $e_date);
                        array_push($data1, $dataarray);
                    }

                    $data1['first'] = $first;

                    $data1['first1'] = $first1;
                    $data1['total'] = $first + $first1;
                } else {
                    $dataarray = [];
                    array_push($data1, $dataarray);
                    $data1['first'] = 0;

                    $data1['first1'] = 0;
                    $data1['total'] = 0;
                }

                array_push($data, $data1);
            }

            $locationresponsibility = DB::table('locations')->where('created_by', $login_user)->whereNull('parent')->get();

            $locationdata = [];
            $locationdata1 = [];
            foreach ($locationresponsibility as $responsibilitys) {
                $locationdata1['name'] = $responsibilitys->name ?? '';

                $dataarray1 = [];
                $dataarray = [];

                $authorityslocation = DB::table('locations')
                    ->where('parent', $responsibilitys->id ?? '')
                    ->get();

                $first = 0;
                $first1 = 0;
                foreach ($authorityslocation as $authorityslocations) {
                    $responsibilityvalue1 = '2';
                    $first += Helper::opencase($authorityslocations->id ?? '', $responsibilitys->id ?? '', $responsibilityvalue1, $s_date, $e_date);
                    $first1 += Helper::closecase($authorityslocations->id ?? '', $responsibilitys->id ?? '', $responsibilityvalue1, $s_date, $e_date);
                    $dataarray['subname'] = $authorityslocations->name ?? '';
                    $dataarray['opencase'] = Helper::opencase($authorityslocations->id ?? '', $responsibilitys->id ?? '', $responsibilityvalue1, $s_date, $e_date);
                    $dataarray['closecase'] = Helper::closecase($authorityslocations->id ?? '', $responsibilitys->id ?? '', $responsibilityvalue1, $s_date, $e_date);
                    array_push($locationdata1, $dataarray);
                }

                $locationdata1['first'] = $first;
                $locationdata1['first1'] = $first1;
                $locationdata1['total'] = $first + $first1;
                array_push($locationdata, $locationdata1);
            }
        }

        //$concern_list = DB::table('tbl_concern')->where('created_by',$login_user)->whereNotNull('parent')->get();

        $concern_list = DB::table('tbl_concern')->join('inspection', 'tbl_concern.id', '=', 'inspection.subconcern')->select('tbl_concern.id as id', 'tbl_concern.name as title', DB::raw('count(inspection.subconcern) as count'))->orderBy('count', 'DESC')->groupBy('tbl_concern.id')->where('tbl_concern.created_by', $login_user)->whereNotNull('tbl_concern.parent')->get();

        // echo "<pre>";
        // print_r($concern_list);
        // die();

        return view('admin.people.dashboard', compact('responsibility', 'responsibilityvalue', 'login_user', 's_date', 'e_date', 'data', 'locationdata', 'concern_list'));
    }
    public function store(Request $request)
    {
        if (!empty(Session::get('unit_id'))) {
            $unit_id = Session::get('unit_id');
        } else {
            $unit_id = Auth::user()->id;
        }
        $dataArr['unit_id'] = $unit_id;
        $dataArr['name'] = $request->name;
        $dataArr['frequency'] = $request->frequency;
        $dataArr['status'] = $request->status;

        if ($request->edit_id) {
            $dataArr['updated_by'] = $unit_id;
            DB::table('training_types')
                ->where('id', $request->edit_id)
                ->update($dataArr);

            if (!empty($request->page_number)) {
                return redirect('https://efsm.safefoodmitra.com/admin/public/index.php/inspection/list?page=' . $request->page_number);
            } else {
                return redirect()->route('training_data_index')->with('status', 'Add Successfully');
            }

            //
        } else {
            DB::table('training_types')->insert($dataArr);
            return redirect()->route('training_data_index')->with('status', 'Add Successfully');
        }
    }

    public function inspection_edit(Request $request)
    {
        if ($request->file('image1')) {
            $file = $request->file('image1');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('inspection'), $filename);
            $dataArr['image1'] = $filename;
        }

        if (!empty(Session::get('unit_id'))) {
            $unit_id = Session::get('unit_id');
        } else {
            $unit_id = Auth::user()->id;
        }

        $dataArr['updated_by'] = $unit_id;
        $dataArr['select_action'] = $request->select_action;
        $dataArr['time_line'] = $request->time_line;
        $dataArr['price'] = $request->price;
        $dataArr['closure_comments'] = $request->closure_comments;
        DB::table('inspection')
            ->where('id', $request->edit_id1)
            ->update($dataArr);

        return redirect($request->url);

        return redirect()->route('inspection_list')->with('status', 'Add Successfully');
    }

    public function delete($id)
    {
        DB::table('inspection')->where('id', $id)->delete();
        return redirect()->route('inspection_list')->with('status', 'Deleted successfully');
    }

    public function exportdata()
    {
        return view('admin.people.export');
    }
}
