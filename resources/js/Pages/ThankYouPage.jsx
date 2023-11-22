import { Head } from '@inertiajs/react';
import React, { useState, useEffect } from "react";

export default function ThankYouPage({ booking }) {

    console.log(booking);
    return (
        <>
            <Head title="Thank you Page" />

            {/* <section className="max-w-screen-3xl mx-auto">
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
            </section> */}

            <section className="max-w-screen-xl mx-auto">
                <div className="default-container my-16">
                    <div className="shadow-box small-box">
                        {booking?.payment?.status == 2 &&
                            (
                                <>
                                    <figure>
                                        <img src="/images/svg/booking-complete.svg" alt="" className="m-auto" />
                                    </figure>

                                    <h6 className="text-center secondary-font-regular primary-color uppercase text-[30px]">Booking Completed</h6>


                                    <p className="text-center text-[16px]">Your booking is completed , visit your dashboard to view details</p>

                                    <div className="text-center mt-6 mb-6">
                                        <a href="/" className="text-center default-button red">GO to YOUR DASHBOARD</a>
                                    </div>
                                </>
                            )
                        }
                        {booking?.payment?.status == 3 &&
                            (
                                <>
                                    <h6 className="text-center secondary-font-regular primary-color uppercase text-[30px]">Payment Failed</h6>
                                    <p className="text-center text-[16px]">Your booking is noy completed , visit your dashboard to view details</p></>
                            )
                        }
                    </div>
                </div>
            </section>

        </>
    )
}
