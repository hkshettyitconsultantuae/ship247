import React, {useEffect} from "react";
import {currencyFormatter} from "../../views/helpers/helpers";
import {Accordion, AccordionBody, AccordionHeader, AccordionItem} from "react-headless-accordion";
import { usePage } from "@inertiajs/react";
// import { storeBookingPriceBreakDownDetailsInSession } from "../../views/network/network";
import ShippingDetailsRow from "@/Includes/ShippingDetailsRow";

const ShippingDetails = ({setTotalAmount, price_amount, price_details, uid, company_id, updatePriceBreakDown }) => {
    const {constants} = usePage().props;
    const params = new URLSearchParams(window.location.search);
    let charges = [];

    useEffect(() => {
        if (company_id === constants.CMA_COMPANY_ID) {
            setTotalAmount(price_amount);
        }
    }, []);

    if (price_amount && constants.IGNORED_COMPANIES.includes(company_id)) {
        charges.push({
            'heading': 'Pickup Charges',
            data: [{name: "Pickup Charges", amount: 0, message: 'Amount will be shared later'}]
        });
    }

    if (company_id === constants.CMA_COMPANY_ID) {
        if (price_details?.charges) {
            charges.push({'heading': 'Per Equipment', data: price_details?.charges});
        }
        if (price_details?.extra) {
            charges.push({'heading': 'Extras', data: price_details?.extra});
        }
    } else if (company_id === constants.MAERSK_COMPANY_ID) {
        if (price_details?.origin_charges_total_usd) {
            charges.push({
                'heading': 'Origin Charges',
                data: [{name: 'Origin Charges', amount: price_details?.origin_charges_total_usd}]
            });
        }
        if (price_details?.freight_charges_total_usd) {
            charges.push({
                'heading': 'Freight Charges',
                data: [{
                    name: "BASIC OCEAN FREIGHT",
                    amount: parseFloat(price_details?.freight_charges_total_usd) + 100
                }]
            });
        }
        if (price_details?.destination_charges_total_usd) {
            charges.push({
                'heading': 'Destination Charges',
                data: [{name: "Destination Charges", amount: price_details?.destination_charges_total_usd}]
            });
        }
    } else if (company_id === constants.HAPAG_COMPANY_ID) {
        let data = {
            'origin_charges': 0,
            'freight_charges': price_amount,
            'destination_charges': 0,
        };

        price_details?.charges
            .map(charge => {
                if ("Freight Surcharges" === charge.ChargeType) {
                    data.freight_charges += charge.Amount;
                } else if ("Export Surcharges" === charge.ChargeType) {
                    data.origin_charges += charge.Amount;
                } else if ("Import Surcharges" === charge.ChargeType) {
                    data.destination_charges += charge.Amount;
                }
            });

        // Set Origin Charges
        charges.push({
            'heading': 'Origin Charges',
            data: [{name: 'Origin Charges', amount: parseFloat(data.origin_charges)}]
        });

        // Set Freight Charges
        charges.push({
            'heading': 'Freight Charges',
            data: [{
                name: "BASIC OCEAN FREIGHT",
                amount: parseFloat(data.freight_charges) + 100
            }]
        });

        // Set Destination Charges
        charges.push({
            'heading': 'Destination Charges',
            data: [{name: "Destination Charges", amount: parseFloat(data.destination_charges)}]
        });
    } else if (company_id === constants.MSC_COMPANY_ID) {
        charges.push({
            'heading': 'Origin Charges',
            data: [{
                name: "Origin Charges",
                amount: price_details.origin_charges
            }]
        });

        charges.push({
            'heading': 'Freight Charges',
            data: [{
                name: "BASIC OCEAN FREIGHT",
                amount: price_details.freight_charges + 100
            }]
        });

        charges.push({
            'heading': 'Destination Charges',
            data: [{
                name: "Destination Charges",
                amount: price_details.destination_charges
            }]
        });

    } else {
        if (price_details?.pickup_charges) {
            charges.push({
                'heading': 'Pickup Charges',
                data: [{name: "Pickup Charges", amount: price_details?.pickup_charges}]
            });
        }
        if (price_details?.origin_charges || price_details?.origin_charges_included) {
            charges.push({
                'heading': 'Origin Charges',
                data: [{
                    name: "Origin Charges",
                    included: price_details?.origin_charges_included,
                    amount: price_details?.origin_charges
                }]
            });
        }
        if (price_details?.freight_charges) {
            let chargeName = parseInt(params.get('route_type')) === constants.ROUTE_TYPE_LAND
                ? "BASIC LAND FREIGHT" : "BASIC OCEAN FREIGHT";
            charges.push({
                'heading': 'Freight Charges',
                data: [{name: chargeName, amount: price_details?.freight_charges}]
            });
        }
        if (price_details?.destination_charges || price_details?.destination_charges_included) {
            charges.push({
                'heading': 'Destination Charges',
                data: [{
                    name: "Destination Charges",
                    included: price_details?.destination_charges_included,
                    amount: price_details?.destination_charges
                }]
            });
        }
        if (price_details?.delivery_charges) {
            charges.push({
                'heading': 'Delivery Charges',
                data: [{name: "Delivery Charges", amount: price_details?.delivery_charges}]
            });
        }
    }

    if (price_amount && constants.IGNORED_COMPANIES.includes(company_id)) {
        charges.push({
            'heading': 'Delivery Charges',
            data: [{name: "Delivery Charges", amount: 0, message: 'Amount will be shared later'}]
        });
    }




    // const saveBokingPriceBreakdownInSession = () => {
    //     storeBookingPriceBreakDownDetailsInSession(bookingAddons)
    //         .then((res) => {
    //             window.location.href = '/shipment-details';
    //         })
    //         .catch((error) => { console.log(error); })
    //         .finally(() => { });
    // }






    return (
        (charges.length > 0) && <Accordion className="product-price-breakdown">
            <AccordionItem>
                <AccordionHeader className={`accordion-head`}>
                </AccordionHeader>

                <AccordionBody>
                    <div className="accordion-body">
                        <h2 className="title">Price Breakdown</h2>
                        <table className="price-breakdown-table">
                            <tbody>
                            {charges.length > 0 && charges.map((chargeType, index) => {
                                if (chargeType.data.length) {
                                    return (
                                        <React.Fragment key={`${company_id}-${index}`}>
                                            <tr>
                                                <th colSpan={2}>{chargeType.heading}</th>
                                                {/* <th>{chargeType.heading}</th> */}
                                            </tr>
                                            {chargeType.data.map((charge, i) => {
                                                if (company_id === constants.CMA_COMPANY_ID) {
                                                    return <tr
                                                        key={`shipping_details_charges_${uid}-${company_id}-${index}-${i}`}>
                                                        <td>{charge.charge_code} - {charge.charge_name}</td>
                                                        <td className="text-right">{
                                                            charge.hasOwnProperty('included') && charge.included === true && !charge.charge_name.includes('FREIGHT')
                                                                ? 'Included in Ocean Freight'
                                                                : currencyFormatter(charge.amount)}</td>
                                                    </tr>
                                                } else if (company_id === constants.MAERSK_COMPANY_ID) {
                                                    return <ShippingDetailsRow charge={charge}
                                                                               key={`${uid}-${company_id}-${index}-${i}`}
                                                                               name={`${uid}-${company_id}-${index}-${i}`}
                                                                               setTotalAmount={setTotalAmount}
                                                                               updatePriceBreakDown={updatePriceBreakDown}
                                                                               defaultChecked={true}/>
                                                } else if (company_id === constants.HAPAG_COMPANY_ID) {
                                                    return <ShippingDetailsRow charge={charge}
                                                                               key={`${uid}-${company_id}-${index}-${i}`}
                                                                               name={`${uid}-${company_id}-${index}-${i}`}
                                                                               setTotalAmount={setTotalAmount}
                                                                               updatePriceBreakDown={updatePriceBreakDown}
                                                                               defaultChecked={true}/>
                                                } else if (company_id === constants.MSC_COMPANY_ID) {
                                                    return <ShippingDetailsRow charge={charge}
                                                                               key={`${uid}-${company_id}-${index}-${i}`}
                                                                               name={`${uid}-${company_id}-${index}-${i}`}
                                                                               setTotalAmount={setTotalAmount}
                                                                               updatePriceBreakDown={updatePriceBreakDown}
                                                                               defaultChecked={true}/>
                                                } else {
                                                    return <ShippingDetailsRow charge={charge}
                                                                               key={`${uid}-${company_id}-${index}-${i}`}
                                                                               name={`${uid}-${company_id}-${index}-${i}`}
                                                                               setTotalAmount={setTotalAmount}
                                                                               updatePriceBreakDown={updatePriceBreakDown}
                                                                               defaultChecked={true}/>
                                                }
                                            })}
                                        </React.Fragment>
                                    )
                                }
                            })}
                            </tbody>
                        </table>
                    </div>
                </AccordionBody>
            </AccordionItem>
        </Accordion>
    );
};

export default ShippingDetails;
