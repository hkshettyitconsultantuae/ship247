import React from "react";
import ClientsSlider from '@/Includes/ClientsSlider';

export default function Services() {
    return (<section className="client-logos">
    <div className="max-w-screen-4xl mx-auto">
        <div className="default-container">
            <h4 className="default-heading text-center">
            We’re proud to work with
            </h4>

            <div className="md:pt-4">
                <ClientsSlider />
            </div>

        </div>
    </div>
</section>)
}
