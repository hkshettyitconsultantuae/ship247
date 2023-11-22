import {Head, Link} from "@inertiajs/react";
import LatestNewsBox from "@/Components/LatestNewsBox";
import NewsBox from "@/Components/NewsBox";

const NewsListing = ({news_listing, latest_news, total_news, page, limit}) => {


    return <>
        <Head title="News" />

        <section className="max-w-screen-4xl mx-auto">
            <div className="default-container">
                <h4 className='default-heading mt-10'>Latest News</h4>
                {latest_news && <LatestNewsBox news={latest_news}/>}

                <hr className="my-[60px] border-2" />

                <div className="grid xl:grid-cols-3 lg:grid-cols-2 gap-6">
                    {news_listing.map(news => <NewsBox news={news} />)}
                </div>
            </div>
        </section>

        <ul className={"pagination"}>
            {Array.from(Array(Math.ceil(total_news/limit))).map((e,i)=>i+1)
                .map(_page => <li>
                    <Link className={page === _page ? 'active' : ''} href={'/news/?page='+_page} >{_page}</Link>
                </li>)}
        </ul>
        </>;
}

export default NewsListing;
