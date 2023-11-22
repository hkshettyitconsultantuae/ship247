import { Head } from '@inertiajs/react';
import Benefits from '@/Includes/BenefitSlider';
import Services from '@/Includes/ServiceSlider';
import RegistrationCta from '@/Includes/RegisterCta';
import LatestNews from '@/Includes/LatestNews';
import ClientsLogo from '@/Includes/ClientLogos';
import TopDealSlider from '@/Includes/TopDealSlider';
import SearchbarForm from "@/Components/SearchbarForm";

export default function Home({hot_deals_collection, news_listing}) {
    const handleSearchbarFormCallback = (values) => {
        const query = new URLSearchParams(values);
        window.location = route('pages.searchresults') + '?' + query.toString();
    }

    return (
        <>
            <Head title="Home" />

            {/* Banner */}
            <section className="banner-bg-area test">
                <section className="max-w-screen-4xl mx-auto">
                    <div className="homepage-banner default-container">
                        <div className="content">
                            <h4 className="subtitle">WE OPEN</h4>
                            <h2 className="title">THE WORLD TO YOU</h2>
                            <h6 className="desc">Custom shipping solutions opening you up to a world of opportunities.</h6>
                        </div>

                        <div className="search-panel">
                            <SearchbarForm callback={handleSearchbarFormCallback}/>
                        </div>
                    </div>
                </section>

                <Benefits />
            </section>

            {/* Top Deals */}
            <TopDealSlider deals={hot_deals_collection?.data ?? []}/>

            {/* Services */}
            <Services />

            {/* Register CTA */}
            <RegistrationCta />

            {/* Latest News */}
            <LatestNews news={news_listing}/>

            {/* Client Logos */}
            <ClientsLogo />

        </>
    )
}
