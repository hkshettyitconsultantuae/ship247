import WorkWithUsTabbing from '@/Includes/WorkWithUsTabbing';
import { Link, Head } from '@inertiajs/react';

export default function Resources() {
    return (
        <>
            <Head title="Resources" />

            <section className="max-w-screen-4xl mx-auto md:mb-14">
                <section className="inner-banner workwithus-banner align-bottom default-container">
                    <div className="md:w-6/12">
                        <div className="heading-style-v1">
                            <h2 className="title">Work <br /> with us</h2>
                            <p className="subtitle">CUSTOMIZED TO Optimize YOUR Shipping</p>
                        </div>

                        <p className="default-content">
                            Work With Us offers you the chance to start collaborating with us as we grow and delve into new markets. Whether you are a Shipping Line, Freight Forwarder, Transport Company, or Customs Broker we welcome you all! 
                            <br /><br />
                            To give our partners a competitive advantage and created a trusting dynamic, we only have a few slots open for each country worldwide and are subject to approval!
                        </p>

                        <div className="mt-8">
                            <a href="/work-with-us-form" className='default-button-v2'>
                                <span>Sign Up</span>
                            </a>
                        </div>
                    </div>

                    <div className="md:w-4/12 ml-auto">
                        <div className="image">
                            <img src="/images/workwithus-banner.jpg" alt="" className='ml-auto' />
                        </div>
                    </div>
                </section>
            </section>

            <WorkWithUsTabbing />

            <section className="max-w-screen-4xl mx-auto">
                <div className="default-container">
                    <h2 className='default-heading mt-20 mb-10 text-center'>
                        BENEFITS
                    </h2>
                </div>
                <section className="flex xl:flex-row flex-col gap-x-6 gap-y-10 justify-center default-container mb-20">
                    <div className="shadow-box xsmall-box">
                        <h2 className="flex 2xl:items-center 2xl:flex-row flex-col">
                            <span className='w-[64px] mr-5 2xl:mb-0 mb-6'>
                                <img src="/images/svg/customer-benefits.svg" alt="" className="" />
                            </span>
                            <span className='leading-none text-[18px] secondary-font-regular'>
                                More Customers
                            </span>
                        </h2>
                    </div>

                    <div className="shadow-box xsmall-box">
                        <h2 className="flex 2xl:items-center 2xl:flex-row flex-col">
                            <span className='w-[64px] mr-5 2xl:mb-0 mb-6'>
                                <img src="/images/svg/management-benefits.svg" alt="" className="" />
                            </span>
                            <span className='leading-none text-[18px] secondary-font-regular'>
                                EASY MANAGEMENT
                            </span>
                        </h2>
                    </div>

                    <div className="shadow-box xsmall-box">
                        <h2 className="flex 2xl:items-center 2xl:flex-row flex-col">
                            <span className='w-[64px] mr-5 2xl:mb-0 mb-6'>
                                <img src="/images/svg/payment-benefits.svg" alt="" className="" />
                            </span>
                            <span className='leading-none text-[18px] secondary-font-regular'>
                                PAYMENT PROCESSING
                            </span>
                        </h2>
                    </div>

                    <div className="shadow-box xsmall-box">
                        <h2 className="flex 2xl:items-center 2xl:flex-row flex-col">
                            <span className='w-[64px] mr-5 2xl:mb-0 mb-6'>
                                <img src="/images/svg/support-benefits.svg" alt="" className="" />
                            </span>
                            <span className='leading-none text-[18px] secondary-font-regular'>
                                247 SUPPORT 
                            </span>
                        </h2>
                    </div>
                </section>
            </section>

        </>
    )
}
