<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\PackageController;
use App\Models\Package;
use App\Models\Purchase;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Exception\CardException;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    public function handlePayment(Request $request, Package $package)
    {
        try {
            Log::info('Stripe payment initiated', ['package_id' => $package->id, 'request_data' => $request->all()]);
            
            // Get purchase data from session
            $purchaseData = session('purchase_data', []);
            
            if (!isset($purchaseData['selected_option'])) {
                Log::error('No selected option in session');
                return redirect()->route('packages.purchase', [
                    'package' => $package, 
                    'step' => 2
                ])->with('error', 'Please select a treatment option');
            }
            
            $selectedOptionIndex = $purchaseData['selected_option'];
            $selectedOption = $package->options[$selectedOptionIndex];
            $amount = $selectedOption['price'];
            
            // Validate Stripe token
            if (!$request->has('stripeToken')) {
                Log::error('No Stripe token provided');
                return redirect()->route('purchase.cancel')
                    ->with('error', 'Payment token missing. Please try again.');
            }
            
            // Set Stripe API key
            Stripe::setApiKey(env('STRIPE_SECRET'));
            
            // Create charge
            $charge = Charge::create([
                'amount' => $amount * 100, // Convert to cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Purchase of ' . $package->title . ' - ' . $selectedOption['name'],
            ]);
            
            Log::info('Stripe charge created', ['charge_id' => $charge->id]);
            
            // Create purchase record
            $purchaseController = new PackageController();
            $purchase = $purchaseController->createPurchaseRecord($package, $selectedOptionIndex);
            
            // Create payment record
            Payment::create([
                'purchase_id' => $purchase->id,
                'payment_method' => 'stripe',
                'transaction_id' => $charge->id,
                'amount' => $amount,
                'status' => 'completed',
                'payment_details' => $charge->toArray()
            ]);
            
            Log::info('Payment record created', ['purchase_id' => $purchase->id]);
            
            // Clear session data
            session()->forget('purchase_data');
            
            // Redirect to success page
          return redirect()->route('purchase.success', ['purchase' => $purchase->id]);

            
        } catch (CardException $e) {
            // Card was declined
            Log::error('Card payment failed', ['error' => $e->getMessage()]);
            return redirect()->route('purchase.cancel')
                ->with('error', 'Payment failed: ' . $e->getMessage());
        } catch (ApiErrorException $e) {
            // Stripe API error
            Log::error('Stripe API error', ['error' => $e->getMessage()]);
            return redirect()->route('purchase.cancel')
                ->with('error', 'Payment error: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Other errors
            Log::error('Unexpected payment error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('purchase.cancel')
                ->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }
}