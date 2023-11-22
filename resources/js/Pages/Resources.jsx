import { Link, Head } from '@inertiajs/react';

export default function Resources() {
    return (
        <>
            <Head title="Resources" />

            <section className="max-w-screen-4xl mx-auto">
                <section className="inner-banner resources-banner gap-8 align-bottom default-container">
                    <div className="md:w-6/12">
                        <div className="heading-style-v1">
                            <h2 className="title">Resources</h2>
                            <p className="subtitle">& TOOLS TO HELP YOU OUT</p>
                        </div>

                        <div className="image block md:hidden">
                            <img src="/images/resources-banner.png" alt="" />
                        </div>

                        <p className="default-content 2xl:mr-16">
                            Stay informed with regular updates about your routes, distances, and shipment times, enhancing transparency for your customers and supply chains. Gain comprehensive knowledge of the equipment required for shipping and the necessary space using our load calculator, allowing you and your team to maintain a professional image.
                            <br /><br />
                            Avoid any confusion or surprises arising from unpredictable route conditions, traffic congestion, or adverse weather conditions. Our wide range of resources and tools offers real-time information and insights, empowering you to make informed decisions and demonstrate your expertise in your field. 
                        </p>
                    </div>

                    <div className="md:w-6/12 ml-auto">
                        <div className="image hidden md:block relative top-8">
                            <img src="/images/resources-banner.png" alt="" />
                        </div>
                    </div>
                </section>
            </section>

            <section className="max-w-screen-4xl mx-auto">
                <section className="default-container md:my-20 mt-0 mb-10">
                    <div className='image-content-box'>
                        <section id='loadcalculator'>
                            <div className='md:w-6/12'>
                                <figure className='2xl:w-11/12'>
                                    <img src='/images/load-calculator-image.jpg' alt="" />
                                </figure>
                            </div>

                            <div className='md:w-6/12'>
                                <article>
                                    <h2 className='default-heading'>
                                    LOAD CALCULATOR
                                    </h2>
                                    <p className='default-content'>
                                        Utilize your container or shipment to its fullest capacity by accurately calculating in advance the amount of space it can hold. With precise calculations, you can minimize the risk of accidents caused by logistical imbalances and ensure the efficient and safe shipment of your goods. Additionally, this will help you reduce the number of shipments required, lowering your transportation expenses, and enhancing overall efficiency. 
                                    </p>

                                    <a href="#" className="default-button-v2">
                                        <span>Coming Soon</span>
                                    </a>
                                </article>
                            </div>
                        </section>

                        <section id='routeplanner'>
                            <div className='md:w-6/12'>
                                <figure className='2xl:w-11/12 ml-auto'>
                                    <img src='/images/route-planner-image.jpg' alt="" />
                                </figure>
                            </div>

                            <div className='md:w-6/12'>
                                <article>
                                    <h2 className='default-heading'>
                                    Route Planner
                                    </h2>
                                    <p className='default-content'>
                                        Optimize the efficiency of your operations by meticulously planning the distance and time required for each shipment in advance. Review the order of stops and pickup locations for a single shipment, enabling you to strategize the optimal route and effectively reduce both time and delivery costs. Additionally, consider crucial factors such as weather conditions, traffic, cargo size, weight limitations, and other pertinent variables to enhance your on-time delivery rates.
                                    </p>

                                    <a href="#" className="default-button-v2">
                                        <span>Coming Soon</span>
                                    </a>
                                </article>
                            </div>
                        </section>

                        <section id='distancetime'>
                            <div className='md:w-6/12'>
                                <figure className='2xl:w-11/12'>
                                    <img src='/images/distance-time-image.jpg' alt="" />
                                </figure>
                            </div>

                            <div className='md:w-6/12'>
                                <article>
                                    <h2 className='default-heading'>
                                    Distance & Time
                                    </h2>
                                    <p className='default-content'>
                                        Stay ahead of urgent shipments or speedy deliveries with our accurate distance and time planning. Calculate the estimated time and distance required for shipments to travel from the port of loading to the port of delivery. Empower yourself and curious customers with essential information before making a purchase, thereby bolstering your reliability and efficiency.  
                                    </p>

                                    <a href="#" className="default-button-v2">
                                        <span>Coming Soon</span>
                                    </a>
                                </article>
                            </div>
                        </section>
                        
                    </div>
                </section>
            </section>

        </>
    )
}
