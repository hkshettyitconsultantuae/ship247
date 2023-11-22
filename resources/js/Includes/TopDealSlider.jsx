import React, { Component } from 'react';
import Slider from "react-slick";
import {Link} from "@inertiajs/react";
import {currencyFormatter} from "../../views/helpers/helpers";

export default class TopDealSlider extends Component {
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
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {
              breakpoint: 1200,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true
              }
            }
          ]
      };
      return (
        <div className="bg-white">
            <section className="max-w-screen-4xl mx-auto">
                <div className="top-deals-section default-container">
                    <div className="relative">
                        <h2 className="default-heading">
                        Hot DEALS
                        </h2>

                        <div className='absolute top-8 right-0 hidden md:block'>
                            <Link href="/hot-deals" className="default-button red">
                                <span>view all</span>
                            </Link>
                        </div>
                    </div>

                        {/* <div className="slider-arrows desktop-arrows">
                            <a href="javascript:;" className="topdeals-image-prev" onClick={this.previous}>
                                <img src="/images/svg/left-arrow-icon.svg" alt="" />
                            </a>
                            <a href="javascript:;" className="topdeals-image-next" onClick={this.next}>
                                <img src="/images/svg/right-arrow-icon.svg" alt="" />
                            </a>
                        </div> */}

                        <Slider ref={c => (this.slider = c)} {...settings} className="topdeals-image-slider">
                            {this.props?.deals?.map(deal => {
                               return (<div className="item" key={deal.id}>
                                    <div className="topdeal-box">
                                        <div className="inner-box flex-col gap-6">
                                            <div className="flex w-full items-center">
                                                <div className="w-7/12">
                                                    <div className="flex items-center">
                                                        <i className="icon ship">
                                                            <img src="/images/svg/ship.svg" alt=""/>
                                                        </i>
                                                        <p className="container-size">
                                                            <span>container</span>
                                                            {deal?.container_size?.display_label}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div className="w-5/12 ml-auto">
                                                    <p className="pricing ml-auto">
                                                        <span>Starting From</span>
                                                        {currencyFormatter(deal?.price_amount)}
                                                    </p>
                                                </div>
                                            </div>

                                            <div className="flex w-full sm:flex-row flex-col sm:gap-0 gap-4">
                                                <div className="w-7/12">
                                                    <p className="country">
                                                        <span>Origin</span>
                                                        {(deal?.origin?.city ?? deal?.origin?.port) + ', ' + deal?.origin?.country?.code}
                                                    </p>
                                                </div>
                                                <div className="w-5/12 sm:ml-auto ml-0">
                                                    <p className="country">
                                                        <span>Destination</span>
                                                        {(deal?.destination?.city ?? deal?.destination?.port) + ', ' + deal?.destination?.country?.code}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>)
                            })}
                        </Slider>

                        <div className='text-center mt-12 block md:hidden'>
                            <Link href="/hot-deals" className="default-button red">
                                <span>view all deals</span>
                            </Link>
                        </div>

                    {/* <div className="slider-arrows mobile-arrows">
                        <a href="javascript:;" className="topdeals-image-prev" onClick={this.previous}>
                            <img src="/images/svg/left-arrow-icon.svg" alt="" />
                        </a>
                        <a href="javascript:;" className="topdeals-image-next" onClick={this.next}>
                            <img src="/images/svg/right-arrow-icon.svg" alt="" />
                        </a>
                    </div> */}
                </div>
            </section>
        </div>
      );
    }
}
