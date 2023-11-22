import * as React from "react";
import { useState, useEffect } from "react";
import { AutoComplete, Select, Button, Form, DatePicker } from "antd";
import dayjs from "dayjs";
import {getContainerSizes, getTruckTypes} from "../../views/network/network";
import {usePage} from "@inertiajs/react";
// eslint-disable-next-line arrow-body-style
const disabledDate = (current) => {
    // Can not select days before today and today
    return current && current < dayjs().endOf("day");
};

const SearchbarForm = (props) => {
    const { constants } = usePage().props;

    const [origin, setOrigin] = useState(props?.origin?.code);
    const [originList, setOriginList] = useState([]);
    const [destination, setDestination] = useState(props?.destination?.code);
    const [destinationList, setDestinationList] = useState([]);
    const [containerSizes, setContainerSizes] = useState([]);
    const [truckTypes, setTruckTypes] = useState([]);
    const [routeType, setRouteType] = useState(props.route_type ?? constants.ROUTE_TYPE_SEA);
    const [searchForm] = Form.useForm();

    const TYPE_ORIGIN = "origin";
    const TYPE_DESTINATION = "destination";

    useEffect(() => {
        getContainerSizes()
            .then((res) => {
                let sizes = res.data?.container_sizes;

                let sizes_arr = sizes.map(function (size) {
                    return { value: size.value, label: size.display_label };
                });
                setContainerSizes(sizes_arr);
            })
            .catch((err) => {
                console.log(err);
            });

        getTruckTypes()
            .then((res) => {
                const truck_types = res.data?.truck_types ?? [];
                const truck_types_arr = truck_types.map(function (truckType) {
                    return { "value": truckType.id, "label": truckType.display_label, }
                });
                setTruckTypes(truck_types_arr);
            })
            .catch((err) => {
                console.log(err);
            });

        if (props?.origin) {
            getCitySuggestions(props?.origin.code, TYPE_ORIGIN);
        }
        if (props?.destination) {
            getCitySuggestions(props?.destination.code, TYPE_DESTINATION);
        }

        searchForm.setFieldsValue({
            origin_port: props?.origin?.fullname,
            destination_port: props?.destination?.fullname,
            departure_date: props?.departure_date
                ? dayjs(props?.departure_date, "YYYY-MM-DD")
                : null,
            container_size: props?.container_size?.value,
            truck_type: props?.truck_type?.id,
        });
    }, []);

    const mapCityList = (data) => {
        return data.map((loc) => {
            return { UNLocCode: loc.code, value: loc.fullname };
        });
    };

    function getCitySuggestions(searchString, type = TYPE_ORIGIN) {
        if (searchString) {
            fetch(route("api.get-locations-by-city", [searchString]))
                .then((response) => response.json())
                .then((result) => {
                    if (result.success) {
                        let list = mapCityList(result.data);
                        if (type === TYPE_ORIGIN) {
                            setOriginList(list);
                        } else {
                            setDestinationList(list);
                        }
                    } else {
                        if (type === TYPE_ORIGIN) {
                            setOriginList([]);
                        } else {
                            setDestinationList([]);
                        }
                    }
                });
        }
    }

    const handleSearchForm = () => {
        searchForm.validateFields().then((values) => {
            const data = {
                origin: origin,
                destination: destination,
                departure_date: values.departure_date.format('YYYY-MM-DD'),
                route_type: routeType,
            };
            if(values?.container_size) {
                data.container_size = values.container_size;
            }
            if(values?.truck_type) {
                data.truck_type = values.truck_type;
            }

            props.callback(data);
        });
    };

    const [open, setOpen] = React.useState(false);

    const handleOpen = () => {
        setOpen(!open);
    };

    return (
        <Form
            name={"search-form"}
            autoComplete="off"
            form={searchForm}
            onFinish={handleSearchForm}
            className="default-form"
        >
            <div className="search-form mt-4">
                <div className="2xl:w-1/6 lg:w-auto w-full">
                    <div className="form-field">
                        {/* <label className="form-label small-label uppercase primary-font-medium">transportation by</label> */}
                        <label className="form-label small-label uppercase primary-font-medium">
                            TRANSPORTATION BY
                        </label>
                        <div className="transportation-checkbox">
                            <div className="option">
                                <input type="radio" name="route_type" value={constants.ROUTE_TYPE_SEA}
                                       checked={parseInt(routeType) === constants.ROUTE_TYPE_SEA}
                                       onClick={() => setRouteType(constants.ROUTE_TYPE_SEA)}
                                />
                                <div className="content sea">
                                    <i className="icon">
                                        <svg
                                            id="ship"
                                            xmlns="http://www.w3.org/2000/svg"
                                            width=""
                                            height=""
                                            viewBox="0 0 15.851 18.286"
                                        >
                                            <path
                                                id="Path_730"
                                                data-name="Path 730"
                                                d="M12.228,455.414a2.088,2.088,0,0,1-1.317-.478l-.01-.008a1.261,1.261,0,0,0-1.649,0,2.054,2.054,0,0,1-2.653,0,1.261,1.261,0,0,0-1.649,0,2.054,2.054,0,0,1-2.653,0,1.261,1.261,0,0,0-1.65,0,.4.4,0,0,1-.5-.614,2.051,2.051,0,0,1,2.652,0,1.262,1.262,0,0,0,1.65,0,2.053,2.053,0,0,1,2.653,0,1.262,1.262,0,0,0,1.65,0,2.051,2.051,0,0,1,2.643-.008l.01.008a1.261,1.261,0,0,0,1.649,0,2.053,2.053,0,0,1,2.653,0,.4.4,0,1,1-.5.614,1.261,1.261,0,0,0-1.65,0,2.089,2.089,0,0,1-1.326.486Z"
                                                transform="translate(0 -437.128)"
                                                fill="#423460"
                                            />
                                            <path
                                                id="Path_731"
                                                data-name="Path 731"
                                                d="M33,206.493a2.085,2.085,0,0,1-1.329-.486,1.286,1.286,0,0,0-1.65,0,2.06,2.06,0,0,1-2.652,0,1.274,1.274,0,0,0-1.646,0,2.083,2.083,0,0,1-1.33.487c-.015,0-.06,0-.075-.005a.371.371,0,0,1-.356-.27l-2.378-7.129a.4.4,0,0,1,.207-.484l6.7-3.17a.394.394,0,0,1,.337,0L35.6,198.6a.4.4,0,0,1,.208.484l-2.378,7.129a.4.4,0,0,1-.376.271.314.314,0,0,1-.056,0Zm-6.455-1.585a2.062,2.062,0,0,1,1.327.487,1.266,1.266,0,0,0,1.649,0,2.1,2.1,0,0,1,2.655,0,1.338,1.338,0,0,0,.6.285l2.17-6.507-6.28-2.942-6.219,2.94,2.171,6.509a1.343,1.343,0,0,0,.6-.287,2.062,2.062,0,0,1,1.325-.486Z"
                                                transform="translate(-20.774 -188.207)"
                                                fill="#423460"
                                            />
                                            <path
                                                id="Path_732"
                                                data-name="Path 732"
                                                d="M85.314,62.1a.394.394,0,0,1-.168-.037L80.528,59.9l-4.555,2.155a.4.4,0,0,1-.566-.358V57.421a.4.4,0,0,1,.4-.4h1.189V54.251a.4.4,0,0,1,.4-.4h6.34a.4.4,0,0,1,.4.4v2.774h1.189a.4.4,0,0,1,.4.4V61.7a.4.4,0,0,1-.4.4Zm-4.787-3.035a.391.391,0,0,1,.168.038l4.223,1.978V57.818H83.729a.4.4,0,0,1-.4-.4V54.648H77.785v2.774a.4.4,0,0,1-.4.4H76.2v3.251L80.357,59.1a.4.4,0,0,1,.17-.038Z"
                                                transform="translate(-72.632 -51.873)"
                                                fill="#423460"
                                            />
                                            <path
                                                id="Path_733"
                                                data-name="Path 733"
                                                d="M185.061,2.774h-1.585a.4.4,0,0,1-.4-.4V.793A.794.794,0,0,1,183.873,0h.793a.794.794,0,0,1,.793.793V2.378a.4.4,0,0,1-.4.4Zm-1.189-.793h.793V.793h-.793Z"
                                                transform="translate(-176.343)"
                                                fill="#423460"
                                            />
                                            <path
                                                id="Path_734"
                                                data-name="Path 734"
                                                d="M205,216.859a.4.4,0,0,1-.4-.4v-9.907a.4.4,0,1,1,.793,0v9.907a.4.4,0,0,1-.4.4"
                                                transform="translate(-197.079 -198.573)"
                                                fill="#423460"
                                            />
                                        </svg>
                                    </i>
                                    <span>Sea</span>
                                </div>
                            </div>

                            <div className="option">
                                <input type="radio" name="route_type" value={constants.ROUTE_TYPE_LAND}
                                       checked={parseInt(routeType) === constants.ROUTE_TYPE_LAND}
                                       onClick={() => setRouteType(constants.ROUTE_TYPE_LAND)}
                                />
                                <div className="content land">
                                    <i className="icon">
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
                                    </i>
                                    <span>Land</span>
                                </div>
                            </div>

                            <div className="option">
                                <input type="radio" name="route_type" disabled />
                                <div className="content air">
                                    <i className="icon">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width=""
                                            height=""
                                            viewBox="0 0 29.881 29.683"
                                        >
                                            <path
                                                id="Path_742"
                                                data-name="Path 742"
                                                d="M14.87,0a2.155,2.155,0,0,0-1.7.817,5.9,5.9,0,0,0-1.4,3.674l.2,5.222L1.613,16.548A3.865,3.865,0,0,0,0,19.468a.6.6,0,0,0,.814.557l8.175-3.176,3.217-.985.246,6.472a1.109,1.109,0,0,0,.092.441l.161.922L9.323,27.081a.6.6,0,0,0-.175.423v1.355a.6.6,0,0,0,.737.581l3.669-.88.048.277a.6.6,0,0,0,.07.193,1.36,1.36,0,0,0,1.195.653,1.409,1.409,0,0,0,1-.4,1.225,1.225,0,0,0,.2-.256.61.61,0,0,0,.069-.193l.045-.26,3.595.863a.6.6,0,0,0,.51-.112.563.563,0,0,0,.053-.047.6.6,0,0,0,.175-.423V27.5a.6.6,0,0,0-.175-.423l-3.317-3.317.173-.988a1.074,1.074,0,0,0,.092-.421l.22-6.546,3.351,1.025,8.216,3.19a.6.6,0,0,0,.814-.557,3.869,3.869,0,0,0-1.624-2.927L17.71,9.582l.172-5.114A5.825,5.825,0,0,0,16.566.816,2.158,2.158,0,0,0,14.87,0ZM8.6,15.72,1.456,18.494a3.138,3.138,0,0,1,.826-.954l9.744-6.429.134,3.518ZM10.343,28.1v-.35l2.613-2.613.392,2.242Zm8.969-.35V28.1l-2.931-.7.383-2.194Zm8.275-10.22a3.139,3.139,0,0,1,.838.962l-7.182-2.786-3.7-1.134.121-3.59ZM15.631,1.562a4.629,4.629,0,0,1,1.056,2.886L16.095,22.3a.6.6,0,0,0-.069.192l-.211,1.21a.588.588,0,0,0-.051.291l-.636,3.642a.293.293,0,0,0-.039.224l-.106.61a.291.291,0,0,1-.115.022.3.3,0,0,1-.115-.022l-1.044-5.978a.484.484,0,0,0-.061-.175L12.969,4.468a4.723,4.723,0,0,1,1.14-2.906.974.974,0,0,1,1.522,0Z"
                                                transform="translate(0 0)"
                                                fill="#4174c1"
                                            />
                                        </svg>
                                    </i>
                                    <span>air</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="lg:w-3/12 w-full">
                    <label className="form-label small-label uppercase primary-font-medium">
                        From
                    </label>
                    <Form.Item
                        id="origin_port"
                        name="origin_port"
                        className="form-field"
                        rules={[
                            {
                                required: true,
                                message: "Port of Origin is required",
                                whitespace: true,
                            },
                            {
                                min: 2,
                                message: "Type at least 2 characters",
                            },
                        ]}
                        hasFeedback={true}
                    >
                        <AutoComplete
                            placeholder="From"
                            options={originList}
                            onSelect={(value, selectedOption) =>
                                setOrigin(selectedOption.UNLocCode)
                            }
                            onSearch={(text) => {
                                if (text.length > 1) {
                                    return getCitySuggestions(
                                        text,
                                        TYPE_ORIGIN
                                    );
                                } else {
                                    setOriginList([]);
                                    return false;
                                }
                            }}
                            style={{ width: "100%" }}
                            size={"large"}
                        />
                    </Form.Item>
                </div>

                <div className="lg:w-3/12 w-full">
                    <div className="form-field">
                        <label className="form-label small-label uppercase primary-font-medium">
                            To
                        </label>
                        <Form.Item
                            id="destination_port"
                            name="destination_port"
                            className="form-field"
                            rules={[
                                {
                                    required: true,
                                    message: "Port of Destination is required",
                                    whitespace: true,
                                },
                                {
                                    min: 2,
                                    message: "Type at least 2 characters",
                                },
                            ]}
                            hasFeedback={true}
                        >
                            <AutoComplete
                                placeholder="To"
                                options={destinationList}
                                onSelect={(value, selectedOption) =>
                                    setDestination(selectedOption.UNLocCode)
                                }
                                onSearch={(text) => {
                                    if (text.length > 1) {
                                        return getCitySuggestions(
                                            text,
                                            TYPE_DESTINATION
                                        );
                                    } else {
                                        setDestinationList([]);
                                        return false;
                                    }
                                }}
                                style={{ width: "100%" }}
                                size={"large"}
                            />
                        </Form.Item>
                    </div>
                </div>

                <div className="lg:w-1/5 w-full">
                    <div className="form-field">
                        <label className="form-label small-label uppercase primary-font-medium">
                            {parseInt(routeType) === constants.ROUTE_TYPE_SEA ? 'type of shipment' : 'truck type'}
                        </label>
                        {parseInt(routeType) === constants.ROUTE_TYPE_SEA ?
                            <Form.Item id="container_size" name="container_size" className="form-field"
                                       rules={[{
                                           required: true,
                                           message: 'Container is required',
                                           whitespace: true
                                       }]} hasFeedback={true}>
                                <Select style={{ width: "100%" }}
                                        options={containerSizes}
                                        placeholder={'CONTAINER'}
                                        size={'large'}
                                />
                            </Form.Item>
                            :
                            <Form.Item id="truck_type" name="truck_type" className="form-field"
                                       rules={[{
                                           required: true,
                                           message: 'Truck Type is required',
                                       }]} hasFeedback={true}>
                                <Select style={{ width: "100%" }}
                                        options={truckTypes}
                                        placeholder={'TRUCK TYPE'}
                                        size={'large'}
                                />
                            </Form.Item>
                        }
                    </div>
                </div>

                <div className="lg:w-1/5 w-full">
                    <div className="form-field">
                        <label className="form-label small-label uppercase primary-font-medium">
                            select date
                        </label>
                        <Form.Item
                            id="departure_date"
                            name="departure_date"
                            className="form-field"
                            rules={[
                                {
                                    required: true,
                                    message: "Date is required",
                                },
                            ]}
                            hasFeedback={true}
                        >
                            <DatePicker
                                size={"large"}
                                disabledDate={disabledDate}
                                format={"DD/MM/YYYY"}
                                style={{ width: "100%" }}
                            />
                        </Form.Item>
                    </div>
                </div>

                <Button
                    key="submit"
                    type="primary"
                    loading={false}
                    onClick={handleSearchForm}
                    className="search-submit"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="18"
                        height="18"
                        viewBox="0 0 18 18"
                    >
                        <path
                            id="Search-icon"
                            d="M17.822,16.78l-4.729-4.729a7.35,7.35,0,1,0-1.042,1.042l4.729,4.729a.739.739,0,0,0,1.042-1.042ZM3.192,11.556A5.874,5.874,0,1,1,7.371,13.3a5.911,5.911,0,0,1-4.178-1.745"
                            transform="translate(0 0.001)"
                            fill="#ffffff"
                        />
                    </svg>
                </Button>
            </div>
        </Form>
    );
};

export default SearchbarForm;
