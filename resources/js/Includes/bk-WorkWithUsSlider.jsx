import React, { Component } from "react";
import Slider from "react-slick";

export default class WorkWithUsSlider extends Component {
    constructor(props) {
        super(props);
        this.next = this.next.bind(this);
        this.previous = this.previous.bind(this);
      }
      next() {
        this.slider.slickNext();
      }
      previous() {
        this.slider.slickPrev();
      }
    render() {
      const settings = {
        dots: false,
        arrows: false,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1
      };
      return (
        <div className="primary-bg mb-20">
            <section className="max-w-screen-4xl mx-auto">
                <div className="services default-container">
                    <div className="xl:w-3/12">
                        <h2 className="default-heading white xl:mt-20">
                        SIGNUP AS
                        </h2>

                        <div className="slider-arrows desktop-arrows">
                            <a href="javascript:;" className="services-image-prev" onClick={this.previous}>
                                <img src="/images/svg/left-arrow-icon.svg" alt="" />
                            </a>
                            <a href="javascript:;" className="services-image-next" onClick={this.next}>
                                <img src="/images/svg/right-arrow-icon.svg" alt="" />
                            </a>
                        </div>
                    </div>

                    <div className="xl:w-9/12">
                        <Slider ref={c => (this.slider = c)} {...settings} className="services-image-slider">
                        <div className="item">
                            <div className="inner-content">
                                <div className="content-area md:w-7/12">
                                    <h4 className="default-subheading white mb-6">
                                    insurance
                                    </h4>
                                    <p className="default-content white">
                                        Ensures that all shipments comply with import and export regulations, such as tariffs, duties, and taxes. This can help businesses avoid legal and financial penalties and maintain compliance with the law.
                                        <br /><br />
                                        Efficient customs clearance can speed up the delivery process, ensuring that shipments reach their destination as quickly as possible.
                                        <br /><br />
                                        Customs clearance is necessary to ship goods internationally, allowing businesses to access new markets and expand their customer base. This can help businesses grow their business and increase their revenue.
                                    </p>

                                    <a href="#" className="default-button-v2 small-button md:mt-16 mt-10">
                                        sign up
                                    </a>
                                </div>

                                <div className="image-holder md:w-5/12">
                                    <img src="/images/insurance-signup.jpg" alt="" />
                                </div>
                            </div>
                        </div>


                        <div className="item">
                            <div className="inner-content">
                                <div className="content-area md:w-7/12">
                                    <h4 className="default-subheading white mb-6">
                                    PRE Shipment INSPECTION 
                                    </h4>
                                    <p className="default-content white">
                                        Help ensure that shipments are of the expected quality, verifying that goods are in good condition, packed correctly, and comply with relevant regulations and industry standards. This can help businesses avoid costly mistakes, such as shipping damaged or non-compliant goods.
                                        <br /><br />
                                        Surveyor services can help identify and manage risks associated with shipping, such as cargo damage, theft, or loss. By assessing risks and implementing appropriate measures to mitigate them, businesses can reduce the likelihood of incidents and minimize the impact of any issues that do occur.
                                    </p>

                                    <a href="#" className="default-button-v2 small-button md:mt-16 mt-10">
                                        sign up
                                    </a>
                                </div>

                                <div className="image-holder md:w-5/12">
                                    <img src="/images/inspection-signup.jpg" alt="" />
                                </div>
                            </div>
                        </div>



                        <div className="item">
                            <div className="inner-content">
                                <div className="content-area md:w-7/12">
                                    <h4 className="default-subheading white mb-6">
                                    Clearance Agent
                                    </h4>
                                    <p className="default-content white">
                                        Help ensure that shipments are of the expected quality, verifying that goods are in good condition, packed correctly, and comply with relevant regulations and industry standards. This can help businesses avoid costly mistakes, such as shipping damaged or non-compliant goods.
                                        <br /><br />
                                        Surveyor services can help identify and manage risks associated with shipping, such as cargo damage, theft, or loss. By assessing risks and implementing appropriate measures to mitigate them, businesses can reduce the likelihood of incidents and minimize the impact of any issues that do occur.
                                    </p>

                                    <a href="#" className="default-button-v2 small-button md:mt-16 mt-10">
                                        sign up
                                    </a>
                                </div>

                                <div className="image-holder md:w-5/12">
                                    <img src="/images/clearance-signup.jpg" alt="" />
                                </div>
                            </div>
                        </div>



                        <div className="item">
                            <div className="inner-content">
                                <div className="content-area md:w-7/12">
                                    <h4 className="default-subheading white mb-6">
                                    Transporter
                                    </h4>
                                    <p className="default-content white">
                                        Help ensure that shipments are of the expected quality, verifying that goods are in good condition, packed correctly, and comply with relevant regulations and industry standards. This can help businesses avoid costly mistakes, such as shipping damaged or non-compliant goods.
                                        <br /><br />
                                        Surveyor services can help identify and manage risks associated with shipping, such as cargo damage, theft, or loss. By assessing risks and implementing appropriate measures to mitigate them, businesses can reduce the likelihood of incidents and minimize the impact of any issues that do occur.
                                    </p>

                                    <a href="#" className="default-button-v2 small-button md:mt-16 mt-10">
                                        sign up
                                    </a>
                                </div>

                                <div className="image-holder md:w-5/12">
                                    <img src="/images/transporter-signup.jpg" alt="" />
                                </div>
                            </div>
                        </div>
                        
                        </Slider>
                    </div>
                    
                    <div className="slider-arrows mobile-arrows">
                        <a href="javascript:;" className="services-image-prev" onClick={this.previous}>
                            <img src="/images/svg/left-arrow-icon.svg" alt="" />
                        </a>
                        <a href="javascript:;" className="services-image-next" onClick={this.next}>
                            <img src="/images/svg/right-arrow-icon.svg" alt="" />
                        </a>
                    </div>
                </div>
            </section>
        </div>
      );
    }
  }