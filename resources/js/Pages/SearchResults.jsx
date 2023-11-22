import {Head, usePage} from '@inertiajs/react';
import Checkbox from '@/Components/Checkbox';
import Radiobox from '@/Components/Radiobox';
import {useEffect, useState} from "react";
import dayjs from "dayjs";
import advancedFormat from 'dayjs/plugin/advancedFormat';
import SearchbarFormInner from "@/Components/SearchbarFormInner";
import SearchResultCard from '@/Components/SearchResultCard';
import {Tabs} from 'antd';
import {currencyFormatter} from "../../views/helpers/helpers";
import BookNowButton, {PLACEMENT_SIDEBAR_RESULT} from "@/Components/BookNowButton";

dayjs.extend(advancedFormat);

const SORT_BY_ETD = 1;
const SORT_BY_FASTEST = 2;
const SORT_BY_CHEAPEST = 3;

const ResultPlaceholder = () =>
    <div className="shadow-box small-box mb-5 animate-pulse">
        <div className="search-result-box">
            <header>
                <div className="company">
                    <div className="h-[40px] w-[40px] bg-gray-200 rounded-md"></div>
                    <div className="h-[24px] w-[70px] bg-gray-200 rounded-md"></div>
                </div>

                <div className="estimate-date">
                    <div>
                        <div className="icon">
                            <img src="/images/info-icon.svg" alt=""/>
                        </div>
                        <div className="h-[12px] w-[80px] bg-gray-200"></div>
                    </div>

                    <div>
                        <div className="icon">
                            <img src="/images/info-icon.svg" alt=""/>
                        </div>
                        <div className="h-[12px] w-[80px] bg-gray-200"></div>
                    </div>
                </div>

                <div className="estimate-date">
                    <div>
                        <div className="icon">
                            <img src="/images/info-icon.svg" alt=""/>
                        </div>
                        <div className="h-[12px] w-[80px] bg-gray-200"></div>
                    </div>
                </div>

                <div className="estimate-date">
                    <div>
                        <div className="h-[12px] w-[80px] bg-gray-200"></div>
                    </div>
                </div>

            </header>

            <footer>
                <div className="tracking">
                    <div className="track">
                        <div className="text">
                            <div className="h-[12px] w-[80px] bg-gray-200"></div>
                        </div>
                        <div className="circle"></div>
                        <div className="icon">
                            <img src="/images/svg/truck-icon.svg" alt=""/>
                        </div>
                    </div>
                    <div className="track">
                        <div className="text">
                            <div className="h-[12px] w-[40px] bg-gray-200"></div>
                        </div>
                        <div className="circle"></div>
                        <div className="icon">
                            <img src="/images/svg/ship-icon.svg" alt=""/>
                        </div>
                    </div>
                    <div className="track">
                        <div className="text">
                            <div className="h-[12px] w-[40px] bg-gray-200"></div>
                        </div>
                        <div className="circle"></div>
                        <div className="icon">
                            <img src="/images/svg/truck-icon.svg" alt=""/>
                        </div>
                    </div>
                    <div className="track">
                        <div
                            className="text">
                            <div className="h-[12px] w-[80px] bg-gray-200"></div>
                        </div>
                        <div className="circle"></div>
                    </div>
                </div>

                <div className="price">
                    <h4 className="amount">
                        <div className="h-[32px] w-[100px] bg-gray-200 mb-1"></div>
                    </h4>
                    <div className="h-[36px] w-[110px] bg-gray-200 secondary-bg rounded-md"></div>
                </div>
            </footer>
        </div>
    </div>;

const SearchResults = ({
                           searched_origin, searched_destination, searched_departure_date,
                           searched_container_size, searched_truck_type, searched_route_type,
                           hot_deals_collection, container_sizes, truck_types, user_details
                       }) => {
    const [results, setResults] = useState([]);
    const [processedResult, setProcessedResult] = useState([]);
    const [prices, setPrices] = useState([]);
    const [cmaDepartureDates, setCmaDepartureDates] = useState(false);
    const [isScheduleLoaded, setIsScheduleLoaded] = useState(false);
    const [isLoading, setIsLoading] = useState(true);
    const [shippingLines, setShippingLines] = useState([]);
    const [axles, setAxles] = useState([]);
    const [sortBy, setSortBy] = useState(SORT_BY_ETD);
    const [filters, setFilters] = useState({
        container_size: searched_container_size?.value,
        truck_type: searched_truck_type?.id,
        shipping_lines: [], axles: []
    });
    const default_axles = [
        {id: "1", label: "None", value: 0},
        {id: "2", label: "2 Axle", value: 2},
        {id: "3", label: "3 Axle", value: 3},
        {id: "4", label: "4 Axle", value: 4},
    ]
    const {constants} = usePage().props;

    useEffect(() => {
        Promise.allSettled([
            new Promise((resolve, reject,) => getSchedule(resolve, reject, 'maersk')),
            new Promise((resolve, reject,) => getSchedule(resolve, reject, 'cma')),
            new Promise((resolve, reject,) => getSchedule(resolve, reject, 'hapag')),
            new Promise((resolve, reject,) => getSchedule(resolve, reject, 'msc')),
            new Promise((resolve, reject,) => getSchedule(resolve, reject, 'custom')),
        ]).then((_results) => {
            let results_arr = [];
            _results.forEach(_result => {
                if (_result.status === 'fulfilled') {
                    results_arr = results_arr.concat(_result.value);
                }
            });
            setResults(results_arr)
            setIsScheduleLoaded(true);
        }).catch((reason) => {
            console.log(reason)
        });

    }, []);

    const handleFiltersShippingLineChange = (shippingLineId) => {
        const shipping_lines = filters.shipping_lines.includes(shippingLineId)
            ? filters.shipping_lines.filter(i => i !== shippingLineId) : [...filters.shipping_lines, shippingLineId];
        setFilters({...filters, shipping_lines})
    }

    const handleFiltersAxleChange = (axleValue) => {
        const axles = filters.axles.includes(axleValue)
            ? filters.axles.filter(i => i !== axleValue) : [...filters.axles, axleValue];
        setFilters({...filters, axles})
    }

    const handleFiltersContainerSizeChange = (containerSize) => {
        setFilters({...filters, container_size: containerSize});

        handleSearchbarFormCallback({
            origin: searched_origin?.code,
            destination: searched_destination?.code,
            container_size: containerSize,
            departure_date: searched_departure_date,
            route_type: searched_route_type
        })
    }

    const handleFiltersTruckTypeChange = (truckType) => {
        setFilters({...filters, truck_type: truckType});

        handleSearchbarFormCallback({
            origin: searched_origin?.code,
            destination: searched_destination?.code,
            truck_type: truckType,
            departure_date: searched_departure_date,
            route_type: searched_route_type
        })
    }

    useEffect(() => {
        if (isScheduleLoaded) {
            Promise.allSettled([
                new Promise((resolve, reject,) => getPrices(resolve, reject, 'maersk')),
                new Promise((resolve, reject,) => getPrices(resolve, reject, 'cma')),
            ]).then((_prices) => {
                console.log(_prices);
                let prices_arr = [];
                _prices.forEach(_price => {
                    if (_price.status === 'fulfilled') {
                        prices_arr = {...prices_arr, ..._price.value};
                    }
                });
                setPrices(prices_arr)
                setIsLoading(false);
            }).catch((reason) => {
                console.log(reason)
            });
        }
    }, [isScheduleLoaded]);

    const getSchedule = (resolve, reject, api) => {
        const query = new URLSearchParams({
            origin_id: searched_origin.id,
            origin_code: searched_origin.code,
            origin_name: (searched_origin.city ?? searched_origin.port) + ', ' + searched_origin.country.code,
            origin_geolocation_id: searched_origin.maersk_geo_id,
            destination_id: searched_destination.id,
            destination_code: searched_destination.code,
            destination_name: (searched_destination.city ?? searched_destination.port) + ', ' + searched_destination.country.code,
            destination_geolocation_id: searched_destination.maersk_geo_id,
            container_size: searched_container_size?.value,
            truck_type: searched_truck_type?.id,
            departure_date: searched_departure_date,
            route_type: searched_route_type,
            api: api
        });

        const apiUrl = route('api.point-to-point-schedules') + '?' + query.toString();
        return fetch(apiUrl)
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    if (api === 'cma') {
                        let cma_departure_dates = [];
                        result.data.filter(data => data.company_id === constants.CMA_COMPANY_ID)
                            .forEach(data => {
                                cma_departure_dates.push(data.etd);
                            });

                        setCmaDepartureDates([...new Set(cma_departure_dates)]);
                    }

                    resolve(result.data);
                } else {
                    reject(`No response from ${api} API`);
                }
            });
    }

    useEffect(() => {
        let _shippingLines = {ids: [], data: []};
        let _axles = {values: [], data: []};
        results.map(result => {
            if (!_shippingLines.ids.includes(result.company_id)) {
                _shippingLines.ids.push(result.company_id);
                _shippingLines.data.push({"id": result.company_id, "name": result.company ?? result.company_name});
            }
            if (!_axles.values.includes(result.axle)) {
                let axleObj = default_axles.find(a => a.value === result.axle);
                if (axleObj) {
                    _axles.values.push(axleObj.value);
                    _axles.data.push(axleObj);
                }
            }
        });

        setShippingLines(_shippingLines.data);
        if (_axles.values.length > 0) {
            setAxles(_axles.data);
        }
        setFilters({...filters, shipping_lines: _shippingLines.ids, axles: _axles.values});

    }, [results]);

    const getPrices = (resolve, reject, api) => {
        const query = new URLSearchParams({
            origin: JSON.stringify({
                id: searched_origin.id,
                code: searched_origin.code,
                city: searched_origin.city,
                port: searched_origin.port,
                country: searched_origin.country.name,
                geolocation_id: searched_origin.maersk_geo_id,
            }),
            destination: JSON.stringify({
                id: searched_destination.id,
                code: searched_destination.code,
                city: searched_destination.city,
                port: searched_destination.port,
                country: searched_destination.country.name,
                geolocation_id: searched_destination.maersk_geo_id,
            }),
            container_size: JSON.stringify({
                value: searched_container_size?.value,
                label: searched_container_size?.display_label
            }),
            departure_date: searched_departure_date,
            cma_departure_dates: JSON.stringify(cmaDepartureDates),
            api: api
        });

        const apiUrl = route('api.point-to-point-prices') + '?' + query.toString();
        return fetch(apiUrl)
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    let res = {};
                    res[api] = result.data
                    resolve(res);
                } else {
                    reject(`No response from ${api} API`);
                }
            });
    }

    const filterOutResultsByDepartureDate = (result) => {
        return new dayjs(result.valid_till)
            .diff(new dayjs(searched_departure_date), 'd') >= 0;
    }

    useEffect(() => {
        let _results = [];
        if (!isLoading) {
            results//.filter((_result) => filterOutResultsByDepartureDate(_result))
                .forEach((_result, index) => {
                    if (_result?.company_id === constants.MAERSK_COMPANY_ID) {
                        _result.company = {
                            id: constants.MAERSK_COMPANY_ID,
                            name: 'Maersk',
                        }
                        _result.pickup_code = _result.origin_code;
                        _result.pickup_name = _result.origin_name;
                        _result.delivery_code = _result.destination_code;
                        _result.delivery_name = _result.destination_name;
                        _result.price_details = findPriceByVoyageForMaersk(_result?.voyage_number);
                    } else if (_result?.company_id === constants.CMA_COMPANY_ID) {
                        _result.company = {
                            id: constants.CMA_COMPANY_ID,
                            name: 'CMA CGM',
                        }
                        _result.pickup_code = _result.origin_code;
                        _result.pickup_name = _result.origin_name;
                        _result.delivery_code = _result.destination_code;
                        _result.delivery_name = _result.destination_name;
                        if (prices['cma'] && _result.etd) {
                            _result.price_details = prices['cma'].hasOwnProperty(_result.etd) ? prices['cma'][_result.etd] : {};
                            _result.price_amount = prices['cma'].hasOwnProperty(_result.etd)
                                ? parseFloat(prices['cma'][_result.etd]['total']) + 100 : 0;
                            // TODO: Later move 100+ expression to Shipping Details
                        }
                    } else if (_result?.company_id === constants.HAPAG_COMPANY_ID) {
                        _result.company = {
                            id: _result?.company_id,
                            name: _result?.company_name,
                        }

                        _result.price_amount = _result?.price_details?.TotalAmount;
                    } else if (_result?.company_id === constants.MSC_COMPANY_ID) {
                        _result.company = {
                            id: _result?.company_id,
                            name: _result?.company_name,
                        }
                    } else if (_result?.company_id) {
                        _result.company = {
                            id: _result?.company_id,
                            name: _result?.company_name,
                        }
                    }
                    _result.index = index;
                    _result.origin = searched_origin;
                    _result.destination = searched_destination;
                    _result.container_size = searched_container_size;
                    _result.user_details = user_details;

                    _results.push(_result);
                });

            let _processedResults = _results
                .filter(result => filters.shipping_lines.includes(result.company.id));

            if (parseInt(searched_route_type) === constants.ROUTE_TYPE_LAND) {
                _processedResults = _processedResults.filter(result => filters.axles.includes(result.axle));
            }

            if (sortBy === SORT_BY_ETD) {
                _processedResults = _processedResults?.sort((item1, item2) => {
                    return Date.parse(item1.etd) - Date.parse(item2.etd)
                });
            } else if (sortBy === SORT_BY_FASTEST) {
                _processedResults = _processedResults?.sort((item1, item2) => {
                    return item1.tt - item2.tt
                });
            } else if (sortBy === SORT_BY_CHEAPEST) {
                _processedResults = _processedResults?.filter((result) => result.price_amount > 0)
                    ?.sort((item1, item2) => {
                        return item1.price_amount - item2.price_amount
                    });
            }

            setProcessedResult(_processedResults);
        }
    }, [prices, filters.shipping_lines, filters.axles, sortBy])

    const handleSearchbarFormCallback = (values) => {
        const query = new URLSearchParams(values);
        window.location = route('pages.searchresults') + '?' + query.toString();
    }

    const findPriceByVoyageForMaersk = (voyage_number) => {
        const found = prices['maersk']?.find(price => {
            return price.voyage_number === voyage_number;
        })

        return found ?? {};
    }

    return (
        <>
            <Head title="Search Results"/>

            <section className="max-w-screen-4xl mx-auto">
                <div className='default-container my-16'>
                    <h2 className="default-heading small-heading mb-2">
                        Search Results
                    </h2>

                    <div className="search-panel search-result">
                        <div className="inner-box">
                            <SearchbarFormInner callback={handleSearchbarFormCallback}
                                                origin={searched_origin}
                                                destination={searched_destination}
                                                departure_date={searched_departure_date}
                                                container_size={searched_container_size}
                                                truck_type={searched_truck_type}
                                                route_type={searched_route_type}
                            />
                        </div>
                    </div>

                    <div className="flex xl:flex-row flex-col gap-6">
                        <div className="xl:w-3/12">
                            <div className="shadow-box small-box sticky top-0">
                                <div className="filter-box">
                                    <h2 className="default-heading small-size mb-6">
                                        filter
                                    </h2>

                                    <form className="default-form">
                                        <div className="filter-container">
                                            <p className="title">
                                                {parseInt(searched_route_type) === constants.ROUTE_TYPE_SEA
                                                    ? 'type of container' : 'type of truck'}
                                            </p>
                                            {parseInt(searched_route_type) === constants.ROUTE_TYPE_SEA ?
                                                container_sizes.map(container_size =>
                                                    <div key={`container_size_radio_${container_size.id}`}
                                                         className='form-field radio-field'>
                                                        <Radiobox value={container_size.value}
                                                                  name="container_size"
                                                                  onChange={() => handleFiltersContainerSizeChange(container_size.value)}
                                                                  checked={container_size.value === filters.container_size}
                                                        />
                                                        <span className='text'>{container_size.display_label}</span>
                                                    </div>
                                                ) : truck_types.map(truck_type =>
                                                    <div key={`truck_type_radio_${truck_type.id}`}
                                                         className='form-field radio-field'>
                                                        <Radiobox value={truck_type.id}
                                                                  name="truck_type"
                                                                  onChange={() => handleFiltersTruckTypeChange(truck_type.id)}
                                                                  checked={truck_type.id === filters.truck_type}
                                                        />
                                                        <span className='text'>{truck_type.display_label}</span>
                                                    </div>)}
                                        </div>

                                        {parseInt(searched_route_type) === constants.ROUTE_TYPE_LAND
                                            ? (<div className="filter-container">
                                                <p className="title">
                                                    Type of Axle
                                                </p>
                                                {axles.map(axle =>
                                                    <div key={`axle-checkbox-${axle.id}`}
                                                         className='form-field checkbox-field'>
                                                        <Checkbox value={axle.value}
                                                                  name="axles[]"
                                                                  onChange={() => handleFiltersAxleChange(axle.value)}
                                                                  checked={filters.axles.includes(axle.value)}
                                                        />
                                                        <span className='text'>{axle.label}</span>
                                                    </div>
                                                )}
                                            </div>)
                                            : null}

                                        {/* <div className="filter-container">
                                            <p className="title">
                                                SERVICES
                                            </p>
                                            <div className='form-field checkbox-field'>
                                                <Checkbox value="" name="services" />
                                                <span className='text'>
                                                    FCL
                                                </span>
                                            </div>

                                            <div className='form-field checkbox-field'>
                                                <Checkbox value="" name="services" />
                                                <span className='text'>
                                                    LCL
                                                </span>
                                            </div>

                                            <div className='form-field checkbox-field'>
                                                <Checkbox value="" name="services" />
                                                <span className='text'>
                                                    Trucking
                                                </span>
                                            </div>

                                            <div className='form-field checkbox-field'>
                                                <Checkbox value="" name="services" />
                                                <span className='text'>
                                                    AirFreight
                                                </span>
                                            </div>

                                            <div className='form-field checkbox-field'>
                                                <Checkbox value="" name="services" />
                                                <span className='text'>
                                                    Custom Clearance
                                                </span>
                                            </div>

                                            <div className='form-field checkbox-field'>
                                                <Checkbox value="" name="services" />
                                                <span className='text'>
                                                    Surveyor Services
                                                </span>
                                            </div>
                                        </div> */}

                                        <div className="filter-container">
                                            <p className="title">
                                                SHIPPING LINE
                                            </p>
                                            {shippingLines.map((shippingLine, index) => {
                                                    return <div key={`shipping-line-${index}`}
                                                                className='form-field checkbox-field'>
                                                        <Checkbox value={shippingLine.id}
                                                                  name="shipping_lines[]"
                                                                  onChange={() => handleFiltersShippingLineChange(shippingLine.id)}
                                                                  checked={filters.shipping_lines.includes(shippingLine.id)}
                                                        />
                                                        <span className='text'>{shippingLine.name}</span>
                                                    </div>
                                                }
                                            )}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div className='xl:w-6/12'>
                            <div className="search-result-filters">
                                <div className="ant-tabs ant-tabs-top ">
                                    <div className="ant-tabs-nav">
                                        <div className="ant-tabs-nav-wrap">
                                            <ul className="ant-tabs-nav-list">
                                                <li key="tab-featured" onClick={() => setSortBy(SORT_BY_ETD)}
                                                    className={`ant-tabs-tab ${sortBy === SORT_BY_ETD ? "ant-tabs-tab-active" : ""}`}>
                                                    <div className="ant-tabs-tab-btn">Featured
                                                    </div>
                                                </li>
                                                <li key="tab-fastest" onClick={() => setSortBy(SORT_BY_FASTEST)}
                                                    className={`ant-tabs-tab ${sortBy === SORT_BY_FASTEST ? "ant-tabs-tab-active" : ""}`}>
                                                    <div className="ant-tabs-tab-btn">Fastest
                                                    </div>
                                                </li>
                                                <li key="tab-cheapest" onClick={() => setSortBy(SORT_BY_CHEAPEST)}
                                                    className={`ant-tabs-tab ${sortBy === SORT_BY_CHEAPEST ? "ant-tabs-tab-active" : ""}`}>
                                                    <div className="ant-tabs-tab-btn">Cheapest
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div className="ant-tabs-nav-operations ant-tabs-nav-operations-hidden">
                                            <button type="button" className="ant-tabs-nav-more"></button>
                                        </div>
                                    </div>
                                    <div className="ant-tabs-content-holder">
                                        <div className="ant-tabs-content ant-tabs-content-top">
                                            <div role="tabpanel" className="ant-tabs-tabpane ant-tabs-tabpane-active">
                                                {/* Match results and prices to show not found if Price is not added*/}
                                                {isLoading ?
                                                    Array.from(Array(3)).map((x, i) =>
                                                        <ResultPlaceholder key={`result-placeholder-${(i + 1)}`}/>
                                                    )
                                                    : results.length > 0 ?
                                                        processedResult?.map((result, index) => {
                                                            return (<SearchResultCard
                                                                result={result}
                                                                key={`search-result-card-${result.index}-${index}`}
                                                            />)
                                                        })
                                                        : (<div className="xl:w-6/12">
                                                            <h2 className="default-heading small-size mb-6">
                                                                Results Not Found...
                                                            </h2>
                                                        </div>)
                                                }
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="xl:w-3/12">
                            <div className="shadow-box small-box sticky top-0">
                                <div className="filter-box">
                                    <h2 className="default-heading small-size mb-6">
                                        Hot DEALS
                                    </h2>
                                    {hot_deals_collection?.data?.map(deal => {
                                        const data = {
                                            company: deal.company,
                                            origin: deal.origin,
                                            destination: deal.destination,
                                            container_size: deal.container_size,
                                            shipping_amount: deal.price_amount,
                                            arrival_date_time: deal?.eta,
                                            departure_date_time: deal?.etd,
                                        }
                                        return <div className="deal-box" key={deal.id}>
                                            <div className="inner-box">
                                                <p className="container-size">
                                                    <span>container</span>
                                                    {deal.container_size?.display_label}
                                                </p>

                                                <p className="pricing">
                                                    <span>Starting From</span>
                                                    {currencyFormatter(deal?.price_amount)}
                                                </p>

                                                <p className="country">
                                                    <span>Origin</span>
                                                    {(deal?.origin?.city ?? deal?.origin?.port) + ', ' + deal?.origin?.country?.code}
                                                </p>

                                                <p className="country">
                                                    <span>Destination</span>
                                                    {(deal?.destination?.city ?? deal?.destination?.port) + ', ' + deal?.destination?.country?.code}
                                                </p>
                                            </div>

                                            <div className="flex justify-end mt-8">
                                                <BookNowButton placement={PLACEMENT_SIDEBAR_RESULT} data={data}/>
                                            </div>
                                        </div>
                                    })}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </>
    )
}

export default SearchResults;
