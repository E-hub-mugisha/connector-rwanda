@extends('layouts.base')
@section('title', 'Payment')
@section('content')

@php
    $booking = \App\Models\ServiceBooking::find(request('booking_id'));
@endphp

<h2>Payment Options for {{ $booking->service->name }}</h2>

<p>Your booking for <strong>{{ $booking->service->name }}</strong> is confirmed. How would you like to proceed?</p>

<strong>Selected Payment Mode:</strong> {{ ucfirst($booking->payment_mode) }}

<div>
    <!-- Pay Now Button -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">Pay Now</button>

    <!-- Pay Later Button -->
    <a href="{{ route('home') }}" class="btn btn-secondary">Pay Later</a>
</div>

<!-- Modal (Dynamically Changes Based on Payment Mode) -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Complete Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($booking->payment_mode == 'card')
                    <!-- Card Payment Form -->
                    <form action="/paymentProcess" method="POST">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <input type="hidden" name="user_id" value="{{ $booking->user_id }}">
                        <input type="hidden" name="total" value="{{ $booking->total }}">
                        <div class="mb-3">
                            <label for="card_number" class="form-label">Card Number</label>
                            <input type="text" name="card_number" class="form-control" required maxlength="16" pattern="\d{16}" title="Enter a valid 16-digit card number">
                        </div>
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date (MM/YY)</label>
                            <input type="text" name="expiry_date" class="form-control" required pattern="\d{2}/\d{2}" title="Format: MM/YY">
                        </div>
                        <div class="mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" name="cvv" class="form-control" required maxlength="3" pattern="\d{3}" title="Enter a valid 3-digit CVV">
                        </div>
                        <button type="submit" class="btn btn-success">Confirm Payment</button>
                    </form>
                
                @elseif($booking->payment_mode == 'mobile')
                    <!-- Mobile Money Payment -->
                    <p>Send your payment to <strong>+250 123 456 789</strong> and enter the transaction ID below:</p>
                    <form action="/paymentProcess" method="POST">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <input type="hidden" name="user_id" value="{{ $booking->user_id }}">
                        <input type="hidden" name="total" value="{{ $booking->total }}">
                        <div class="mb-3">
                            <label for="transaction_id" class="form-label">Transaction ID</label>
                            <input type="text" name="transaction_id" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Confirm Payment</button>
                    </form>

                @elseif($booking->payment_mode == 'cash')
                    <!-- Cash Payment Instructions -->
                    <p>Your payment will be processed as "pending" and confirmed once received.</p>
                    <a href="{{ route('home') }}" class="btn btn-secondary">OK</a>
                
                @else
                    <p class="text-danger">Invalid payment method selected.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
