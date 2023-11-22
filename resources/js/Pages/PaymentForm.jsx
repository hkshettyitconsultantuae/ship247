import React, { useState } from 'react';
import { CardElement, useStripe, useElements } from '@stripe/react-stripe-js';
import axios from 'axios';
import { storeBookingPaymentDetails } from "../../views/network/network";
const PaymentForm = ({ bookingDetails }) => {
  const [paymentStatus, setPaymentStatus] = useState('');
  const stripe = useStripe();
  const elements = useElements();



  const savePaymentDetails = async (clientSecret, paymentIntent) => {

    let data = {
      'clientSecret': clientSecret,
      'bookingDetails': bookingDetails,
      'paymentIntent': paymentIntent,
    }
    storeBookingPaymentDetails({ data })
      .then((res) => {
        if(paymentStatus === 'success'){
          window.location.href = `/booking/${bookingDetails.id}/thank-you`;
        }
      })
      .catch((error) => { console.log(error); })
      .finally(() => { });

  };


  const handlePayment = async (event) => {
    event.preventDefault();

    if (!stripe || !elements) {
      return;
    }

    const cardElement = elements.getElement(CardElement);

    try {
      const { error, paymentMethod } = await stripe.createPaymentMethod({
        type: 'card',
        card: cardElement,
      });

      if (error) {
        console.error(error.message);
        setPaymentStatus('failed');
        return;
      }

      // Token contains the payment information from Stripe
      const response = await axios.post('/create-payment-intent', {
        amount: bookingDetails.amount * 100, // Amount in cents (e.g., $10.00)
        payment_method: paymentMethod.id,
        bookingDetails : bookingDetails,
      });

      const { clientSecret } = response.data;

      const { paymentIntent, error: confirmError } = await stripe.confirmCardPayment(clientSecret, {
        payment_method: paymentMethod.id,
      });

      const paymentResponse = await savePaymentDetails(clientSecret, paymentIntent);

      
      if (confirmError) {
        console.error(confirmError.message);
        setPaymentStatus('failed');
        return;
      }

      if (paymentIntent.status === 'succeeded') {
        setPaymentStatus('success');
      } else {
        console.error('Payment was not successful.');
        setPaymentStatus('failed');
      }
    } catch (error) {
      console.error(error.message);
      setPaymentStatus('failed');
    }
  };

  return (
    <div style={styles.container}>
      <h2 style={styles.title}>Payment Form</h2>
      <form onSubmit={handlePayment}>
        <div style={styles.formGroup}>
          <label>Card Details</label>
          <CardElement options={cardElementOptions} style={styles.cardElement} />
        </div>
        <button type="submit" style={styles.submitButton}>Pay Now</button>
      </form>
      {paymentStatus === 'success' && <p style={styles.paymentStatusSuccess}>Payment successful!</p>}
      {paymentStatus === 'failed' && <p style={styles.paymentStatusFailed}>Payment failed. Please try again.</p>}
    </div>
  );
};

const cardElementOptions = {
  // Add any custom options for the CardElement from Stripe
};

const styles = {
  container: {
    maxWidth: '400px',
    margin: '0 auto',
    padding: '20px',
    border: '1px solid #ccc',
    borderRadius: '4px',
    boxShadow: '0 2px 4px rgba(0, 0, 0, 0.1)',
  },
  title: {
    fontSize: '24px',
    marginBottom: '20px',
  },
  formGroup: {
    marginBottom: '20px',
  },
  cardElement: {
    display: 'block',
    padding: '10px 14px',
    border: '1px solid #ccc',
    borderRadius: '4px',
    marginBottom: '20px',
    boxShadow: 'inset 0 1px 1px rgba(0, 0, 0, 0.1)',
  },
  submitButton: {
    backgroundColor: '#007BFF',
    color: '#fff',
    border: 'none',
    padding: '10px 20px',
    borderRadius: '4px',
    cursor: 'pointer',
    fontSize: '16px',
  },
  paymentStatusSuccess: {
    marginTop: '20px',
    fontSize: '18px',
    fontWeight: 'bold',
    color: '#4caf50',
  },
  paymentStatusFailed: {
    marginTop: '20px',
    fontSize: '18px',
    fontWeight: 'bold',
    color: '#ff0000',
  },
};

export default PaymentForm;