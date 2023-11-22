import { Head } from '@inertiajs/react';
import { useState } from "react";
import { storeBookingAddonsDetailsInSession } from "../../views/network/network";
// import { currencyFormatter } from "../../views/helpers/helpers";

export default function AdditionalServices({booking_addons}) {
    const [bookingAddons, setBookingAddons] = useState(booking_addons);

    const saveBookingAddonsDetailsInSession = () => {
        storeBookingAddonsDetailsInSession(bookingAddons)
            .then((res) => {
                window.location.href = '/shipment-details';
            })
            .catch((error) => { console.log(error); })
            .finally(() => { });
    }

    const handleToggle = (index) => {
        setBookingAddons((prevState) => {
            const updatedBookingAddon = [...prevState];
            updatedBookingAddon[index]["is_checked"] = !updatedBookingAddon[index]["is_checked"];
            return updatedBookingAddon;
        });
    };

    const handleIncrement = (index) => {
        setBookingAddons(prevBookingAddon => {
            const updatedBookingAddon = [...prevBookingAddon];
            updatedBookingAddon[index]["default_value"]++;
            return updatedBookingAddon;
        });
    };

    const handleDecrement = (index) => {
        setBookingAddons(prevBookingAddon => {
            const updatedBookingAddon = [...prevBookingAddon];
            updatedBookingAddon[index]["default_value"] = Math.max(0, updatedBookingAddon[index]["default_value"] - 1);
            return updatedBookingAddon;
        });
    };

    return (
        <>
            <Head title="Additional Services" />

            <section className="max-w-screen-3xl mx-auto">
                <div className='default-container my-8'>
                    <div className="booking-steps">
                        <div className="step active">
                            <span>additional services</span>
                        </div>

                        <div className="step">
                            <span>Shipment Details</span>
                        </div>

                        <div className="step">
                            <span>payment</span>
                        </div>
                    </div>
                </div>
            </section>

            <section className="max-w-screen-xl mx-auto">
                <div className="default-container my-16">
                    <div className="shadow-box">
                        <div className="booking-box">
                            <h4 className="title">Do you need these additional services?</h4>

                            <div>
                                {bookingAddons.length > 0 ? (
                                    bookingAddons.map((addon, index) => (
                                        <div className="inner-content" key={addon.id}>
                                            <p className="default-content mb-1 sm:mb-0">
                                                {addon.name}
                                            </p>

                                            <div className='flex items-center justify-between'>
                                                {addon.additional_text ? (
                                                    <p className="sm:text-right mr-4">
                                                        <span className='text-sm leading-none block'>Will be quote after booking?</span>
                                                        <span className='uppercase block text-gray-300 text-[10px]'>(as per the value)</span>
                                                    </p>

                                                ) : <p className="font-bold mr-4 text-lg">
                                                    {/* { addon.type === "toggle" ? currencyFormatter(addon.default_value) : addon.default_value} */}
                                                    </p>}
                                                <label className="relative inline-flex items-center cursor-pointer">
                                                    {addon.type === "toggle" &&
                                                        (
                                                            <>
                                                                <input type="checkbox" onClick={() => handleToggle(index)} className="sr-only peer" />
                                                                <div className="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-1 peer-focus:ring-gray-300 dark:peer-focus:ring-gray-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                                                            </>
                                                        )}
                                                    {addon.type === "counter" &&
                                                        (
                                                            <div className="flex flex-row h-8 w-40 rounded-lg relative bg-transparent">
                                                                <button onClick={() => handleDecrement(index)} data-action="decrement" className=" bg-gray-100 text-gray-600 hover:text-gray-700 hover:bg-gray-300 h-full w-24 rounded-l cursor-pointer outline-none">
                                                                    <span className="m-auto text-2xl font-thin leading-none">−</span>
                                                                </button>
                                                                <input type="number" className="text-center border-gray-200 w-full bg-white font-semibold text-md md:text-basecursor-default flex items-center text-gray-700  outline-none" name="custom-input-number" value={addon.default_value} disabled />
                                                                <button onClick={() => handleIncrement(index)} data-action="increment" className="bg-gray-100 text-gray-600 hover:text-gray-700 hover:bg-gray-300 h-full w-24 rounded-r cursor-pointer">
                                                                    <span className="m-auto text-2xl font-thin leading-none">+</span>
                                                                </button>
                                                            </div>
                                                        )}
                                                </label>
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <div>No addons found</div>
                                )}
                            </div>

                            {/* <div className="inner-content">
                                <p className="default-content mb-1 sm:mb-0">
                                Insurance
                                </p>

                                <div className='flex items-center justify-between'>
                                    <p className="sm:text-right mr-4">
                                        <span className='text-sm leading-none block'>Will be quote after booking?</span>
                                        <span className='uppercase block text-gray-300 text-[10px]'>(as per the value)</span>
                                    </p>
                                    <label className="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="" className="sr-only peer" />
                                        <div className="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-1 peer-focus:ring-gray-300 dark:peer-focus:ring-gray-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                                    </label>
                                </div>
                            </div> */}
                            {/*
                            <div className="inner-content">
                                <p className="default-content mb-1 sm:mb-0">
                                Pre Shipment Inspection Service
                                </p>

                                <div className='flex items-center justify-between'>
                                    <p className="font-bold mr-4 text-lg">$4000</p>
                                    <label className="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="" className="sr-only peer" />
                                        <div className="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-1 peer-focus:ring-gray-300 dark:peer-focus:ring-gray-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                                    </label>
                                </div>
                            </div>

                            <div className="inner-content">
                                <p className="default-content mb-1 sm:mb-0">
                                Premium Contianer
                                </p>

                                <div className='flex items-center justify-between'>
                                    <p className="font-bold mr-4 text-lg">$100</p>
                                    <label className="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="" className="sr-only peer" />
                                        <div className="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-1 peer-focus:ring-gray-300 dark:peer-focus:ring-gray-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                                    </label>
                                </div>
                            </div>

                            <div className="inner-content">
                                <p className="default-content mb-1 sm:mb-0">
                                Additional Container Free Time at PODx
                                </p>

                                <div className='flex items-center justify-between'>
                                    <p className="font-bold mr-4 text-lg">$0</p>
                                    <div className="custom-number-input h-8 w-28">
                                        <div className="flex flex-row h-8 w-full rounded-lg relative bg-transparent">
                                            <button data-action="decrement" className=" bg-gray-100 text-gray-600 hover:text-gray-700 hover:bg-gray-300 h-full w-24 rounded-l cursor-pointer outline-none">
                                            <span className="m-auto text-2xl font-thin leading-4">−</span>
                                            </button>
                                            <input type="number" className="text-center border-gray-200 w-full bg-white font-semibold text-md md:text-basecursor-default flex items-center text-gray-700  outline-none" name="custom-input-number" value="0" disabled />
                                            <button data-action="increment" className="bg-gray-100 text-gray-600 hover:text-gray-700 hover:bg-gray-300 h-full w-24 rounded-r cursor-pointer">
                                                <span className="m-auto text-2xl font-thin leading-4">+</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div> */}

                            <div className="flex justify-end flex-col items-end">
                                <button onClick={() => saveBookingAddonsDetailsInSession()} className='default-button-v2'>
                                    <span>PROCEED</span>
                                </button>
                                <span className='text-center text-xs text-gray-500 mt-2'>Team will contact you via email</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    )
}
