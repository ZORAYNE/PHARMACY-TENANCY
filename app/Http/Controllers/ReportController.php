<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function salesReport(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $sales = Sale::whereBetween('created_at', [$from, $to])->get();

        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(0,10,'Sales Report',0,1,'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(40,10,'Date');
        $pdf->Cell(60,10,'Product');
        $pdf->Cell(30,10,'Qty');
        $pdf->Cell(30,10,'Total',0,1);

        $pdf->SetFont('Arial','',11);
        foreach($sales as $sale) {
            $pdf->Cell(40,8,$sale->created_at->format('Y-m-d'));
            $pdf->Cell(60,8,$sale->product->name);
            $pdf->Cell(30,8,$sale->quantity);
            $pdf->Cell(30,8,number_format($sale->total, 2),0,1);
        }

        $pdf->Output();
        exit;
    }

    public function stockReport()
{
    $products = \App\Models\Product::all();

    $pdf = new Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10,'Stock Report',0,1,'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(80,10,'Product');
    $pdf->Cell(30,10,'Stock',0,1);

    $pdf->SetFont('Arial','',11);
    foreach($products as $product) {
        $pdf->Cell(80,8,$product->name);
        $pdf->Cell(30,8,$product->stock_quantity,0,1);
    }

    $pdf->Output();
    exit;
}
public function customerTrendReport()
{
    $customers = \App\Models\Customer::with('sales')
        ->get()
        ->map(function ($customer) {
            $customer->total_spent = $customer->sales->sum('total');
            return $customer;
        })
        ->sortByDesc('total_spent');

    $pdf = new Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10,'Customer Trend Report',0,1,'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(80,10,'Customer');
    $pdf->Cell(40,10,'Total Spent',0,1);

    $pdf->SetFont('Arial','',11);
    foreach($customers as $customer) {
        $pdf->Cell(80,8,$customer->name);
        $pdf->Cell(40,8,number_format($customer->total_spent, 2),0,1);
    }

    $pdf->Output();
    exit;
}

}
