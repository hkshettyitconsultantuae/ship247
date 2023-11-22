import { Link, Head } from '@inertiajs/react';
import RegistrationCta from '@/Includes/RegisterCta';
import LatestNews from '@/Includes/LatestNews';
import ClientsLogo from '@/Includes/ClientLogos';

export default function Benefits({news_listing}) {
    return (
        <>
            <Head title="Benefits" />
            
            <section className="max-w-screen-4xl mx-auto">
                <section className="inner-banner default-container">
                    <div className="md:w-7/12">
                        <div className="heading-style-v1">
                            <h2 className="title">Why SHIP247</h2>
                            <p className="subtitle">Built with benefits for your business</p>
                        </div>

                        <p className="default-content">
                            Utilizing the SHIP247 platform for instant shipping rates and effortless booking in the logistics sector offers several advantages to its users. The instantaneous booking process simplifies operations, eliminating the time-consuming aspects of manual quotes and bookings. This expedites operations and ensures prompt transportation services while ensuring competitiveness in the market. 
                            <br /><br />
                            SHIP247 also incorporates shipment tracking functionality that enhances supply chain management. This allows for real-time monitoring, leading to precise delivery estimates. The platform optimizes supply chain processes, reduces delays, and enhances the agility of the logistics system.
                            {/* <span className='secondary-color primary-font-bold'>Simplified and Cost-efficient Shipping:</span> Our platform provides easy-to-navigate shipping options with the most competitive rates available, ensuring you save valuable time and money in managing your shipments. <br /><br />
                            <span className='secondary-color primary-font-bold'>Customer Focus and Resource Allocation:</span> By reducing shipping costs, you can allocate more resources towards enhancing your customer service, leading to improved satisfaction and increased customer loyalty. <br /><br />
                            <span className='secondary-color primary-font-bold'>Competitive Pricing for Your Products:</span> With our reduced shipping rates, you gain the advantage of offering more competitive pricing on your products and services, making you an attractive choice for potential customers. <br /><br />
                            <span className='secondary-color primary-font-bold'>Faster Delivery Times:</span> Benefit from a broader range of faster delivery options, allowing you to delight your customers with timely and reliable shipping services. <br /><br />
                            <span className='secondary-color primary-font-bold'>Unprecedented Growth in Sales and Revenue:</span> With improved customer satisfaction and competitive pricing, you can expect to witness a significant surge in sales and revenue. <br /><br />
                            <span className='secondary-color primary-font-bold'>Efficient Turnaround and Increased Word-of-Mouth Recommendations:</span> Our platform facilitates quick order fulfilment, resulting in positive word-of-mouth recommendations and further boosting your business's reputation. <br /><br />
                            <span className='secondary-color primary-font-bold'>Personalized Contract Negotiations:</span> Whether you prefer long-term contracts or increasing shipment volumes, our team is dedicated to assisting you in securing the best possible deals for your business. */}
                        </p>
                    </div>

                    <div className="md:w-4/12 ml-auto">
                        <div className="image">
                            <img src="/images/benefit-banner.jpg" alt="" />
                        </div>
                    </div>
                </section>
            </section>

            <section className="max-w-screen-4xl mx-auto">
                <section className="grid md:grid-cols-2 lg:gap-20 gap-10 justify-between default-container my-20">
                    <div className="shadow-box large-radius large-spacing">
                        <h2 className="default-heading small-margin flex md:justify-between md:items-center md:flex-row flex-col-reverse">
                            <span>
                                Mission
                            </span>
                            <span>
                                <img src="/images/svg/mission-icon.svg"  alt="" className="w-16 md:mb-0 mb-6" />
                            </span>
                        </h2>
                        <p className="default-content mt-8">
                            We aim to empower logistics for a sustainable future. At SHIP247, we connect businesses with seamless logistics solutions. Through innovative technology and extensive research, we will drive efficient and sustainable supply chains globally. 
                        </p>
                    </div>

                    <div className="shadow-box large-radius large-spacing">
                        <h2 className="default-heading small-margin flex md:justify-between md:items-center md:flex-row flex-col-reverse">
                            <span>
                                Vision
                            </span>
                            <span>
                                <img src="/images/svg/vision-icon.svg"  alt="" className="w-16 md:mb-0 mb-6" />
                            </span>
                        </h2>
                        <p className="default-content mt-8">
                            Transforming the logistics landscape through sustainable solutions and cutting-edge technology. Our vision at SHIP247 is to be the leading platform that empowers businesses to optimize their production and delivery processes, while prioritizing environmental sustainability. By fostering innovation and delivering exceptional value, we aim to shape a future where logistics seamlessly integrate with global progress. 
                        </p>
                    </div>
                </section>
            </section>

            <section className="primary-bg">
                <section className="max-w-screen-4xl mx-auto">
                    <div className="flex md:flex-row flex-col-reverse items-center md:gap-8 default-container">
                        <div className="md:w-6/12">
                            <div className="content py-8">
                                <h2 className="default-heading small-heading white">
                                we have added more services to ensure your experience is seamless
                                </h2>
                                {/* <p className="default-content white mb-8 mt-10">
                                    we have added more services to ensure your experience is seamless
                                </p> */}

                                <a href="/services" className="default-button-v2">
                                    <span>view all services</span>
                                </a>
                            </div>
                        </div>
                        <div className="md:w-5/12 ml-auto">
                            <div className="image md:mx-0 -mx-4">
                                <img src="/images/additional-services-img.jpg" alt="" />
                            </div>
                        </div>
                    </div>
                </section>
            </section>

            <RegistrationCta />
            
            <LatestNews news={news_listing}/>

            <ClientsLogo />
        </>
    )
}