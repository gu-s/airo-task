<?php

namespace App\Http\Controllers\API;

use App\Helpers\QuotationHelper;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\QuotationResource;
use App\Models\Quotation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuotationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function quotation(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'age' => 'required',
            'currency_id' => ['required', Rule::in(QuotationHelper::CURRENCIES)],
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d|after:start_date',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try{
            $total = QuotationHelper::calculateQuotation($input['age'], $input['start_date'], $input['end_date']);

        }
        catch(Exception $e){
            return $this->sendError('Quotation Error.', ["error" => $e->getMessage()]);       

        }


        $quotation = Quotation::create(['total' => $total]);

        return $this->sendResponse([
            'total' => round($total, 2),
            'quotation_id' => $quotation->id,
            'currency_id' => $input['currency_id'],
        ], 'Quotation Sent Successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotations = Quotation::all();

        return $this->sendResponse(QuotationResource::collection($quotations), 'Quotations Retrieved Successfully.');
    }

}