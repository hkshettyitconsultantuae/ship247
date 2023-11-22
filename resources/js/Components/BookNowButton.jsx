import {storeBookingDetailsInSession} from "../../views/network/network";

export const PLACEMENT_MAIN_RESULT = 1;
export const PLACEMENT_SIDEBAR_RESULT = 2;

const BookNowButton = ({placement = PLACEMENT_MAIN_RESULT, data = {}, priceBreakDown}) => {
    const saveBookingDetailsInSession = (data) => {
        data.priceBreakDown = priceBreakDown;
        if(!data) return;
        storeBookingDetailsInSession(data)
            .then((res) => {
                window.location.href = '/additional-services';
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => {
            });
    }

    return placement === PLACEMENT_MAIN_RESULT
        ? (<button onClick={() => saveBookingDetailsInSession(data)} className="book-button">
        book now
    </button>) : (
        <button onClick={() => saveBookingDetailsInSession(data)} className="default-button small-button red">
            Book Now
        </button>
    )
}

export default BookNowButton;
