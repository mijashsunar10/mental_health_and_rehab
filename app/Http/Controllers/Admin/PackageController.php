<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Order;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PackagePurchaseConfirmation;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
// use App\Models\Package;
use App\Models\Purchase;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:online,offline',
            'options' => 'required|array',
            'options.*.name' => 'required|string',
            'options.*.price' => 'required|numeric',
            'options.*.duration' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('package-images', 'public');
        }

        Package::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    public function show(Package $package)
    {
        return view('admin.packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:online,offline',
            'options' => 'required|array',
            'options.*.name' => 'required|string',
            'options.*.price' => 'required|numeric',
            'options.*.duration' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($package->image) {
                Storage::disk('public')->delete($package->image);
            }
            $validated['image'] = $request->file('image')->store('package-images', 'public');
        }

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }
        
        $package->delete();
        
        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }

     public function showPurchaseForm(Package $package, Request $request)
    {
        try {
            $currentStep = (int)$request->query('step', 1);
            
            // Validate step range
            if ($currentStep < 1 || $currentStep > 3) {
                return redirect()->route('packages.purchase', [
                    'package' => $package,
                    'step' => 1
                ]);
            }

            // For step 3 (confirmation), get selected option from session
            $selectedOption = null;
            if ($currentStep == 3) {
                $purchaseData = session('purchase_data', []);
                
                if (!isset($purchaseData['selected_option'])) {
                    return redirect()->route('packages.purchase', [
                        'package' => $package, 
                        'step' => 2
                    ])->with('error', 'Please select a treatment option');
                }
                
                $selectedOptionIndex = $purchaseData['selected_option'];
                $selectedOption = $package->options[$selectedOptionIndex] ?? null;
                
                if (!$selectedOption) {
                    return redirect()->route('packages.purchase', [
                        'package' => $package, 
                        'step' => 2
                    ])->with('error', 'Invalid treatment option selected');
                }
            }
            
            return view('admin.packages.purchase.purchase', [
                'package' => $package,
                'currentStep' => $currentStep,
                'selectedOption' => $selectedOption,
            ]);

        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function processPurchase(Package $package, Request $request)
    {
        try {
            $currentStep = (int)$request->current_step;
            $nextStep = $currentStep + 1;
            
            // Validate and process data based on current step
            switch ($currentStep) {
                case 1: // Personal Information
                    $validated = $request->validate([
                        'full_name' => 'required|string|max:255',
                        'email' => 'required|email',
                        'phone' => 'required|string|max:20',
                        'dob' => 'required|date',
                    ]);
                    
                    // Store in session
                    session(['purchase_data' => array_merge(session('purchase_data', []), $validated)]);
                    break;
                    
                case 2: // Treatment Options
                    $validated = $request->validate([
                        'selected_option' => 'required|integer',
                    ]);
                    
                    // Verify option exists
                    if (!isset($package->options[$validated['selected_option']])) {
                        return redirect()->back()->with('error', 'Invalid treatment option selected');
                    }
                    
                    // Store in session
                    session(['purchase_data' => array_merge(session('purchase_data', []), $validated)]);
                    break;
                    
                case 3: // Confirmation & Payment
                    // This step will be handled by Stripe payment
                    // We'll create the purchase record after successful payment
                    return $this->processPayment($package, $request);
            }
            
            // Redirect to next step
            return redirect()->route('packages.purchase', [
                'package' => $package,
                'step' => $nextStep
            ]);
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
    private function processPayment(Package $package, Request $request)
    {
        // This method will be called after Stripe payment is successful
        // The actual payment processing is handled in StripeController
        // This is just a placeholder for the flow
        
        return redirect()->route('stripe.payment', ['package' => $package->id]);
    }
    
    public function createPurchaseRecord(Package $package, $selectedOptionIndex)
    {
        $selectedOption = $package->options[$selectedOptionIndex];
        $user = Auth::user();
        
        // Calculate start and end dates based on package duration
        $startDate = Carbon::now();
        
        // Parse duration (e.g., "3 months", "6 weeks")
        $duration = $selectedOption['duration'];
        preg_match('/(\d+)\s+(day|week|month|year)/', $duration, $matches);
        
        if (count($matches) === 3) {
            $amount = (int)$matches[1];
            $unit = $matches[2] . 's'; // pluralize
            $endDate = $startDate->copy()->add($unit, $amount);
        } else {
            // Default to 1 month if parsing fails
            $endDate = $startDate->copy()->addMonth();
        }
        
        // Create purchase record
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'selected_option' => $selectedOptionIndex,
            'amount' => $selectedOption['price'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active'
        ]);
        
        return $purchase;
    }
public function purchaseSuccess(Purchase $purchase)
{
    return view('admin.packages.purchase.success', [
        'purchase' => $purchase,
        'package' => $purchase->package,
    ]);
}

            public function purchaseCancel()
            {
                return view('purchase.cancel')->with([
                    'message' => 'Your purchase was cancelled. Please try again if you want to access the dashboard.'
                ]);
            }
}