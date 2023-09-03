<?php

namespace App\Http\Controllers\School\Framework\Fees;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Fees\StudentInvoice;
use App\Models\School\Framework\Fees\StudentInvoicePayment;
use App\Models\School\Framework\Fees\StudentInvoicePaymentRecord;

class PaymentController extends Controller
{
    public function processStudentInvoice(Request $request)
    {
        //remove student pid,token, inorder to loop invoice keys
        $student_pid = $request['student_pid'];
        unset($request['_token']);
        unset($request['student_pid']);

        $resultArray = $this->processSelectedFees($request->all());
        $data = [
            'total' => $resultArray['total'],
            'school_pid' => getSchoolPid(),
            'pid' => public_id(),
            'invoice_number' => $this->generateInvoiceNumber(),
            'amount_paid' => $resultArray['total'],
            'status' => 1, // paid 
            'generated_by' => getSchoolUserPid(),
            'student_pid' => $student_pid,
            'code' => getUserActiveRole() // paid by actor
        ];
        $record = [
            'school_pid' => getSchoolPid(),
            'amount' => $resultArray['total'],
            // 'generated_by' => getSchoolUserPid(),// this should be paid by
            'received_by' => getSchoolUserPid(),
            'channel' => 'Table payment',
            'code' => getUserActiveRole()
        ];
        $result = StudentInvoicePayment::create($data);
        if ($result) {
            $record['invoice_pid'] = $result->pid;
            $invoice_number = $result->invoice_number;
            StudentInvoicePaymentRecord::create($record);
            $data = ['keys' => $resultArray['keys'], 'invoice_pid' => $result->pid, 'paid_date' => fullDate(), 'status' => 1];
            $result = $this->updateStudentInvoiceByPid($data);
            if ($result) {
                return response()->json(['status' => 1, 'message' => 'Student Invoice(s) paid ' . $invoice_number, 'invoice_number' => $invoice_number]);
            }
        }
        return response()->json(['status' => 'error', 'message' => ' Something Went Wrong']);
    }


    private function updateStudentInvoiceByPid(array|null $data)
    {
        $keys = $data['keys'];
        unset($data['keys']);
        $update = StudentInvoice::whereIn('pid', $keys)->update($data);
        return $update;
    }
    private function processSelectedFees($pid)
    {
        $data = [];
        foreach ($pid as $key => $id) {
            if ($id) {
                $data[] = $key;
            }
        }
        $amount = $this->sumItemAmount($data);
        return ['total' => $amount, 'keys' => $data];
    }

    private function sumItemAmount(array|null $data)
    {
        $amount = StudentInvoice::whereIn('pid', $data)->sum('amount');
        return $amount;
    }
    private function generateInvoiceNumber()
    {
        $invoiceNumber = invoiceNumber();
        $count = StudentInvoicePayment::where('school_pid', getSchoolPid())
            ->where('invoice_number', 'like', '%' . $invoiceNumber . '%')
            ->count('id');
        return getSchoolCode() . $invoiceNumber . sprintNumber($count + 1);
    }

    public function loadPaymentInvoice($id)
    {
        $invoiceDetails = DB::table('student_invoice_payments as p')
        ->join('students as st', 'st.pid', 'p.student_pid')
        ->join('schools as s', 's.pid', 'p.school_pid')
        ->join('student_invoices as si', 'p.pid', 'si.invoice_pid')
        ->join('class_invoice_params as pi', 'pi.pid', 'si.param_pid')
        ->join('class_arms as a', 'a.pid', 'pi.arm_pid')
        ->join('terms as t', 't.pid', 'pi.term_pid')
        ->join('sessions as ss', 'ss.pid', 'pi.session_pid')
        ->select(
            'p.invoice_number',
            'p.total',
            'p.amount_paid',
            'p.status',
            'p.created_at',
            's.school_email',
            's.school_website',
            's.school_logo',
            's.school_moto',
            's.school_address',
            's.school_contact',
            'fullname',
            'reg_number',
            'term',
            'arm',
            'session'
        )->where(['p.invoice_number' => $id, 'p.school_pid' => getSchoolPid()])->first();

        $list = DB::table('student_invoices as s')->join('student_invoice_payments as p', 'p.pid', 's.invoice_pid')
        ->join('fee_item_amounts as fa', 'fa.pid', 's.item_amount_pid')
        ->join('fee_configurations as c', 'c.pid', 'fa.config_pid')
        ->join('fee_items as f', 'f.pid', 'c.fee_item_pid')
        // no need to include term and session if payment is based on term 
        // ->join('class_invoice_params as pi', 'pi.pid', 's.param_pid')
        // ->join('class_arms as a', 'a.pid', 'pi.arm_pid')
        // ->join('terms as t', 't.pid', 'pi.term_pid')
        // ->join('sessions as ss', 'ss.pid', 'pi.session_pid')
        ->select('s.pid', 's.amount', 's.status', 's.paid_date', 'fee_name')
        ->where(['p.invoice_number' => $id, 'p.school_pid' => getSchoolPid()])->get();
        return view('school.payments.payment-receipt', compact('list', 'invoiceDetails'));
    }
}
