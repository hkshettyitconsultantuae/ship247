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
        <div className="primary-bg py-10">
            <section className="max-w-screen-4xl mx-auto">
                <div className="services default-container">
                    <div className="slider-arrows mobile-arrows">
                        <a href="javascript:;" className="services-image-prev" onClick={this.previous}>
                            <img src="/images/svg/left-arrow-icon.svg" alt="" />
                        </a>
                        <a href="javascript:;" className="services-image-next" onClick={this.next}>
                            <img src="/images/svg/right-arrow-icon.svg" alt="" />
                        </a>
                    </div>

                    <div className="xl:w-3/12">
                        <h2 className="default-heading white xl:mt-20">
                            Additional Services
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
                                <div className="md:w-6/12">
                                    <div className="flex md:flex-row flex-col items-start gap-6 md:pt-20">
                                        <div className="icon-area">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="68" height="68" viewBox="0 0 68 68">
                                                <defs>
                                                    <clipPath id="clip-path">
                                                    <rect id="Rectangle_85" data-name="Rectangle 85" width="68" height="68" fill="#c6c6c6"/>
                                                    </clipPath>
                                                </defs>
                                                <g id="clearance-icon" transform="translate(0 -3)">
                                                    <g id="Group_149" data-name="Group 149" transform="translate(0 3)" clip-path="url(#clip-path)">
                                                    <path id="Path_743" data-name="Path 743" d="M67.923,57.048A1.9,1.9,0,0,0,68,56.666V11.333A1.133,1.133,0,0,0,66.867,10.2h-44.2a1.133,1.133,0,0,0-1.133,1.133V20.4H7.933V10.2h10.2a1.141,1.141,0,0,0,.956-1.741L16.957,5.1,19.09,1.741A1.141,1.141,0,0,0,18.133,0H6.8A1.133,1.133,0,0,0,5.667,1.134c-.007,4.585.005,14.613,0,19.266H1.133A1.133,1.133,0,0,0,0,21.533V51a1.133,1.133,0,0,0,1.133,1.133h20.4V66.866A1.133,1.133,0,0,0,22.667,68H54.4a1.305,1.305,0,0,0,.717-.256l12.467-10.2A1.439,1.439,0,0,0,67.923,57.048ZM14.658,5.708l1.414,2.226H7.933V2.267h8.138L14.658,4.492a1.132,1.132,0,0,0,0,1.215ZM2.266,22.666h34v5.667h-34Zm0,7.933h34V43.066H28.333A1.133,1.133,0,0,0,27.2,44.2v5.667H2.266Zm27.2,18.133v-3.4H34Zm23.8,7.933v9.067H23.8v-13.6c.119-.032,4.949.066,4.891-.058a1.128,1.128,0,0,0,.322-.169l9.067-6.8a1.232,1.232,0,0,0,.454-.907V21.532A1.133,1.133,0,0,0,37.4,20.4H23.8V12.466H65.733V55.532H54.4a1.133,1.133,0,0,0-1.133,1.133Zm2.267,7.808V57.8h8.158Z" transform="translate(0 0)" fill="#c6c6c6"/>
                                                    <path id="Path_744" data-name="Path 744" d="M45.028,273.516h10.2a1.134,1.134,0,0,0,0-2.267h-10.2a1.134,1.134,0,0,0,0,2.267" transform="translate(-38.228 -236.116)" fill="#d43031"/>
                                                    <path id="Path_745" data-name="Path 745" d="M59.613,306.249H44.879a1.133,1.133,0,0,0,0,2.267H59.613a1.134,1.134,0,0,0,0-2.267" transform="translate(-38.08 -266.583)" fill="#d43031"/>
                                                    <path id="Path_746" data-name="Path 746" d="M319.994,367.5H307.528a1.134,1.134,0,0,0,0,2.267h12.467a1.134,1.134,0,0,0,0-2.267" transform="translate(-266.728 -319.9)" fill="#c6c6c6"/>
                                                    <path id="Path_747" data-name="Path 747" d="M315.01,411.249H307.53a1.134,1.134,0,0,0,0,2.267h7.479a1.134,1.134,0,0,0,0-2.267" transform="translate(-266.73 -357.983)" fill="#c6c6c6"/>
                                                    <path id="Path_748" data-name="Path 748" d="M210.562,420.3l-5.611,5.94-1.819-1.873a1.134,1.134,0,0,0-1.625,1.581l2.644,2.72a1.14,1.14,0,0,0,1.636-.012l6.423-6.8a1.133,1.133,0,0,0-1.647-1.556Z" transform="translate(-175.12 -365.546)" fill="#d43031"/>
                                                    <path id="Path_749" data-name="Path 749" d="M333.629,131.566h13.6a1.133,1.133,0,0,0,1.133-1.133v-6.8a1.133,1.133,0,0,0-1.133-1.133h-13.6a1.133,1.133,0,0,0-1.133,1.133v6.8a1.133,1.133,0,0,0,1.133,1.133m1.133-6.8H346.1V129.3H334.763Z" transform="translate(-289.43 -106.633)" fill="#c6c6c6"/>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>

                                        <div className="content-area">
                                            <h4 className="default-subheading white mb-6">
                                                CUSTOM CLEARANCE
                                            </h4>
                                            <p className="default-content white">
                                                Save the strain of reading the fine print with efficient custom clearance covering the compliance of your import and export regulations like tariffs, duties, and taxes. Maintain compliance with the law, removing the risk of facing future legal and financial penalties.
                                                <br /><br />
                                                Ship goods internationally, access new markets, scale your customer base, and increase revenue streams with competent custom clearance. 
                                            </p>

                                            <a href="#" className="default-button white mt-10">
                                                LEARN MORE
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div className="image-holder md:w-5/12 md:ml-auto">
                                    <img src="/images/services-custom.jpg" alt="" />
                                </div>
                            </div>
                        </div>

                        <div className="item">
                            <div className="inner-content">
                                <div className="md:w-6/12">
                                    <div className="flex md:flex-row flex-col items-start gap-6 md:pt-20">
                                        <div className="icon-area">
                                            <svg id="inpection-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="66.48" height="68" viewBox="0 0 66.48 68">
                                                <defs>
                                                    <clipPath id="clip-path">
                                                    <rect id="Rectangle_86" data-name="Rectangle 86" width="66.48" height="68" fill="#c6c6c6"/>
                                                    </clipPath>
                                                </defs>
                                                <g id="Group_150" data-name="Group 150" clip-path="url(#clip-path)">
                                                    <path id="Path_750" data-name="Path 750" d="M54.557,44.976a1.587,1.587,0,0,0-1.573,1.573V54.2a.717.717,0,0,1-.715.715H13.8a.717.717,0,0,1-.715-.715V3.79a.716.716,0,0,1,.715-.715H52.34a.717.717,0,0,1,.715.715v7.579a1.573,1.573,0,1,0,3.146,0V3.79A3.815,3.815,0,0,0,52.412,0H13.8a3.815,3.815,0,0,0-3.79,3.79V10.01H3.79A3.815,3.815,0,0,0,0,13.8V64.21A3.815,3.815,0,0,0,3.79,68H42.33a3.815,3.815,0,0,0,3.79-3.79V57.99h6.221a3.815,3.815,0,0,0,3.79-3.79V46.477a1.527,1.527,0,0,0-1.573-1.5ZM43.045,64.139a.64.64,0,0,1-.643.643H3.79a.64.64,0,0,1-.643-.643V13.729a.705.705,0,0,1,.643-.715H10.01V54.128a3.815,3.815,0,0,0,3.79,3.79H43.045Z" fill="#c6c6c6"/>
                                                    <path id="Path_751" data-name="Path 751" d="M151.652,290.428h14.229a1.573,1.573,0,1,0,0-3.146H151.652a1.573,1.573,0,1,0,0,3.146" transform="translate(-130.916 -250.6)" fill="#c6c6c6"/>
                                                    <path id="Path_752" data-name="Path 752" d="M151.652,362.668h24.669a1.573,1.573,0,1,0,0-3.146H151.652a1.573,1.573,0,0,0,0,3.146Z" transform="translate(-130.916 -313.616)" fill="#c6c6c6"/>
                                                    <path id="Path_753" data-name="Path 753" d="M151.652,217.628h11.941a1.573,1.573,0,0,0,0-3.146H151.652a1.573,1.573,0,1,0,0,3.146" transform="translate(-130.916 -187.096)" fill="#c6c6c6"/>
                                                    <path id="Path_754" data-name="Path 754" d="M165.881,142.242H151.652a1.573,1.573,0,1,0,0,3.146h14.229a1.573,1.573,0,1,0,0-3.146" transform="translate(-130.916 -124.08)" fill="#c6c6c6"/>
                                                    <path id="Path_755" data-name="Path 755" d="M177.822,70.454a1.587,1.587,0,0,0-1.573-1.573h-24.6a1.573,1.573,0,1,0,0,3.146h24.669a1.527,1.527,0,0,0,1.5-1.573Z" transform="translate(-130.916 -60.086)" fill="#c6c6c6"/>
                                                    <path id="Path_756" data-name="Path 756" d="M330.759,160.618l-6.364-6.364a11.632,11.632,0,1,0-9.224,4.576,11.768,11.768,0,0,0,7.079-2.431l6.364,6.364a1.577,1.577,0,0,0,1.072.429,1.455,1.455,0,0,0,1.072-.429A1.433,1.433,0,0,0,330.759,160.618Zm-24.1-13.443a8.58,8.58,0,1,1,8.58,8.58,8.605,8.605,0,0,1-8.58-8.58" transform="translate(-264.761 -118.216)" fill="#d43031"/>
                                                    <path id="Path_757" data-name="Path 757" d="M363.59,197.611l-3.074,3.432-1.359-1.5a1.52,1.52,0,0,0-2.288,2l2.5,2.789a1.423,1.423,0,0,0,1.144.5,1.688,1.688,0,0,0,1.144-.5l4.219-4.719a1.489,1.489,0,0,0-.143-2.145A1.564,1.564,0,0,0,363.59,197.611Z" transform="translate(-310.963 -171.941)" fill="#d43031"/>
                                                </g>
                                            </svg>
                                        </div>

                                        <div className="content-area">
                                            <h4 className="default-subheading white mb-6">
                                                Surveyor Services
                                            </h4>
                                            <p className="default-content white">
                                                Keep consistent with the expected quality of your shipment's condition of goods, ensure they’re packed correctly, and comply with relevant regulations and industry standards. Saving you costly mistakes like damaged shipping and non-compliant goods.
                                                <br /><br />
                                                Quickly assess and manage risks associated with shipping, like cargo damage, theft, or loss. Proactively Implement effective solutions to mitigate them, limit the chances of mistakes, and minimize the impact of any issues that may arise.
                                            </p>

                                            <a href="#" className="default-button white mt-10">
                                                LEARN MORE
                                            </a>
                                        </div>

                                    </div>
                                </div>

                                <div className="image-holder md:w-5/12 ml-auto">
                                    <img src="/images/services-surveyor.jpg" alt="" />
                                </div>
                            </div>
                        </div>
                        
                        </Slider>
                    </div>
                    
                </div>
            </section>
        </div>
      );
    }
  }