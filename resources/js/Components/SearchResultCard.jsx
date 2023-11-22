import {currencyFormatter} from "../../views/helpers/helpers";
import dayjs from "dayjs";
import advancedFormat from 'dayjs/plugin/advancedFormat';
import {storeBookingDetailsInSession, storeRequestQuoteData} from "../../views/network/network";
import ShippingDetails from '@/Includes/ShippingDetails';
import {useEffect, useState} from 'react';
import {Modal} from 'antd';
import BookNowButton, {PLACEMENT_MAIN_RESULT} from "@/Components/BookNowButton";
import {usePage} from "@inertiajs/react";

dayjs.extend(advancedFormat)

const SearchResultCard = ({result}) => {
    const [totalAmount, setTotalAmount] = useState(0);
    const {constants} = usePage().props;
    const params = new URLSearchParams(window.location.search);
    const [isFormSubmitted, setIsFormSubmitted] = useState(false);
    const [priceBreakDown, setPriceBreakDown] = useState({});
    const [formData, setFormData] = useState({
        name: result.user_details ? `${result?.user_details?.first_name} ${result?.user_details?.last_name}` : null,
        company: result.user_details?.company ? `${result?.user_details?.company?.name}` : null,
        phone: result.user_details ? `${result?.user_details?.phone_number}` : null,
        email: result.user_details ? `${result?.user_details?.email}` : null,
        description: '',
    });

    // const saveBookingDetailsInSession = (data) => {
    //     storeBookingDetailsInSession(data)
    //         .then((res) => {
    //             window.location.href = '/additional-services';
    //         })
    //         .catch((error) => {
    //             console.log(error);
    //         })
    //         .finally(() => {
    //         });
    // }

    const [isModalOpen, setIsModalOpen] = useState(false);

    const showModal = () => {
        setIsModalOpen(true);
        setIsFormSubmitted(false);
    };

    const handleCancel = () => {
        setIsModalOpen(false);
    };


    const data = {
        company: result.company,
        origin: result.origin,
        destination: result.destination,
        container_size: result?.container_size,
        shipping_amount: totalAmount,
        arrival_date_time: result?.eta,
        departure_date_time: result?.etd,
    }
    const handleFormSubmit = async (e) => {

        e.preventDefault();
        const origin_name = (result.origin.city ?? result.origin.port).substring(0, 10).trim() +
            ', ' + result.origin.country.code;
        const destination_name = (result.destination.city ?? result.destination.port).substring(0, 10).trim() +
            ', ' + result.destination.country.code;

        const updatedFormData = {...formData};
        updatedFormData.origin_name = origin_name;
        updatedFormData.destination_name = destination_name;
        updatedFormData.route_type = params.get('route_type');
        updatedFormData.booking_company = result.company.name;
        updatedFormData.eta = result.eta;
        updatedFormData.etd = result.etd;
        storeRequestQuoteData(updatedFormData)
            .then((res) => {
                if (res.data.status === "success") {
                    // setIsModalOpen(false);
                    setFormData({
                        name: result.user_details ? `${result?.user_details?.first_name} ${result?.user_details?.last_name}` : null,
                        company: result.user_details?.company ? `${result?.user_details?.company?.name}` : null,
                        phone: result.user_details ? `${result?.user_details?.phone_number}` : null,
                        email: result.user_details ? `${result?.user_details?.email}` : null,
                        description: '',
                    });

                    setIsFormSubmitted(true); // Show the thank you message
                } else {
                    console.error('Form submission failed');
                    alert(res.data.message);
                }
            })
            .catch((error) => {
                console.error('An error occurred', error);
                alert('An error occurred', error);
            })
            .finally(() => {

            });
    };

    const handleInputChange = (e) => {
        const {name, value} = e.target;
        setFormData((prevData) => ({
            ...prevData,
            [name]: value,
        }));
    };

    const updatePriceBreakDown = (data, isChecked) => {

        const {name, amount} = data;

        setPriceBreakDown((prevData) => {
            const updatedData = {
                ...prevData,
                [name]: {
                    value: amount,
                    isChecked: isChecked,
                },
            };
            console.log(updatedData); // Log the updated data
            return updatedData; // Return the updated data to update the state
        });
    };


    if (parseInt(params.get('route_type')) === constants.ROUTE_TYPE_LAND) {
        // const origin_code = result.origin.code;
        const origin_name = (result.origin.city ?? result.origin.port).substring(0, 10).trim() +
            ', ' + result.origin.country.code;
        // const destination_code = result.destination.code;
        const destination_name = (result.destination.city ?? result.destination.port).substring(0, 10).trim() +
            ', ' + result.destination.country.code;
        const tt = result?.tt;
        const valid_till = result?.valid_till ? dayjs(result?.valid_till).format('DD/MM/YYYY') : '';
        const truck_type = result?.truck_type;
        const axle = result?.axle;
        // const max_load_in_ton = result?.max_load_in_ton;
        // const detention_charges_per_hour = result?.detention_charges_per_hour;

        return <div>
            <div className="shadow-box small-box mb-5">
                <div className="search-result-box">
                    <header>
                        <div className="company">

                            <div className="icon land">
                                <svg
                                    id="truck-icon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width=""
                                    height=""
                                    viewBox="0 0 23.119 28.33"
                                >
                                    <path
                                        id="Path_739"
                                        data-name="Path 739"
                                        d="M120,318.485h8.381a.484.484,0,0,0,0-.968H120a.484.484,0,0,0,0,.968"
                                        transform="translate(-112.628 -299.227)"
                                        fill="#10b44c"
                                    />
                                    <path
                                        id="Path_740"
                                        data-name="Path 740"
                                        d="M128.377,352.007H120a.484.484,0,0,0,0,.968h8.381a.484.484,0,0,0,0-.968"
                                        transform="translate(-112.628 -331.73)"
                                        fill="#10b44c"
                                    />
                                    <path
                                        id="Path_741"
                                        data-name="Path 741"
                                        d="M22.977,11.951a.484.484,0,0,0-.343-.141H20.656V8.635a1.581,1.581,0,0,0-.066-.448.481.481,0,0,0,.065-.242V.484A.484.484,0,0,0,20.172,0H2.946a.484.484,0,0,0-.484.484V7.945a.481.481,0,0,0,.066.243,1.582,1.582,0,0,0-.066.447V11.81H.484A.484.484,0,0,0,0,12.294V16.67a.484.484,0,0,0,.484.484H2.462v5.482a.486.486,0,0,0-.013.111h0v1.761a1.431,1.431,0,0,0,1.232,1.416V27.24A1.091,1.091,0,0,0,4.77,28.33H7.84A1.091,1.091,0,0,0,8.93,27.24V25.915l5.8-.1V27.24a1.091,1.091,0,0,0,1.089,1.09h3.07a1.091,1.091,0,0,0,1.089-1.09V25.72h.016a1.428,1.428,0,0,0,.678-1.21V22.748a.482.482,0,0,0-.014-.113v-5.48h1.979a.484.484,0,0,0,.484-.484V12.294a.484.484,0,0,0-.142-.343M2.462,16.186H.968V12.778H2.462Zm.968.8H19.688v5.282H3.43ZM19.688,8.635V9.85H3.43V8.635a.613.613,0,0,1,.613-.611H19.075a.613.613,0,0,1,.613.611M3.43,10.817H19.688v5.2H3.43ZM19.688.968V7.18a1.58,1.58,0,0,0-.613-.124H4.043a1.581,1.581,0,0,0-.613.124V.968ZM3.417,24.509V23.232H19.7v1.277a.461.461,0,0,1-.231.4.48.48,0,0,0-.2.061c-.011,0-.021,0-.032,0H3.879a.463.463,0,0,1-.462-.462M7.962,27.24a.121.121,0,0,1-.122.122H4.77a.121.121,0,0,1-.122-.122v-1.3H7.562l.4-.007Zm11.047,0a.121.121,0,0,1-.122.122h-3.07a.121.121,0,0,1-.122-.122V25.8l3.314-.059Zm3.142-11.053H20.656V12.778h1.5Z"
                                        fill="#10b44c"
                                    />
                                </svg>
                            </div>
                            <h4 className="name">
                                {result.company.name}
                            </h4>
                        </div>

                        <div className="estimate-date">
                            <div>
                                <div className="icon">
                                    <img src="/images/info-icon.svg" alt=""/>
                                </div>
                                <div className="name">
                                    <strong>Truck Type</strong> {truck_type.display_label}
                                </div>
                            </div>

                            {/* <div>
                                <div className="icon">
                                    <img src="/images/info-icon.svg" alt=""/>
                                </div>
                                <div className="name">
                                    <strong>Axle</strong> { axle === 0 ? 'None' : axle }
                                </div>
                            </div> */}

                            <div>
                                <div className="icon">
                                    <img src="/images/info-icon.svg" alt=""/>
                                </div>
                                <div className="name">
                                    <strong>TT</strong> {tt} Days
                                </div>
                            </div>

                            <div>
                                <div className="name">
                                    {valid_till ? <> VALID <strong>{valid_till}</strong></> : ''}
                                </div>
                            </div>

                        </div>

                        {/* <div className="estimate-date">
                            <div>
                                <div className="icon">
                                    <img src="/images/info-icon.svg" alt=""/>
                                </div>
                                <div className="name">
                                    <strong>TT</strong> { tt } Days
                                </div>
                            </div>
                            <div>
                                <div className="name">
                                    {max_load_in_ton ? <> Max Load <strong>{ max_load_in_ton } Tons</strong></> : '' }
                                </div>
                            </div>
                        </div> */}

                        {/* <div className="estimate-date">
                            <div>
                                <div className="name">
                                    {valid_till ? <> VALID <strong>{ valid_till }</strong></> : '' }
                                </div>
                            </div>
                            <div>
                                <div className="name">
                                    {detention_charges_per_hour ? <> Detention Charges <strong>${ detention_charges_per_hour.toFixed(2) }/hr</strong></> : '' }
                                </div>
                            </div>
                        </div> */}

                    </header>

                    <footer>
                        <div className="tracking">
                            <div className="track land">
                                <div className="text">{origin_name}</div>
                                <div className="circle"></div>
                                <div className="icon">
                                    <img src="/images/svg/truck-icon.svg" alt=""/>
                                </div>
                            </div>
                            {/* <div className="track">
                                <div className="text">{ origin_code }</div>
                                <div className="circle"></div>
                                <div className="icon">
                                    <img src="/images/svg/ship-icon.svg" alt=""/>
                                </div>
                            </div>
                            <div className="track">
                                <div className="text">{ destination_code }</div>
                                <div className="circle"></div>
                                <div className="icon">
                                    <img src="/images/svg/truck-icon.svg" alt=""/>
                                </div>
                            </div> */}
                            <div className="track">
                                <div
                                    className="text">{destination_name}</div>
                                <div className="circle"></div>
                            </div>
                            {/* <ol>
                    <li>{getLocationName(result?.facilities?.collectionOrigin)}</li>
                    {result.transportLegs.slice(1).map((transportLeg, index) => {
                        return (<li key={`transport-leg-${index}`}>{getLocationName(transportLeg?.facilities?.startLocation)}</li>)
                    })}
                    <li>{getLocationName(result?.facilities?.deliveryDestination)}</li>
                </ol> */}
                        </div>

                        <div className="price">
                            {/* {result.price_amount ? ( */}
                            {/* <>
                                    <h4 className="amount">
                                        {currencyFormatter(result.price_amount)}
                                    </h4>
                                    <BookNowButton placement={PLACEMENT_MAIN_RESULT} data={data} />
                                </> */}
                            {/* ) : ( */}
                            <>
                                <button onClick={showModal} className="book-button">
                                    Get Quote
                                </button>

                                <Modal open={isModalOpen} onCancel={handleCancel} footer={null} width={640}>
                                    <h2 className="text-xl font-bold mb-4 pb-4 border-b border-gray-300">Quick
                                        Request</h2>
                                    {isFormSubmitted ? ( // If form is submitted, show thank you message
                                        <div>
                                            <h2 className="text-xl font-bold mb-4 pb-4 border-b border-gray-300">Thank
                                                You</h2>
                                            <p>Your request has been submitted successfully.</p>
                                        </div>
                                    ) : (
                                        <form className="default-form" onSubmit={handleFormSubmit}>
                                            <div className="grid grid-cols-2 gap-6">
                                                <div className="form-field">
                                                    <label className="form-label">Origin</label>
                                                    <input type="text" className="form-input small-input w-full"
                                                           value={origin_name}/>
                                                </div>

                                                <div className="form-field">
                                                    <label className="form-label">Destination</label>
                                                    <input type="text" className="form-input small-input w-full"
                                                           value={destination_name}/>
                                                </div>
                                                <div className="form-field">
                                                    <label className="form-label">Full Name</label>
                                                    <input
                                                        type="text"
                                                        className="form-input small-input w-full"
                                                        name="name"
                                                        required
                                                        value={formData.name}
                                                        onChange={handleInputChange}
                                                    />
                                                </div>

                                                <div className="form-field">
                                                    <label className="form-label">Company</label>
                                                    <input
                                                        type="text"
                                                        className="form-input small-input w-full"
                                                        name="company"
                                                        required
                                                        value={formData.company}
                                                        onChange={handleInputChange}
                                                    />
                                                </div>

                                                <div className="form-field">
                                                    <label className="form-label">Phone</label>
                                                    <input
                                                        type="text"
                                                        className="form-input small-input w-full"
                                                        name="phone"
                                                        required
                                                        value={formData.phone}
                                                        onChange={handleInputChange}
                                                    />
                                                </div>

                                                <div className="form-field">
                                                    <label className="form-label">Email</label>
                                                    <input
                                                        type="email"
                                                        className="form-input small-input w-full"
                                                        name="email"
                                                        required
                                                        value={formData.email}
                                                        onChange={handleInputChange}
                                                    />
                                                </div>
                                            </div>

                                            <div className="form-field mt-6">
                                                <label className="form-label">Description</label>
                                                <textarea
                                                    type="text"
                                                    className="form-input small-input w-full h-[120px] resize-none"
                                                    name="description"
                                                    required
                                                    value={formData.description}
                                                    onChange={handleInputChange}
                                                ></textarea>
                                            </div>

                                            <div className="form-field mt-6 text-right">
                                                <button className="default-button-v2 small-button">
                                                    <span>Submit</span>
                                                </button>
                                            </div>
                                        </form>)}
                                </Modal>
                            </>
                            {/* )} */}
                        </div>
                    </footer>

                    <ShippingDetails price_details={result.price_details} company_id={result.company.id}/>
                </div>
            </div>
        </div>
    } else {
        const arrival_date_time = dayjs(result?.eta).format('Do MMMM');
        const departure_date_time = dayjs(result?.etd).format('Do MMMM');
        const pickup_name = result?.pickup_name;
        const origin_code = result?.origin_code;
        const destination_code = result?.destination_code;
        const delivery_name = result?.delivery_name;
        const tt = result?.tt;
        const valid_till = result?.valid_till ? dayjs(result?.valid_till).format('DD/MM/YYYY') : '';

        return <div key={`search-result-card-${result.company.id}-${result.index}`}>
            <div className="shadow-box small-box mb-5">
                <div className="search-result-box">
                    <header>
                        <div className="company">
                            <div className="icon">
                                <img src="/images/ship-icon.svg" alt=""/>
                            </div>
                            <h4 className="name">
                                {result.company.name}
                            </h4>
                        </div>

                        <div className="estimate-date">
                            <div>
                                <div className="icon">
                                    <img src="/images/info-icon.svg" alt=""/>
                                </div>
                                <div className="name">
                                    <strong>+ETD</strong> {departure_date_time}
                                </div>
                            </div>

                            <div>
                                <div className="icon">
                                    <img src="/images/info-icon.svg" alt=""/>
                                </div>
                                <div className="name">
                                    <strong>+ETA</strong> {arrival_date_time}
                                </div>
                            </div>
                        </div>

                        <div className="estimate-date">
                            <div>
                                <div className="icon">
                                    <img src="/images/info-icon.svg" alt=""/>
                                </div>
                                <div className="name">
                                    <strong>TT</strong> {tt} Days
                                </div>
                            </div>

                            {/*<div>*/}
                            {/*    <div className="icon">*/}
                            {/*        <img src="/images/info-icon.svg" alt="" />*/}
                            {/*    </div>*/}
                            {/*    <div className="name">*/}
                            {/*        <strong>FT</strong> 7 days*/}
                            {/*    </div>*/}
                            {/*</div>*/}
                        </div>

                        <div className="estimate-date">
                            <div>
                                <div className="name">
                                    {valid_till ? <> VALID <strong>{valid_till}</strong></> : ''}
                                </div>
                            </div>
                        </div>

                    </header>

                    <footer>
                        <div className="tracking">
                            <div className="track">
                                <div
                                    className="text">{pickup_name}</div>
                                <div className="circle"></div>
                                <div className="icon">
                                    <img src="/images/svg/truck-icon.svg" alt=""/>
                                </div>
                            </div>
                            <div className="track">
                                <div className="text">{origin_code}</div>
                                <div className="circle"></div>
                                <div className="icon">
                                    <img src="/images/svg/ship-icon.svg" alt=""/>
                                </div>
                            </div>
                            <div className="track">
                                <div className="text">{destination_code}</div>
                                <div className="circle"></div>
                                <div className="icon">
                                    <img src="/images/svg/truck-icon.svg" alt=""/>
                                </div>
                            </div>
                            <div className="track">
                                <div
                                    className="text">{delivery_name}</div>
                                <div className="circle"></div>
                            </div>
                            {/* <ol>
                    <li>{getLocationName(result?.facilities?.collectionOrigin)}</li>
                    {result.transportLegs.slice(1).map((transportLeg, index) => {
                        return (<li key={`transport-leg-${index}`}>{getLocationName(transportLeg?.facilities?.startLocation)}</li>)
                    })}
                    <li>{getLocationName(result?.facilities?.deliveryDestination)}</li>
                </ol> */}
                        </div>

                        <div className="price">
                            {totalAmount ? (
                                <>
                                    <h4 className="amount">
                                        {currencyFormatter(totalAmount)}
                                    </h4>
                                    <BookNowButton placement={PLACEMENT_MAIN_RESULT} data={data} priceBreakDown={priceBreakDown} />
                                </>
                            ) : (
                                <>
                                    <button onClick={showModal} className="book-button">
                                        Get Quote
                                    </button>

                                    <Modal open={isModalOpen} onCancel={handleCancel} footer={null} width={640}>
                                        <h2 className="text-xl font-bold mb-4 pb-4 border-b border-gray-300">Quick
                                            Request</h2>
                                        {isFormSubmitted ? ( // If form is submitted, show thank you message
                                            <div>
                                                <h2 className="text-xl font-bold mb-4 pb-4 border-b border-gray-300">Thank
                                                    You</h2>
                                                <p>Your request has been submitted successfully.</p>
                                            </div>
                                        ) : (
                                            <form className="default-form" onSubmit={handleFormSubmit}>

                                                <div className="grid grid-cols-2 gap-6">
                                                    <div className="form-field">
                                                        <label className="form-label">Origin</label>
                                                        <input type="text" className="form-input small-input w-full"
                                                               value={pickup_name}/>
                                                    </div>

                                                    <div className="form-field">
                                                        <label className="form-label">Destination</label>
                                                        <input type="text" className="form-input small-input w-full"
                                                               value={delivery_name}/>
                                                    </div>
                                                    <div className="form-field">
                                                        <label className="form-label">Full Name</label>
                                                        <input
                                                            type="text"
                                                            className="form-input small-input w-full"
                                                            name="name"
                                                            required
                                                            value={formData.name}
                                                            onChange={handleInputChange}
                                                        />
                                                    </div>

                                                    <div className="form-field">
                                                        <label className="form-label">Company</label>
                                                        <input
                                                            type="text"
                                                            className="form-input small-input w-full"
                                                            name="company"
                                                            required
                                                            value={formData.company}
                                                            onChange={handleInputChange}
                                                        />
                                                    </div>

                                                    <div className="form-field">
                                                        <label className="form-label">Phone</label>
                                                        <input
                                                            type="text"
                                                            className="form-input small-input w-full"
                                                            name="phone"
                                                            required
                                                            value={formData.phone}
                                                            onChange={handleInputChange}
                                                        />
                                                    </div>

                                                    <div className="form-field">
                                                        <label className="form-label">Email</label>
                                                        <input
                                                            type="email"
                                                            className="form-input small-input w-full"
                                                            name="email"
                                                            required
                                                            value={formData.email}
                                                            onChange={handleInputChange}
                                                        />
                                                    </div>
                                                </div>

                                                <div className="form-field mt-6">
                                                    <label className="form-label">Description</label>
                                                    <textarea
                                                        type="text"
                                                        className="form-input small-input w-full h-[120px] resize-none"
                                                        name="description"
                                                        required
                                                        value={formData.description}
                                                        onChange={handleInputChange}
                                                    ></textarea>
                                                </div>


                                                <div className="form-field mt-6 text-right">
                                                    <button className="default-button-v2 small-button">
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </form>
                                        )}
                                    </Modal>
                                </>
                            )}
                        </div>
                    </footer>

                    <ShippingDetails updatePriceBreakDown={updatePriceBreakDown}
                                     setTotalAmount={setTotalAmount}
                                     uid={result.index}
                                     price_amount={result.price_amount}
                                     price_details={result.price_details}
                                     company_id={result.company.id}/>
                </div>
            </div>
        </div>
    }

}

export default SearchResultCard;
