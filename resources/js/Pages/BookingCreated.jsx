import { Head } from '@inertiajs/react';
// import PaymentForm from './PaymentForm';
import React, { useState, useEffect } from "react";
// import { Elements } from '@stripe/react-stripe-js';
import { loadStripe } from '@stripe/stripe-js';
export default function BookingCreated({ booking, stripe_key }) {


    useEffect(() => {
       if(booking && booking.payment && booking.payment.status == 2){
            window.location.href = '/';
       }

    });


    // const handlePaymentSuccess = () => {
    //     alert('Payment success.');
    //     // Handle success, e.g., redirect or show success message
    // };

    // const handlePaymentFailure = () => {
    //     // Handle failure, e.g., show error message
    //     alert('Payment failed. Please try again.');
    // };


    const stripePromise = loadStripe(stripe_key);

    return (
        <>
            <Head title="Booking Step 2" />

            <section className="max-w-screen-3xl mx-auto">
                <div className='default-container my-8'>
                    <div className="booking-steps">
                        <div className="step active">
                            <span>additional services</span>
                        </div>

                        <div className="step active">
                            <span>Shipment Details</span>
                        </div>

                        <div className="step active">
                            <span>payment</span>
                        </div>
                    </div>
                </div>
            </section>

            <section className="max-w-screen-xl mx-auto">
                <div className="default-container my-16">
                    <div className="shadow-box">
                        {/* <div className="booking-box"> */}
                            <h2 className="text-center font-bold text-[32px]">Booking Created</h2>
                            <p className='text-center mt-4 text-[20px]'>Your Booking has been created. Kindly check your account for details.</p>
                            <div className="text-center">
                                <a href="/" className='default-button-v2 white mt-10'>Continue to Search!</a>
                            </div>
                            {/* <div>
                                <h1>Make a Payment</h1> */}

                                {/* <Elements stripe={stripePromise}>
                                    <PaymentForm bookingDetails={booking} onSuccess={handlePaymentSuccess} onFailure={handlePaymentFailure} />
                                </Elements> */}

                            {/* </div> */}
                        {/* </div> */}
                    </div>
                </div>
            </section>

        </>
    )
}
