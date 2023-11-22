import { createContext, useState } from "react";

const MainContext = createContext();

export function MainProvider({ children }) {
  const [isLoggedIn, setisLoggedIn] = useState(false);
  const [token, setToken] = useState("");
  const [bookingDetails, setBookingDetails] = useState(false);

  return (
    <MainContext.Provider
      value={{
        bookingDetails,
        setBookingDetails
      }}
    >
      {children}
    </MainContext.Provider>
  );
}

export default MainContext;
