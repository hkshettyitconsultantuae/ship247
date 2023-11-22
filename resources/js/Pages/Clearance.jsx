import { Link, Head } from '@inertiajs/react';
import RegistrationCta from '@/Includes/RegisterCta';
import LatestNews from '@/Includes/LatestNews';
import ClientsLogo from '@/Includes/ClientLogos';

export default function Clearance() {
    return (
        <>
            <Head title="Clearance" />
            
            <section className="max-w-screen-4xl mx-auto">
                <section className="inner-banner default-container">
                    <div className="md:w-6/12">
                        <div className="heading-style-v1">
                            <h2 className="title">custom clearance</h2>
                            <p className="subtitle">Built with benefits for your business </p>
                        </div>

                        <p className="default-content">
                            Save the strain of reading the fine print with efficient custom clearance covering the compliance of your import and export regulations like tariffs, duties, and taxes. Maintain compliance with the law, removing the risk of facing future legal and financial penalties. <br /><br />
                            Ship goods internationally, access new markets, scale your customer base, and increase revenue streams with competent custom clearance.
                        </p>

                        <a href="/services" className="default-button-v2 mt-10">
                            <span>Request a quote</span>
                        </a>
                    </div>

                    <div className="md:w-4/12 ml-auto">
                        <div className="image">
                            <img src="/images/benefit-banner.jpg" alt="" />
                        </div>
                    </div>
                </section>
            </section>

            <section className="max-w-screen-4xl mx-auto">
                <section className="default-container md:my-20 mt-0 mb-10">
                    <div className="flex">
                        <div className="md:w-4/12">
                            <div className="image">
                                <img src="/images/benefit-banner.jpg" alt="" />
                            </div>
                        </div>

                        <div className="md:w-6/12 ml-auto">
                            <h2 className="default-heading">custom clearance</h2>

                            <p className="default-content">
                            In its logistics community, SeaRates has qualified customs brokers who have received appropriate training and have licenses and legal rights to carry out customs clearance on behalf of the customer. <br /><br />
                            The process of customs clearance is better to trust into the hands of qualified logistics providers - this will allow avoiding troubles with the customs authorities. In the case of commercial cargo - incorrect customs clearance threatens with substantial fines and even criminal liability.
                            </p>

                            <a href="/services" className="default-button-v2 mt-10">
                                <span>Contact for details</span>
                            </a>
                        </div>

                        
                    </div>
                </section>
            </section>
        </>
    )
}