import {Head} from "@inertiajs/react";
import Radiobox from "@/Components/Radiobox";
import SearchResultCard from "@/Components/SearchResultCard";
import {Tabs} from "antd";

export default function HotDeals({hot_deals_collection}){
    const results  = hot_deals_collection?.data ?? [];

    return (
        <>
            <Head title="Hot Deals" />

            <section className="max-w-screen-4xl mx-auto">
                <div className='default-container my-16'>
                    <h2 className="default-heading small-heading mb-2">
                        Hot Deals
                    </h2>

                    <div className="flex xl:flex-row flex-col gap-6">
                        <div className="xl:w-3/12">
                            <div className="shadow-box small-box sticky top-0">
                                <div className="filter-box">
                                    <h2 className="default-heading small-size mb-6">
                                        filter
                                    </h2>

                                    <form className="default-form">
                                        <div className="filter-container">
                                            <p className="title">
                                                type of container
                                            </p>
                                            <div className='form-field radio-field'>
                                                <Radiobox name="container-size" />
                                                <span className='text'>
                                                    20' Standard
                                                </span>
                                            </div>

                                            <div className='form-field radio-field'>
                                                <Radiobox name="container-size" />
                                                <span className='text'>
                                                    40' Standard
                                                </span>
                                            </div>

                                            <div className='form-field radio-field'>
                                                <Radiobox name="container-size" />
                                                <span className='text'>
                                                    40' High Cube
                                                </span>
                                            </div>

                                            <div className='form-field radio-field'>
                                                <Radiobox name="container-size" />
                                                <span className='text'>
                                                    20' Refrigerated
                                                </span>
                                            </div>

                                            <div className='form-field radio-field'>
                                                <Radiobox name="container-size" />
                                                <span className='text'>
                                                    40' Refrigerated
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        {results.length > 0 ? (
                            <div className='xl:w-9/12'>
                                <div className="search-result-filters">
                                    <Tabs items={[
                                        {
                                            label: `Featured`,
                                            key: 'featured',
                                            children: results.map((result, index) => {
                                                return (<SearchResultCard
                                                    result={result}
                                                    key={`schedule-${index}`}
                                                />)
                                            }),
                                        },
                                        {
                                            label: `Fastest`,
                                            key: 'fastest',
                                            children: results?.sort((item1, item2) => {
                                                return item1.tt - item2.tt
                                            })
                                                ?.map((result, index) => {
                                                    return (<SearchResultCard
                                                        result={result}
                                                        key={`schedule-${index}`}
                                                    />)
                                                }),
                                        },
                                        {
                                            label: `Cheapest`,
                                            key: 'cheapest',
                                            children: results?.sort((item1, item2) => {
                                                return item1.price_amount - item2.price_amount
                                            })
                                                ?.map((result, index) => {
                                                    return (<SearchResultCard
                                                        result={result}
                                                        key={`schedule-${index}`}
                                                    />)
                                                }),
                                        },
                                    ]} />
                                </div>
                            </div>
                        ): (
                            <div className="xl:w-6/12">
                                <h2 className="default-heading small-size mb-6">
                                    No Deals Found...
                                </h2>
                            </div>
                        )}
                    </div>
                </div>
            </section>

        </>
    )
}
