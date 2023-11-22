import { Head } from '@inertiajs/react';
import React, { useState, useEffect } from "react";
import { storeShipmentDetails } from "../../views/network/network";
import { currencyFormatter, dateFormatter } from "../../views/helpers/helpers";

export default function ShipmentDetails({ shipmentDetails }) {
    const [shipmentTotalAmount, setShipmentTotalAmount] = useState(0);
    const [shipmentCharges, setShipmentCharges] = useState(0);
    const [noOfContainers, setNoOfContainers] = useState(1);

    useEffect(() => {
        setShipmentCharges(parseFloat(shipmentDetails.booking_details.shipping_amount * noOfContainers));
    }, [noOfContainers]);

    useEffect(() => {
        setShipmentTotalAmount(calculateTotalShippingAmount());
    }, [shipmentCharges]);

    const saveShipmentDetails = () => {
        let shipmentDetailsData = { ...shipmentDetails }
        shipmentDetailsData["booking_details"]["total_amount"] = shipmentTotalAmount;
        shipmentDetailsData["booking_details"]["no_of_containers"] = noOfContainers;

        storeShipmentDetails(shipmentDetailsData)
            .then((res) => {
                console.log(res);
                    const booking_id = res?.data?.data?.booking?.id;
                    window.location.href = '/booking-created/' + booking_id;
            })
            .catch((error) => { console.log(error); })
            .finally(() => { });
    }

    const handleIncrement = () => {
        setNoOfContainers(prevNofContainers => {
            let noOfContainers = prevNofContainers;
            noOfContainers++;
            return noOfContainers;
        });
    };

    const handleDecrement = () => {
        setNoOfContainers(prevNofContainers => {
            let noOfContainers = prevNofContainers;
            noOfContainers = Math.max(0, noOfContainers - 1);
            if (noOfContainers > 0) {
                return noOfContainers;
            } else {
                return 1;
            }
        });
    };

    const calculateTotalShippingAmount = () => {
        const addon_details = shipmentDetails?.addon_details;
        let total_amount = 0
        if (addon_details.length) {
            addon_details.forEach(item => {
                if (item.is_checked && item.type === "toggle" && !isNaN(item.default_value)) {
                    total_amount += parseInt(item.default_value);
                } else if (item.default_value > 0 && item.type === "counter") {
                    if(!isNaN(item.step)) {
                        total_amount += parseFloat(item.default_value) * parseFloat(item.step);
                    } else {
                        total_amount += parseFloat(item.default_value);
                    }
                }
            });
        }
        total_amount = total_amount + shipmentCharges;
        return parseFloat(total_amount);
    }

    const origin_name = (shipmentDetails.booking_details.origin.city ?? shipmentDetails.booking_details.origin.port).substring(0, 10).trim() +
        ', ' + shipmentDetails.booking_details.origin.country.name;
    const destination_name = (shipmentDetails.booking_details.destination.city ?? shipmentDetails.booking_details.destination.port).substring(0, 10).trim() +
        ', ' + shipmentDetails.booking_details.destination.country.name;

    return (
        <>
            <Head title="Shipment Details" />

            <section className="max-w-screen-3xl mx-auto">
                <div className='default-container my-8'>
                    <div className="booking-steps">
                        <div className="step active">
                            <span>additional services</span>
                        </div>

                        <div className="step active">
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
                            <h4 className="title">SHIPMENT DETAILS</h4>

                            <table className="default-table shipping-details">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div className="default-content mb-1 sm:mb-0">
                                                <span className='block text-[12px] text-gray-400 uppercase'>Origin</span>
                                                {origin_name}
                                            </div>
                                        </td>

                                        <td>
                                            <div className="default-content mb-1 sm:mb-0 sm:text-left text-right">
                                                <span className='block text-[12px] text-gray-400 uppercase'>Destination</span>
                                                {destination_name}
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div className="default-content mb-1 sm:mb-0">
                                                <span className='block text-[12px] text-gray-400 uppercase'>date</span>
                                                {shipmentDetails?.booking_details ? dateFormatter(shipmentDetails.booking_details.departure_date_time) : '-'}
                                            </div>
                                        </td>

                                        <td>
                                            <div className="default-content mb-1 sm:mb-0 sm:text-left text-right">
                                                <span className='block text-[12px] text-gray-400 uppercase'>Container Type</span>
                                                {shipmentDetails?.booking_details?.container_size.display_label}
                                            </div>
                                        </td>
                                    </tr>

                                    {/* <tr>
                                        <td>
                                            <div className="default-content mb-1 sm:mb-0">
                                                <span className='block text-[12px] text-gray-400 uppercase'>Product</span>
                                                VEGETABLES
                                            </div>
                                        </td>

                                        <td>
                                            <div className="default-content mb-1 sm:mb-0 sm:text-left text-right">
                                                <span className='block text-[12px] text-gray-400 uppercase'>Container Free Time</span>
                                                7  Days
                                            </div>
                                        </td>
                                    </tr> */}
                                </tbody>
                            </table>

                            <hr className='border-b-2 ' />

                            <table className="default-table shipping-pricing">
                                <tbody>
                                    <tr>
                                        <td>
                                            <p className="default-content">
                                                No of Containers
                                            </p>
                                        </td>

                                        <td>
                                            <div className="flex flex-row h-8 w-full rounded-lg relative bg-transparent">
                                                <button onClick={() => handleDecrement()} data-action="decrement" className=" bg-gray-100 text-gray-600 hover:text-gray-700 hover:bg-gray-300 h-full w-24 rounded-l cursor-pointer outline-none">
                                                    <span className="m-auto text-2xl font-thin leading-4">−</span>
                                                </button>
                                                <input type="number" className="text-center border-gray-200 w-full bg-white font-semibold text-md md:text-basecursor-default flex items-center text-gray-700  outline-none" name="custom-input-number" value={noOfContainers} disabled />
                                                <button onClick={() => handleIncrement()} data-action="increment" className="bg-gray-100 text-gray-600 hover:text-gray-700 hover:bg-gray-300 h-full w-24 rounded-r cursor-pointer">
                                                    <span className="m-auto text-2xl font-thin leading-4">+</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table className="default-table shipping-pricing">
                                <tbody>
                                    <tr>
                                        <td>
                                            <p className="default-content">
                                                Shipment Charges
                                            </p>
                                        </td>

                                        <td>
                                            <p className="default-content sm:text-left text-right">
                                                {currencyFormatter(shipmentCharges)}
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <hr className='border-b-2 ' />

                            <h4 className="title mt-10">ADDON DETAILS</h4>
                            <table className="default-table shipping-pricing">
                                <tbody>
                                    {shipmentDetails.addon_details && shipmentDetails.addon_details.length > 0 ? (
                                        shipmentDetails.addon_details.map((addon, index) => (
                                            addon.type === "toggle" && addon.is_checked ? (
                                                <tr key={addon.id}>
                                                    <td>
                                                        <div className="default-content">
                                                            {addon.name}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div className="default-content sm:text-left text-right">
                                                            {currencyFormatter(addon.default_value)}
                                                        </div>
                                                    </td>
                                                </tr>
                                            ) : (
                                                addon.type === "counter" && (
                                                    <tr key={addon.id}>
                                                        <td>
                                                            <div className="default-content">
                                                                {addon.name}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div className="default-content sm:text-left text-right">
                                                                { currencyFormatter(addon.step ? (parseFloat(addon.default_value) * parseFloat(addon.step))
                                                                : parseFloat(addon.default_value))}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                )
                                            )
                                        ))
                                    ) : (
                                        <></>
                                    )}
                                    <tr>
                                        <td>
                                        </td>

                                        <td>
                                            <p className="text-3xl font-bold sm:text-left text-right">
                                                {shipmentTotalAmount ? currencyFormatter(shipmentTotalAmount) : "0.00"}
                                            </p>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                            <div className="flex justify-end flex-col items-end">
                                <button onClick={() => saveShipmentDetails()} className='default-button-v2'>
                                    <span>PROCEED</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    )
}
