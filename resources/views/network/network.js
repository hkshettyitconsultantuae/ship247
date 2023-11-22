import {
  doGet,doPost
} from "./config";

export const getBookingAddons = (token) => {
  return doGet("/booking/addons", token);
};

export const getShipmentDetails = () => {
  return doGet("/shipment/details");
};

export const getContainerSizes = () => {
  return doGet("/container/size");
};

export const getTruckTypes = () => {
    return doGet("/truck-types/get");
};

export const storeShipmentDetails = (data) => {
  return doPost("/shipment-details", data);
};

export const storeRequestQuoteData = (data) => {
  return doPost("/request-quote", data);
};

export const storeBookingAddonsDetailsInSession = (data) => {
  return doPost("/booking-addons/in-session", data);
};

export const storeBookingPaymentDetails = (data) => {
  return doPost("/booking/payment/info", data);
};

export const storeBookingDetailsInSession = (data) => {
    return doPost("/bookings/in-session", data);
};

export const getUserDetails = () => {
  return doGet("/user_details", );
};
