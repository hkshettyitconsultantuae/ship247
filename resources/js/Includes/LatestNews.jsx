import React, { Component } from "react";
import Slider from "react-slick";
import {Link} from "@inertiajs/react";
import dayjs from "dayjs";

const shortenText = (text,max) =>{
    return text && text.length > max ? text.slice(0,max).split(' ').slice(0, -1).join(' ') : text
}
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
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
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
        <section className="max-w-screen-4xl mx-auto">
            <div className="latest-news default-container">

                <div className="flex">
                    <div className="w-8/12">
                        <h4 className="default-heading">
                            latest news
                        </h4>
                    </div>

                    <div className="w-3/12 ml-auto">
                        <div className="slider-arrows desktop-arrows ml-auto">
                            <a href="javascript:;" className="services-image-prev" onClick={this.previous}>
                                <img src="/images/svg/left-arrow-icon.svg" alt="" />
                            </a>
                            <a href="javascript:;" className="services-image-next" onClick={this.next}>
                                <img src="/images/svg/right-arrow-icon.svg" alt="" />
                            </a>
                        </div>
                    </div>
                </div>

                <Slider ref={c => (this.slider = c)} {...settings} className="news-slider">
                    {this.props?.news?.map(news =>
                        <div className="item">
                            <div className="news-box">
                                <h4 className="default-subheading leading-tight">
                                    {shortenText(news.title.replace( /(<([^>]+)>)/ig, ''), 40)+'...'}
                                </h4>
                                <p className="default-content">
                                    {shortenText(news.detail.replace( /(<([^>]+)>)/ig, ''), 80)+'...'}
                                </p>

                                <footer>
                                    <p className="date">
                                        {dayjs(news.published_date).format('DD MMM YYYY')}
                                    </p>
                                    <Link href={'/news/'+news.id} className="default-button red">
                                        read more
                                    </Link>
                                </footer>
                            </div>
                        </div>
                    )}
                </Slider>

                <div className="text-center">
                    <Link href="/news" className="default-button red">
                        view all
                    </Link>
                </div>

            </div>
        </section>
      );
    }
  }


// import React from "react";

// export default function Services() {
//     return (<section className="max-w-screen-3xl mx-auto">
//     <div className="latest-news default-container">
//         <h4 className="default-heading">
//             latest news
//         </h4>

//         <div className="news-slider">
//             <div className="news-box">
//                 <h4 className="default-subheading">
//                     SHIPPING INDUSTRY EXPECTED TO GROW 3.2% IN 2025
//                 </h4>
//                 <p className="default-content">
//                     shipping industry is subject to various factors that can impact its growth
//                 </p>

//                 <footer>
//                     <p className="date">
//                         23 AUG 2023
//                     </p>
//                     <a href="#" className="default-button red">
//                         read more
//                     </a>
//                 </footer>
//             </div>

//             <div className="news-box">
//                 <h4 className="default-subheading">
//                     SHIPPING INDUSTRY EXPECTED TO GROW 3.2% IN 2025
//                 </h4>
//                 <p className="default-content">
//                     shipping industry is subject to various factors that can impact its growth
//                 </p>

//                 <footer>
//                     <p className="date">
//                         23 AUG 2023
//                     </p>
//                     <a href="#" className="default-button red">
//                         read more
//                     </a>
//                 </footer>
//             </div>

//             <div className="news-box">
//                 <h4 className="default-subheading">
//                     SHIPPING INDUSTRY EXPECTED TO GROW 3.2% IN 2025
//                 </h4>
//                 <p className="default-content">
//                     shipping industry is subject to various factors that can impact its growth
//                 </p>

//                 <footer>
//                     <p className="date">
//                         23 AUG 2023
//                     </p>
//                     <a href="#" className="default-button red">
//                         read more
//                     </a>
//                 </footer>
//             </div>
//         </div>

//         <div className="text-center">
//             <a href="#" className="default-button red">
//                 view all
//             </a>
//         </div>
//     </div>
// </section>)
// }



