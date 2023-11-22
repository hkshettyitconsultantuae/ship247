import {currencyFormatter} from "../../views/helpers/helpers";
import React, {useEffect, useState} from "react";

const ShippingDetailsRow = ({name, charge, setTotalAmount, defaultChecked = false, updatePriceBreakDown}) => {
    const [checked, setChecked] = useState(defaultChecked);
    const [disabled, setDisabled] = useState(false);

    useEffect(() => {
        if ((charge.hasOwnProperty('included') && charge.included === 1)
            || charge.name.includes('FREIGHT')) {
            setDisabled(true);
            setChecked(true);
        }
    }, [])

    useEffect(() => {
        if (checked) {
            setTotalAmount(totalAmount => totalAmount + charge.amount);
            updatePriceBreakDown(charge, true);
        } else {
            setTotalAmount(totalAmount => totalAmount - charge.amount);
            updatePriceBreakDown(charge, false);
        }
    }, [checked])

    return <tr key={`shipping_details_charges_${name}`}>
        <td>
            <div className="checkbox-field">
                <input type="checkbox" className="form-checkbox" disabled={disabled} checked={checked}
                       onChange={e => {
                           setChecked(!checked)
                       }}
                       name={`charges_${name}`}/>

                <span className="">
                {charge.name}
                </span>
            </div>
        </td>
        <td className="text-right">{charge.hasOwnProperty('message')
            ? charge.message
            : charge.hasOwnProperty('included') && charge.included === 1
                ? 'Included in Ocean Freight'
                : currencyFormatter(charge.amount)}</td>
    </tr>
}

export default ShippingDetailsRow;
