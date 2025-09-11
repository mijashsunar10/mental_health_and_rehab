<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PackagePurchaseConfirmation;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


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
        if ($currentStep < 1 || $currentStep > 4) {
            return redirect()->route('packages.purchase', [
                'package' => $package,
                'step' => 1
            ]);
        }

        // For step 4, get selected option from session
        $selectedOption = null;
        if ($currentStep == 4) {
            $purchaseData = session('purchase_data', []);
            
            if (!isset($purchaseData['selected_option_data'])) {
                return redirect()->route('packages.purchase', [
                    'package' => $package, 
                    'step' => 2
                ])->with('error', 'Please select a treatment option');
            }
            
            $selectedOption = $purchaseData['selected_option_data'];
        }
        
        return view('admin.packages.purchase.purchase', [
            'package' => $package,
            'currentStep' => $currentStep,
            'selectedOption' => $selectedOption,
        ]);

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'An error occurred: ' . $e->getMessage());
    }
}

public function processPurchase(Package $package, Request $request)
{
    try {
        $currentStep = (int)$request->input('current_step', 1);
        
        // Validate step range
        if ($currentStep < 1 || $currentStep > 4) {
            throw new \Exception('Invalid step number');
        }

        // Validate based on current step
        switch ($currentStep) {
            case 1:
                $validated = $request->validate([
                    'full_name' => 'required|string|max:255',
                    'email' => 'required|email',
                    'phone' => 'required',
                    'dob' => 'required|date|before:today',
                ]);
                break;
                
            case 2:
                $validated = $request->validate([
                    'selected_option' => [
                        'required',
                        'integer',
                        'min:0',
                        function ($attribute, $value, $fail) use ($package) {
                            if (!isset($package->options[$value])) {
                                $fail('The selected treatment option is invalid.');
                            }
                        }
                    ],
                ]);
                
                // Store the entire option data
                $validated['selected_option_data'] = $package->options[$validated['selected_option']];
                break;
                
            case 3:
                $validated = $request->validate([
                    'card_number' => 'required|numeric|digits_between:12,19',
                    'expiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\/?([0-9]{2})$/'],
                    'cvv' => 'required|numeric|digits_between:3,4',
                ]);
                
                // Store masked card number for display
                $validated['card_last_four'] = substr($validated['card_number'], -4);
                break;
                
            case 4:
                $validated = $request->validate([
                    'terms' => 'required|accepted',
                ]);
                
                $purchaseData = $request->session()->get('purchase_data', []);
                
                // Validate all required data is present
    //             $requiredFields = [
    //                 'full_name', 
    //                 'email', 
    //                 'selected_option', 
    //                 'selected_option_data',
    //                 'card_number',
    //                 'expiry',
    //                 'cvv',
    //                 'card_last_four'
    //             ];
                
    //             foreach ($requiredFields as $field) {
    //                 if (!isset($purchaseData[$field])) {
    //                     throw new \Exception("Missing required field: $field");
    //                 }
    //             }

    //             // Process payment
    //             $payment = $this->processPayment(
    //                 $purchaseData['card_number'],
    //                 $purchaseData['expiry'],
    //                 $purchaseData['cvv'],
    //                 $purchaseData['selected_option_data']['price']
    //             );
                
    //             if ($payment->status !== 'success') {
    //                 throw new \Exception('Payment processing failed: ' . ($payment->message ?? ''));
    //             }
                
    //             // Create order record
    //             $order = Order::create([
    //                 'user_id' => auth()->id(),
    //                 'package_id' => $package->id,
    //                 'option_index' => $purchaseData['selected_option'],
    //                 'amount' => $purchaseData['selected_option_data']['price'],
    //                 'customer_name' => $purchaseData['full_name'],
    //                 'customer_email' => $purchaseData['email'],
    //                 'payment_reference' => $payment->reference,
    //                 'status' => 'completed',
    //                 'payment_details' => [
    //                     'last_four' => $purchaseData['card_last_four'],
    //                     'card_type' => $this->getCardType($purchaseData['card_number']),
    //                     'expiry' => $purchaseData['expiry']
    //                 ],
    //                 'treatment_details' => $purchaseData['selected_option_data']
    //             ]);
                
    //             // Send confirmation email
    //             if (filter_var($order->customer_email, FILTER_VALIDATE_EMAIL)) {
    //                 Mail::to($order->customer_email)->send(
    //                     new PackagePurchaseConfirmation($order)
    //                 );
    //             }
                
    //             // Clear session data
    //             $request->session()->forget('purchase_data');
                
    //             // Redirect to confirmation page
    //             return redirect()->route('order.confirmation', $order->id)
    //                 ->with('success', 'Purchase completed successfully!');
    //     }
        
    //     // Store validated data in session
    //     $purchaseData = $request->session()->get('purchase_data', []);
    //     $purchaseData = array_merge($purchaseData, $validated);
    //     $request->session()->put('purchase_data', $purchaseData);
        
    //     // Redirect to next step
    //     return redirect()->route('packages.purchase', [
    //         'package' => $package,
    //         'step' => $currentStep + 1,
    //     ]);

    } catch (ValidationException $e) {
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput();
            
    } catch (\Exception $e) {
        \Log::error('Purchase failed: ' . $e->getMessage(), [
            'exception' => $e,
            'package_id' => $package->id,
            'user_id' => auth()->id()
        ]);
        
        return redirect()->back()
            ->with('error', 'Error: ' . $e->getMessage())
            ->withInput();
    }
}

// protected function getCardType($cardNumber)
// {
//     $cardNumber = preg_replace('/\D/', '', $cardNumber);
    
//     if (preg_match('/^4/', $cardNumber)) return 'Visa';
//     if (preg_match('/^5[1-5]/', $cardNumber)) return 'Mastercard';
//     if (preg_match('/^3[47]/', $cardNumber)) return 'American Express';
//     if (preg_match('/^6(?:011|5)/', $cardNumber)) return 'Discover';
    
//     return 'Unknown';
// }

//     protected function processPayment($cardNumber, $expiry, $cvv, $amount)
//     {
//         // Validate card number using Luhn algorithm
//         if (!$this->validateCardNumber($cardNumber)) {
//             throw new \Exception('Invalid card number');
//         }
        
//         // Validate expiry date
//         $expiryParts = explode('/', $expiry);
//         if (count($expiryParts) !== 2 || !$this->validateExpiry($expiryParts[0], $expiryParts[1])) {
//             throw new \Exception('Invalid expiry date format (MM/YY)');
//         }
        
//         if (!preg_match('/^\d{3,4}$/', $cvv)) {
//             throw new \Exception('Invalid CVV');
//         }
        
//         // In a real implementation, integrate with payment gateway here
//         // For now, simulate successful payment
//         return (object) [
//             'reference' => 'PAY-' . Str::random(10),
//             'status' => 'success',
//         ];
//     }

//     protected function validateCardNumber($number)
//     {
//         // Basic Luhn algorithm validation
//         $number = preg_replace('/\D/', '', $number);
        
//         $sum = 0;
//         $length = strlen($number);
        
//         for ($i = 0; $i < $length; $i++) {
//             $digit = (int)$number[$length - $i - 1];
//             if ($i % 2 === 1) {
//                 $digit *= 2;
//                 if ($digit > 9) {
//                     $digit -= 9;
//                 }
//             }
//             $sum += $digit;
//         }
        
//         return ($sum % 10 === 0);
//     }

//     protected function validateExpiry($month, $year)
//     {
//         $currentYear = date('y');
//         $currentMonth = date('m');
        
//         $year = (int)$year;
//         $month = (int)$month;
        
//         if ($year > $currentYear + 20 || $year < $currentYear) {
//             return false;
//         }
        
//         if ($year == $currentYear && $month < $currentMonth) {
//             return false;
//         }
        
//         return true;
//     }
}