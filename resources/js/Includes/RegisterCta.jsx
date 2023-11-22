import React from "react";

export default function Services() {
    return (<section className="max-w-screen-3xl mx-auto">
    <div className="register-cta default-container">
        <div className="md:w-8/12">
            <div className="inner">
                <div className="icon">
                    <img src="/images/svg/register-icon.svg" alt="" />
                </div>
                <div className="content">
                    <h2 className="default-heading white">
                        work with us
                    </h2>
                    <h6 className="default-content white">
                    Connect to carriers in new markets, conserve capital, and grow your business.
                    </h6>
                </div>
            </div>
        </div>

        <div className="button ml-auto">
            <a href="/register" className="register-button">
                Register NOW
            </a>
        </div>
    </div>
</section>)
}
