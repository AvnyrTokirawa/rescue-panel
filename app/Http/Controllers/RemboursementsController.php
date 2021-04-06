<?php

namespace App\Http\Controllers;

use App\Events\Notify;
use App\Models\ObjRemboursement;
use App\Models\RemboursementList;
use App\Models\WeekRemboursement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RemboursementsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access');
    }


    public function getRemboursementOfUser(): \Illuminate\Http\JsonResponse
    {
        $remboursements = RemboursementList::where('user_id', Auth::user()->id)->where('week_number', ServiceController::getWeekNumber())->orderByDesc('id')->get();
        $obs = ObjRemboursement::all();
        foreach ($remboursements as $remboursement){
            $remboursement->getItem;
        }
        return response()->json(['status'=>'OK', 'remboursements'=>$remboursements, 'obj'=>$obs]);
    }

    public function addRemboursement(Request $request): \Illuminate\Http\JsonResponse
    {
        $item = (int) $request->item;
        $item = ObjRemboursement::where('id', $item)->first();
        $userRemboursements = WeekRemboursement::where('week_number', ServiceController::getWeekNumber())->where('user_id', Auth::user()->id);
        if($userRemboursements->count() == 0){
            $userRemboursements = new WeekRemboursement();
            $userRemboursements->week_number = ServiceController::getWeekNumber();
            $userRemboursements->user_id = Auth::user()->id;
            $userRemboursements->total = $item->price;
        }else{
            $userRemboursements->first();
            $userRemboursements->total = (int) $userRemboursements->total + (int) $item->price;
        }
        $rmbsem = new RemboursementList();
        $rmbsem->user_id = Auth::user()->id;
        $rmbsem->item_id = $item->id;
        $rmbsem->week_number = ServiceController::getWeekNumber();
        $rmbsem->save();
        $userRemboursements->save();
        event(new Notify('Remboursement pris en compte',1));
        return response()->json(['stauts'=>'OK'],201);
    }

    public function deleteRemboursement(string $itemid): \Illuminate\Http\JsonResponse
    {
        $itemid = (int) $itemid;
        $item = RemboursementList::where('id', $itemid)->first;
        $userRemboursement = WeekRemboursement::where('user_id', Auth::user()->id)->where('week_number', ServiceController::getWeekNumber());
        $userRemboursement->total = (int) $userRemboursement->total -  (int) $item->getItem->price;
        $userRemboursement->save();
        $item->delete();
        event(new Notify('Remboursement supprimé',1));
        return response()->json(['status'=>'OK']);
    }

    public function getRemboursementByWeek(string $weeknumber = null): \Illuminate\Http\JsonResponse
    {
        if($weeknumber == '' || $weeknumber == null){
            $weeknumber = ServiceController::getWeekNumber();
        }else{
            $weeknumber = (int) $weeknumber;
        }
        $list = WeekRemboursement::orderByDesc('id')->where('week_number', $weeknumber)->get();
        foreach ($list as $item){
            $item->GetUser;
        }
        return response()->json([
            'status'=>'OK',
            'list'=>$list,
            'maxweek'=>ServiceController::getWeekNumber(),
        ]);
    }


}