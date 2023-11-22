import React from "react";
import {Accordion, AccordionBody, AccordionHeader, AccordionItem} from "react-headless-accordion";

const Faq = () => {
    return (
        <Accordion className="accordion-section">
            <AccordionItem>
                <AccordionHeader className={`accordion-head`}>
                    <h3 className={`accordion-title`}>Are your rates and schedules accurate?</h3>
                </AccordionHeader>

                <AccordionBody>
                    <div className="accordion-body">
                        Yes, at SHIP247, we take pride in providing real-time and accurate schedules and prices. Our dedicated team closely monitors them to ensure seamless operations for all our users. 
                    </div>
                </AccordionBody>
            </AccordionItem>

            <AccordionItem className="inner-accordion">
                <AccordionHeader className="accordion-head">
                    <h3 className={`accordion-title`}> What payment methods do you accept? </h3>
                </AccordionHeader>

                <AccordionBody>
                    <div className="accordion-body">
                        Currently, we accept wire transfers, and we are actively working to introduce card payments soon. For immediate booking confirmation, we offer a card payment method with cancellation charges paid upfront.
                    </div>
                </AccordionBody>
            </AccordionItem>

            <AccordionItem className="inner-accordion">
                <AccordionHeader className="accordion-head">
                    <h3 className={`accordion-title`}>Can we track our shipments on SHIP247?</h3>
                </AccordionHeader>

                <AccordionBody>
                    <div className="accordion-body">
                        Absolutely! You can easily track all your booked shipments on our platform. Our user-friendly dashboard and tracking system provide comprehensive data for your convenience. 
                    </div>
                </AccordionBody>
            </AccordionItem>

            <AccordionItem className="inner-accordion">
                <AccordionHeader className="accordion-head">
                    <h3 className={`accordion-title`}> Is it possible to appoint a SHIP247 customer service representative to manage our shipments?</h3>
                </AccordionHeader>

                <AccordionBody>
                    <div className="accordion-body">
                        Yes! If you prefer a hassle-free experience, you can appoint one of our dedicated customer service representatives to handle all your shipments on your behalf. Simply email us at CS@SHIP247.COM, and someone from our team will be assigned to tend to your specific needs. 
                    </div>
                </AccordionBody>
            </AccordionItem>
        </Accordion>
    );
};

export default Faq;