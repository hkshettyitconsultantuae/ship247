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
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 676,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true
              }
            }
        ]
      };
      return (
        <section className="max-w-screen-3xl mx-auto">
            <div className="clients default-container">

                <Slider ref={c => (this.slider = c)} {...settings} className="services-image-slider">
                    <div className="item">
                        <img src="/images/client/logo1.png" alt="" className="m-auto" />
                    </div>

                    <div className="item">
                        <img src="/images/client/logo2.png" alt="" className="m-auto" />
                    </div>

                    <div className="item">
                        <img src="/images/client/logo3.png" alt="" className="m-auto" />
                    </div>

                    <div className="item">
                        <img src="/images/client/logo4.png" alt="" className="m-auto" />
                    </div>
                </Slider>
                
            </div>
        </section>
      );
    }
  }