import React, { Component } from "react";
import Slider from "react-slick";

export default class SimpleSlider extends Component {
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
        <section className="max-w-screen-4xl mx-auto">
            <div className="benefits default-container">
                <div className="xl:w-3/12">
                    <h2 className="default-heading xl:mt-10">
                        Profit from Ship247
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
                    <Slider ref={c => (this.slider = c)} {...settings} className="benefit-image-slider">
                    <div className="item">
                        <div className="inner-content">
                            <div className="content-area md:w-6/12">
                                <h4 className="default-subheading mb-6">
                                Rapid processing
                                </h4>
                                <p className="default-content">
                                    Experience shipment processing and solutions at a speed that's unlike any other amongst intercontinental networks. Then sit back and watch your customers' satisfaction and loyalty to your brand soar due to a more efficient logistics system.
                                    <br /><br />
                                    Our shipping search engine is streamlined and simplified to return valuable time, conserve capital and crucial resources to your business.With rapid processing, real time updates and status visibility, we're built to propel your work pace.
                                </p>
                            </div>

                            <div className="image-holder md:w-5/12 md:ml-auto">
                                <img src="/images/benefit-processing.jpg" alt="" />
                            </div>
                        </div>
                    </div>
                    
                    <div className="item">
                        <div className="inner-content">
                            <div className="content-area md:w-6/12">
                                <h4 className="default-subheading mb-6">
                                Competitive rates
                                </h4>
                                <p className="default-content">
                                    Significantly cut costs with rates that support large volumes of goods and shipping services you can heavily count on. Level up amongst your competition and reinvest your costs towards other business areas, saving the stress when making purchasing decisions.
                                    <br /><br />
                                    Tap into new markets and regions with cost-effective shipping and watch your business scale, all from being able to affordably reach new customers.
                                </p>
                            </div>

                            <div className="image-holder md:w-5/12 md:ml-auto">
                                <img src="/images/benefit-best-price.jpg" alt="" />
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
      );
    }
  }