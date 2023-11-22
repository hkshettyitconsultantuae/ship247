import { Link, Head } from '@inertiajs/react';
import ServiceSlider from '@/Includes/ServiceSlider';
import RegistrationCta from '@/Includes/RegisterCta';
import Faq from '@/Includes/FAQs';
import TopDealSlider from '@/Includes/TopDealSlider';

export default function Services({hot_deals_collection}) {
    return (
        <>
            <Head title="Services" />

            <section className="max-w-screen-4xl mx-auto">
                <section className="inner-banner service-banner align-bottom gap-8 default-container">
                    <div className="md:w-6/12">
                        <div className="heading-style-v1">
                            <h2 className="title">SERVICES</h2>
                            <p className="subtitle">CUSTOMIZED TO Optimize YOUR Shipping</p>
                        </div>

                        <div className="image block md:hidden">
                            <img src="/images/services-banner.png" alt="" />
                        </div>

                        <p className="default-content">
                            SHIP247 is your new Digital Global Logistics Partner. Experience real-time rates and easy worldwide booking, enhancing logistics for informed choices. Utilize our tracking and comprehensive dashboard to manage shipments seamlessly. Embrace the future of shipping through SHIP247, propelling the industry towards digital transformation. You will be able to utilize us for all your logistics needs. If you happen not to find what you're looking for, please contact us and one of our team members will assist you!
                        </p>
                    </div>

                    <div className="md:w-7/12">
                        <div className="image hidden md:block">
                            <img src="/images/services-banner.png" alt="" />
                        </div>
                    </div>
                </section>
            </section>

            <section className="max-w-screen-4xl mx-auto">
                <div className="default-container">
                <h4 className='default-heading md:mt-10'>we offer</h4>

                    <section className="md:mt-0 grid md:grid-cols-2 lg:gap-x-20 gap-x-10 gap-y-10 justify-between my-20">
                        <div className="shadow-box large-radius large-spacing">
                            <h2 className="default-heading small-margin flex md:items-center md:flex-row flex-col">
                                <span>
                                    <img src="/images/svg/service-fcl.svg" alt="" className="w-16 md:mb-0 mb-4 md:mr-6 mr-0" />
                                </span>
                                <span>
                                    FCL
                                </span>
                            </h2>
                            <p className="default-content md:mt-8 mt-3">
                                FCL (Full Container Load) – is an ocean shipping mode, in which the entire container is intended for one supplier and occupies a full container (regardless of size). FCL transportation can be filled directly at the supplier’s warehouse, and then sent to the container yard (container cargo station in the port).
                                {/* <br /><br />
                                The main drawback of containers is the need for their return. This refers to the return of empty containers that could not be occupied with return freight. */}
                            </p>
                        </div>

                        <div className="shadow-box large-radius large-spacing">
                            <h2 className="default-heading small-margin flex md:items-center md:flex-row flex-col">
                                <span>
                                    <img src="/images/svg/service-lcl.svg" alt="" className="w-16 md:mb-0 mb-4 md:mr-6 mr-0" />
                                </span>
                                <span>
                                    LCL
                                </span>
                            </h2>
                            <p className="default-content md:mt-8 mt-3">
                                Delivery of collective cargoes from 1m3 to 15m3, transported in a common container with other shippers in order not to overpay for delivery. It is considered the most economical way to deliver small quantities of goods.
                                {/* <br /><br />
                                You do not need to worry about returning the container after its delivery. Since along with your cargo in the container the goods of other shippers are transported, the return of the container becomes a problem of the container line. */}
                            </p>
                        </div>

                        <div className="shadow-box large-radius large-spacing">
                            <h2 className="default-heading small-margin flex md:items-center md:flex-row flex-col">
                                <span>
                                    <img src="/images/svg/service-trucking.svg" alt="" className="w-16 md:mb-0 mb-4 md:mr-6 mr-0" />
                                </span>
                                <span>
                                    TRUCKING
                                </span>
                            </h2>
                            <p className="default-content md:mt-8 mt-3">
                                {/* Effectively and efficiently supply high-quality products or services to customers in a foreign market. Focused on providing value to customers while achieving profitability and sustainability for the supplier's business.
                                <br /><br />
                                The needs and expectations of customers at the center of its mission. This includes understanding the market, identifying customer needs and preferences, and providing excellent customer service. */}

                                Trucking stands as a pivotal method of cargo transportation, encompassing the loading of goods onto flatbeds or box trailers for streamlined movement across local or international landscapes. At SHIP we offer local and international trucking solutions.
                            </p>
                        </div>

                        <div className="shadow-box large-radius large-spacing">
                            <h2 className="default-heading small-margin flex md:items-center md:flex-row flex-col">
                                <span>
                                    <img src="/images/svg/service-air.svg" alt="" className="w-16 md:mb-0 mb-4 md:mr-6 mr-0" />
                                </span>
                                <span>
                                    Airfreight
                                </span>
                            </h2>
                            <p className="default-content md:mt-8 mt-3">
                                {/* Aspire to become a leader in its market, setting the standard for quality, service, and innovation.
                                <br /><br />
                                Aim to be at the forefront of innovation and technology, developing new products, processes, or services that bring value to customers.
                                <br /><br />
                                Strive for sustainable growth, aiming to expand its business while maintaining profitability, environmental and social responsibility, and ethical business practices. */}
                                Air freight, also known as air cargo, pertains to the transportation of goods using air carriers. This method of air transport is valuable for swiftly moving express shipments across the world. Similar to commercial or passenger airlines, air freight operates through the same gateways and entry points.
                            </p>
                        </div>
                    </section>
                </div>
            </section>

            <TopDealSlider deals={hot_deals_collection?.data ?? []}/>

            <ServiceSlider />

            <RegistrationCta />

            <section className="max-w-screen-xl mx-auto">
            <div className='faqs-section default-container'>
                <h4 className='default-heading text-center'>FAQ</h4>

                <Faq />
            </div>

            {/* <div className="text-center mb-20">
                <a href="#" className="default-button red">
                VIEW ALL QUESTIONS
                </a>
            </div> */}

        </section>



        </>
    )
}
