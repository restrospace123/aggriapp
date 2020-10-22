<?php

namespace App\Http\Controllers\Exchange;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exchange;
use Illuminate\Support\Facades\DB;

class ExchangeController extends Controller
{
    private $exchange;

    public function __construct(Exchange $exchange = null)
    {
        $this->exchange = $exchange?:new Exchange();
    }

    public function create(Request $request){

        $validatedData = $request->validate([
            'type'     => 'required',
            'amount'      => 'required',
            'description' => 'required',
            'ondate'      => 'required',
        ]);

        $exchange = $this->exchange;
        $exchange->type_id = $request->type;
        $exchange->amount = $request->amount;
        $exchange->description = $request->description;
        $exchange->ondate = $request->ondate;
        $exchange->save();

        return redirect()->route('admin.exchange.add')->with('exchange-status', "Added Success");
    }

    public function edit(Request $request){
        
        if(isset($request->edit)){
           
            $elements = $this->exchange::find($request->edit);
            return view('admin.exchange.edit')->with('fields', $elements);
        }

        return redirect()->route('admin.home');
    }

    public function update(Request $request){
        
        $validatedData = $request->validate([
            'type'        => 'required',
            'amount'      => 'required',
            'description' => 'required',
            'ondate'      => 'required',
        ]);

        $exchange = $this->exchange::where('id', $request->id)->update([
            'type_id' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'ondate' => $request->ondate
        ]);

        return redirect('/admin/edit-exchange?edit='.$request->id)->with('exchange-status', "Updated Success");
    }

    public function delete(Request $request){
        
        if(isset($request->delete)){
           
            $element = $this->exchange::find($request->delete);
            $element->delete();
            return redirect()->route('admin.home')->with('dashboard-status', 'Delete Success');
        }

        return redirect()->route('admin.home');
    }

    public function report(Request $request){

        $validatedData = $request->validate([
            'start' => 'required',
            'end'   => 'required',
        ]);

        $start = $request->start;
        $end = $request->end;

       $sql = "select sum(amount) as amount from exchanges where ondate between '$start' AND '$end' group by type_id";
       $data = DB::select($sql);
       
       $income    = $data[0]->amount?:0;
       $expenses = $data[1]->amount?:0;

       $report = implode(',', [$income, $expenses, $start, $end]);

       return redirect()->route('admin.home')->with('report', $report);
    }
}
