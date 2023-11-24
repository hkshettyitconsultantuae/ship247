// import Environment from "../network/baseUrl";
import axios from "axios";


const Environment={
  API_BASE_URL: '',
  BasicToken: "",
};

const getHeaders = async (token) => {
  if (token) {
    return {
      Authorization: "Bearer " + token,
      "Content-Type": "application/json",
      "Access-Control-Allow-Origin": "*",
      Accept: "application/json",
    };
  } else {
    return {
      "Content-Type": "application/json",
      "Access-Control-Allow-Origin": "*",
      Accept: "application/json",
      Authorization: Environment.BasicToken,
    };
  }
};

const getFileUploadHeaders = (token) => {
  if (token) {
    return {
      Authorization: "Bearer " + token,
      "Content-Type": "multipart/form-data",
      Accept: "application/json",
    };
  } else {
    return {
      Authorization: Environment.BasicToken,
      "Content-Type": "application/json",
      Accept: "application/json",
    };
  }
};

var profilePictureOptions = {
  method: null,
  data: null,
  headers: null,
};

var authOptions = {
  method: null,
  data: null,
  headers: getHeaders(),
};

export const doPost = async (url, data, token) => {
  var authOptionsPost = {
    method: null,
    data: null,
    headers: getHeaders(),
  };
  authOptionsPost.method = "POST";
  authOptionsPost.data = data;
  authOptionsPost.headers = await getHeaders(token);
  return axios(Environment.API_BASE_URL + url, authOptionsPost);
};
export const doPatch = async (url, data, token) => {
  authOptions.method = "Patch";
  authOptions.data = data;
  authOptions.headers = await getHeaders(token);
  return axios(Environment.API_BASE_URL + url, authOptions);
};

export const doPut = async (url, data, token) => {
  authOptions.method = "PUT";
  authOptions.data = data;
  authOptions.headers = await getHeaders(token);
  return axios(Environment.API_BASE_URL + url, authOptions);
};

export const doGet = async (url, token) => {
  authOptions.headers = await getHeaders(token);
  authOptions.method = "GET";
  authOptions.data = null;
  return axios(Environment.API_BASE_URL + url, authOptions);
};

export const doDelete = async (url, data, token) => {
  authOptions.method = "DELETE";
  authOptions.data = data;
  authOptions.headers = await getHeaders(token);
  return axios(Environment.API_BASE_URL + url, authOptions);
};

export const doPostUploadFile = (url, data, token) => {
  profilePictureOptions.method = "POST";
  profilePictureOptions.data = data;
  profilePictureOptions.headers = getFileUploadHeaders(token);
  return axios(Environment.API_BASE_URL + url, profilePictureOptions);
};

