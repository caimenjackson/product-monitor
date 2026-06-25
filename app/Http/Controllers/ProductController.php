<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Batch;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class ProductController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $products = Product::with(['batches' => function($query) use ($today) {
            $query->whereDate('created_at', $today);
        }])->whereDate('date', $today)->get();

        return view('products.index', ['products' => $products]);
    }

    public function cook(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity');

        $now = now();
        $expiresAt = $now->copy()->addMinutes($product->expiration_duration);

        $batch = Batch::create([
            'product_id' => $productId,
            'quantity' => $quantity,
            'cooked_at' => $now,
            'expires_at' => $expiresAt,
            'fresh_sold' => 0,
            'waste' => 0,
            'expired_sold' => 0,
        ]);

        $product->increment('cooked', $quantity);
        $this->updateOnHand($productId);

        return response()->json(['success' => true]);
    }

    public function sell(Request $request, $productId)
    {
        $quantityToSell = $request->input('quantity');
        $batches = Batch::where('product_id', $productId)->orderBy('expires_at')->get();
        $product = Product::findOrFail($productId);
        $totalSold = 0;

        foreach ($batches as $batch) {
            $remainingQuantity = $batch->quantity - ($batch->fresh_sold + $batch->waste + $batch->expired_sold);
            $now = now();
            $isExpired = $now->greaterThan($batch->expires_at);

            if ($remainingQuantity > 0) {
                if ($quantityToSell <= $remainingQuantity) {
                    if ($isExpired) {
                        $batch->expired_sold += $quantityToSell;
                    } else {
                        $batch->fresh_sold += $quantityToSell;
                    }
                    $batch->save();
                    $totalSold += $quantityToSell;
                    break;
                } else {
                    if ($isExpired) {
                        $batch->expired_sold += $remainingQuantity;
                    } else {
                        $batch->fresh_sold += $remainingQuantity;
                    }
                    $batch->save();
                    $totalSold += $remainingQuantity;
                    $quantityToSell -= $remainingQuantity;
                }
            }
        }

        $product->increment('sold', $totalSold);
        $this->updateOnHand($productId);

        return response()->json(['success' => true]);
    }

    public function waste(Request $request, $productId)
    {
        $quantityToWaste = $request->input('quantity');
        $batches = Batch::where('product_id', $productId)->orderBy('expires_at')->get();
        $product = Product::findOrFail($productId);
        $totalWasted = 0;

        foreach ($batches as $batch) {
            $remainingQuantity = $batch->quantity - ($batch->fresh_sold + $batch->waste + $batch->expired_sold);

            if ($remainingQuantity > 0) {
                if ($quantityToWaste <= $remainingQuantity) {
                    $batch->waste += $quantityToWaste;
                    $batch->save();
                    $totalWasted += $quantityToWaste;
                    break;
                } else {
                    $batch->waste += $remainingQuantity;
                    $batch->save();
                    $totalWasted += $remainingQuantity;
                    $quantityToWaste -= $remainingQuantity;
                }
            }
        }

        $product->increment('wasted', $totalWasted);
        $this->updateOnHand($productId);

        return response()->json(['success' => true]);
    }

    private function updateOnHand($productId)
    {
        $totalOnHand = Batch::where('product_id', $productId)
                            ->sum(\DB::raw('quantity - fresh_sold - waste - expired_sold'));

        $product = Product::find($productId);
        $product->on_hand = $totalOnHand;
        $product->save();
    }

    public function exportPdf()
    {
        $today = Carbon::today()->toDateString();
        $products = Product::with(['batches' => function($query) use ($today) {
            $query->whereDate('created_at', $today);
        }])->whereDate('date', $today)->get();
    
        $pdf = Pdf::loadView('pdf.products', ['products' => $products]);
        return $pdf->download('product_control_sheet.pdf');
    }

    public function refresh()
    {
        $today = Carbon::today()->toDateString();
        $products = Product::with(['batches' => function($query) use ($today) {
            $query->whereDate('created_at', $today);
        }])->whereDate('date', $today)->get();

        return view('partials.product_grid', compact('products'));
    }
}
